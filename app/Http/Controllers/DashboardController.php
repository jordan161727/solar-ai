<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Property;

class DashboardController extends Controller
{
      public function index()
    {
         
        $stats = [

            'properties' => Property::count(),

            'verified' => Property::where('status', 'Verified')->count(),

            'pending' => Property::where('status', 'Pending')->count(),

            'savings' => Property::sum('estimated_savings'),

            'generation' => Property::sum('estimated_generation'),

            'solarScore' => round(Property::avg('solar_score') ?? 0),

            'todayProjects' => Property::whereDate('created_at', today())->count(),

            'customers' => Property::distinct('owner_name')->count(),

        ];

        $recentProperties = Property::latest()->take(5)->get();
        $user = auth()->user();
        return view('dashboard.index', compact(
            'stats',
            'recentProperties',
            'user'
        ));
    }
}
