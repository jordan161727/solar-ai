<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Property;
use App\Models\Customer;
use App\Models\SolarAssessment;

class DashboardController extends Controller
{
      public function index()
    {

        $stats = [

            'properties' => Property::count(),

            'verified' => Property::where('status', 'Completed')->count(),

            'pending' => Property::where('status', 'Pending')->count(),

            // Savings, generation and score live on solar_assessments, not properties
            'savings' => SolarAssessment::sum('estimated_savings'),

            'generation' => SolarAssessment::sum('annual_generation'),

            'solarScore' => round(SolarAssessment::avg('solar_score') ?? 0),

            'todayProjects' => Property::whereDate('created_at', today())->count(),

            'customers' => Customer::count(),

        ];

        $recentProperties = Property::with(['customer', 'solarAssessment'])
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard.index', [
            'stats' => $stats,
            'recentProperties' => $recentProperties,
            'series' => $this->monthlySeries(),
            'statusBreakdown' => $this->statusBreakdown($stats['properties']),
            'user' => auth()->user(),
        ]);
    }

    /**
     * Properties added per month for the last 6 months, oldest first.
     *
     * Bucketed in PHP rather than SQL so the grouping expression stays
     * portable across database drivers.
     */
    private function monthlySeries(): array
    {
        $start = now()->startOfMonth()->subMonths(5);

        $counts = Property::where('created_at', '>=', $start)
            ->get(['created_at'])
            ->groupBy(fn ($property) => $property->created_at->format('Y-m'))
            ->map->count();

        return collect(range(5, 0))
            ->map(function ($offset) use ($counts) {
                $month = now()->startOfMonth()->subMonths($offset);

                return [
                    'label' => $month->format('M'),
                    'value' => $counts->get($month->format('Y-m'), 0),
                ];
            })
            ->all();
    }

    /**
     * Share of each pipeline status, as whole percentages.
     */
    private function statusBreakdown(int $total): array
    {
        $counts = Property::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return collect(['Completed', 'Analyzing', 'Pending'])
            ->map(function ($status) use ($counts, $total) {
                $count = (int) $counts->get($status, 0);

                return [
                    'status' => $status,
                    'count' => $count,
                    'percent' => $total > 0 ? round($count / $total * 100) : 0,
                ];
            })
            ->all();
    }
}
