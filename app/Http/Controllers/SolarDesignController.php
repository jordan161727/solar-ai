<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Services\PropertyInsightsService;
use App\Services\SolarLayoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SolarDesignController extends Controller
{
    public function __construct(private SolarLayoutService $layouts)
    {
    }

    /**
     * Designer landing page — pick a property to design a system for.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $properties = Property::query()
            ->with(['customer', 'solarAssessment'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest()
            ->get();

        // Straight to the designer when a property is already chosen.
        if ($request->filled('property')) {
            $property = $properties->firstWhere('id', (int) $request->query('property'));

            if ($property) {
                return redirect()->route('solar.design', $property);
            }
        }

        return view('solar.index', [
            'properties' => $properties,
        ]);
    }

    /**
     * The designer itself, for one property.
     */
    public function design(Request $request, Property $property): View
    {
        $property->load(['customer', 'solarAssessment']);

        $assessment = $property->solarAssessment;

        // Nothing to draw without an assessment — the view offers to run one.
        if ($assessment === null || blank($assessment->panel_layout)) {
            return view('solar.design', [
                'property' => $property,
                'assessment' => $assessment,
                'layout' => null,
                'design' => null,
            ]);
        }

        $panelCount = (int) $request->query(
            'panels',
            $assessment->selected_panel_count ?: $assessment->max_panels
        );

        $panelCount = max(1, min($panelCount, count($assessment->panel_layout)));

        return view('solar.design', [
            'property' => $property,
            'assessment' => $assessment,
            'layout' => $this->layouts->forAssessment(
                $assessment,
                (float) $property->latitude,
                (float) $property->longitude,
            ),
            'design' => $this->summarise($assessment, $panelCount),
        ]);
    }

    /**
     * Persist the chosen system size.
     */
    public function store(Request $request, Property $property): RedirectResponse
    {
        $assessment = $property->solarAssessment;

        abort_if($assessment === null, 404);

        $validated = $request->validate([
            'panels' => 'required|integer|min:1|max:'.max(count($assessment->panel_layout ?? []), 1),
        ]);

        $summary = $this->summarise($assessment, (int) $validated['panels']);

        $assessment->update([
            'selected_panel_count' => $summary['panels'],
            'system_size_kw' => $summary['system_kw'],
            'annual_generation' => $summary['annual_kwh'],
            'monthly_generation' => round($summary['annual_kwh'] / 12, 2),
            'estimated_savings' => $summary['annual_savings'],
            'co2_offset' => $summary['co2_kg'],
        ]);

        return redirect()
            ->route('solar.design', ['property' => $property, 'panels' => $summary['panels']])
            ->with('status', 'System design saved — '.$summary['panels'].' panels, '.$summary['system_kw'].' kW.');
    }

    /**
     * Figures for a given panel count.
     *
     * Yield comes from Google's own per-panel numbers, so the total is the sum
     * of the panels actually selected rather than a linear scaling.
     *
     * @return array<string, mixed>
     */
    private function summarise(\App\Models\SolarAssessment $assessment, int $panelCount): array
    {
        $panels = $assessment->panelsForCount($panelCount);

        $annualKwh = collect($panels)->sum(fn (array $panel) => (float) ($panel['yearlyEnergyDcKwh'] ?? 0));

        // Prefer Google's pre-computed config when one matches exactly.
        $config = $assessment->configForCount($panelCount);

        if ($config && isset($config['yearlyEnergyDcKwh'])) {
            $annualKwh = (float) $config['yearlyEnergyDcKwh'];
        }

        $watts = (int) ($assessment->panel_capacity_w ?: 400);
        $systemKw = round($panelCount * $watts / 1000, 2);

        $annualSavings = round($annualKwh * PropertyInsightsService::TARIFF_PER_KWH, 2);

        // ~PHP 55k per installed kW for PH residential.
        $installCost = round($systemKw * 55000, 2);

        return [
            'panels' => $panelCount,
            'max_panels' => count($assessment->panel_layout ?? []),
            'panel_watts' => $watts,
            'system_kw' => $systemKw,
            'annual_kwh' => round($annualKwh, 1),
            'monthly_kwh' => round($annualKwh / 12, 1),
            'annual_savings' => $annualSavings,
            'co2_kg' => round($annualKwh * PropertyInsightsService::CO2_KG_PER_KWH, 1),
            'install_cost' => $installCost,
            'payback_years' => $annualSavings > 0 ? round($installCost / $annualSavings, 1) : null,
            'monthly' => $this->layouts->monthlyProfile($annualKwh),
        ];
    }
}
