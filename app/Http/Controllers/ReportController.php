<?php

namespace App\Http\Controllers;

use App\Services\ServicesRelatorios;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request, ServicesRelatorios $reports): View
    {
        $today = CarbonImmutable::now('America/Sao_Paulo')->startOfDay();
        $validated = $request->validate([
            'date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:2000-01-01', 'before_or_equal:'.$today->toDateString()],
        ], [
            'date.date_format' => 'Selecione uma data válida.',
            'date.after_or_equal' => 'Selecione uma data a partir do ano 2000.',
            'date.before_or_equal' => 'Selecione hoje ou uma data anterior.',
        ]);

        $date = CarbonImmutable::parse($validated['date'] ?? $today->toDateString(), 'America/Sao_Paulo');

        return view('relatorios.index', $reports->gerar($date) + [
            'date' => $date,
            'today' => $today,
        ]);
    }
}
