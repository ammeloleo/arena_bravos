<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ServicesRelatorios
{
    /**
     * @return array{day: array, month: array, dayChange: ?float, monthChange: ?float, daily: Collection, monthly: Collection}
     */
    public function gerar(CarbonImmutable $date): array
    {
        $start = $date->startOfMonth()->subMonthsNoOverflow(12);
        $storageTimezone = config('app.timezone');
        $connection = DB::connection();
        $sourceOffset = $date->setTimezone($storageTimezone)->format('P');
        $targetOffset = $date->format('P');
        $dayExpression = $connection->getDriverName() === 'sqlite'
            ? "date(c.closed_at, '".(-$date->setTimezone($storageTimezone)->utcOffset())." minutes', '".$date->utcOffset()." minutes')"
            : "DATE(CONVERT_TZ(c.closed_at, '$sourceOffset', '$targetOffset'))";

        $rows = DB::table('comandas as c')
            ->leftJoin('comanda_items as i', 'i.comanda_id', '=', 'c.id')
            ->where('c.status', 'closed')
            ->where('c.closed_at', '>=', $start->setTimezone($storageTimezone)->format('Y-m-d H:i:s'))
            ->where('c.closed_at', '<', $date->addDay()->setTimezone($storageTimezone)->format('Y-m-d H:i:s'))
            ->selectRaw("$dayExpression as sale_day")
            ->selectRaw('COUNT(DISTINCT c.id) as orders')
            ->selectRaw('COALESCE(SUM(i.quantity * i.unit_price), 0) as revenue')
            ->selectRaw('COALESCE(SUM(i.quantity * i.unit_cost), 0) as cost')
            ->selectRaw('COALESCE(SUM(i.quantity), 0) as units')
            ->selectRaw('SUM(CASE WHEN i.id IS NOT NULL AND i.unit_cost IS NULL THEN i.quantity ELSE 0 END) as missing_cost')
            ->groupByRaw($dayExpression)
            ->orderBy('sale_day')
            ->get();

        $day = $this->resumir($rows->where('sale_day', $date->toDateString()));
        $month = $this->resumir($rows->whereBetween('sale_day', [$date->startOfMonth()->toDateString(), $date->toDateString()]));
        $previousMonth = $date->subMonthNoOverflow();
        $previousDay = $this->resumir($rows->where('sale_day', $date->subDay()->toDateString()));
        $previousMonthSummary = $this->resumir($rows->whereBetween('sale_day', [
            $previousMonth->startOfMonth()->toDateString(),
            $previousMonth->toDateString(),
        ]));

        $daily = collect();
        for ($cursor = $date->startOfMonth(); $cursor <= $date; $cursor = $cursor->addDay()) {
            $daily->push([
                'label' => $cursor->format('d/m'),
                ...$this->resumir($rows->where('sale_day', $cursor->toDateString())),
            ]);
        }

        $monthly = collect();
        for ($cursor = $date->startOfMonth()->subMonthsNoOverflow(11); $cursor <= $date; $cursor = $cursor->addMonth()) {
            $monthly->push([
                'label' => $cursor->format('m/Y'),
                ...$this->resumir($rows->whereBetween('sale_day', [
                    $cursor->toDateString(),
                    $cursor->endOfMonth()->toDateString(),
                ])),
            ]);
        }

        return [
            'day' => $day,
            'month' => $month,
            'dayChange' => $this->variacao($day['revenue'], $previousDay['revenue']),
            'monthChange' => $this->variacao($month['revenue'], $previousMonthSummary['revenue']),
            'daily' => $daily,
            'monthly' => $monthly,
        ];
    }

    /**
     * @return array{revenue: float, cost: float, orders: int, units: int, missingCost: int, profit: ?float, margin: ?float, ticket: float}
     */
    private function resumir(Collection $rows): array
    {
        $revenue = round((float) $rows->sum('revenue'), 2);
        $cost = round((float) $rows->sum('cost'), 2);
        $orders = (int) $rows->sum('orders');
        $missing = (int) $rows->sum('missing_cost');
        $profit = $missing === 0 ? round($revenue - $cost, 2) : null;

        return [
            'revenue' => $revenue,
            'cost' => $cost,
            'orders' => $orders,
            'units' => (int) $rows->sum('units'),
            'missingCost' => $missing,
            'profit' => $profit,
            'margin' => $profit !== null && $revenue > 0 ? round($profit / $revenue * 100, 1) : null,
            'ticket' => $orders > 0 ? round($revenue / $orders, 2) : 0.0,
        ];
    }

    private function variacao(float $current, float $previous): ?float
    {
        return $previous > 0 ? round(($current - $previous) / $previous * 100, 1) : null;
    }
}
