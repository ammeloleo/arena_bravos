<?php

namespace App\Models;

use Database\Factories\ComandaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['label', 'customer_name', 'notes', 'status', 'payment_method', 'closed_at'])]
class Comanda extends Model
{
    /** @use HasFactory<ComandaFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'closed_at' => 'datetime',
        ];
    }

    #[Scope]
    protected function open(Builder $query): Builder
    {
        return $query->where('status', 'open');
    }

    #[Scope]
    protected function closed(Builder $query): Builder
    {
        return $query->where('status', 'closed');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ComandaItem::class);
    }

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    public function total(): float
    {
        return (float) $this->items->sum(fn (ComandaItem $item): float => $item->quantity * (float) $item->unit_price);
    }
}
