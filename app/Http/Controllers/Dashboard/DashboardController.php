<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Tank;
use App\Models\TankType;
use App\Models\TankUse;
use App\Models\DeliveryLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:access-dashboard')->only('index');
    }

    public function index()
    {
        $user = auth()->user();
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard.index')],
        ];
        return view('dashboard.pages.index', compact('user', 'breadcrumbs'));
    }

    public function analytics()
    {
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard.index')],
            ['title' => 'Analytics', 'url' => route('dashboard.analytics.index')],
        ];
        $user = auth()->user();

        // Data for Tank Fill Levels graph - get 5 tanks with lowest fill percentage
        $tankFillLevels = Tank::select('name', 'fill_percentage', 'quantity')
            ->orderBy('fill_percentage', 'asc')  // Changed to ascending to get lowest first
            ->limit(5)  // Changed to 5 tanks
            ->get();

        // Data for Tank Types Distribution graph
        $tankTypeDistribution = Tank::select('tank_type_id', DB::raw('count(*) as count'))
            ->groupBy('tank_type_id')
            ->with('tankType')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->tankType->type ?? 'Unknown',
                    'count' => $item->count
                ];
            });

        // Data for Monthly Deliveries graph
        $monthlyDeliveries = DeliveryLog::select(
            DB::raw('MONTH(delivery_date) as month'),
            DB::raw('YEAR(delivery_date) as year'),
            DB::raw('SUM(quantity) as total_quantity')
        )
            ->whereYear('delivery_date', Carbon::now()->year)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                $monthName = Carbon::createFromDate($item->year, $item->month, 1)->format('M');
                return [
                    'month' => $monthName,
                    'total' => $item->total_quantity
                ];
            });

        // Data for Tank Usage Distribution graph
        $tankUsageDistribution = Tank::select('tank_use_id', DB::raw('count(*) as count'))
            ->groupBy('tank_use_id')
            ->with('tankUse')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->tankUse->name ?? 'Unknown',
                    'count' => $item->count
                ];
            });

        // Summary statistics
        $totalTanks = Tank::count();
        $totalTankTypes = TankType::count();
        $totalTankUses = TankUse::count();
        $totalDeliveries = DeliveryLog::count();

        // Low stock tanks (below 50 quantity instead of 20% fill)
        $lowStockTanks = Tank::where('quantity', '<', 50)->count();

        // Recent deliveries
        $recentDeliveries = DeliveryLog::with('tank')
            ->orderBy('delivery_date', 'desc')
            ->limit(5)
            ->get();

        // Delivery trends - compare current month with previous month
        $currentMonthDeliveries = DeliveryLog::whereMonth('delivery_date', Carbon::now()->month)
            ->whereYear('delivery_date', Carbon::now()->year)
            ->sum('quantity');

        $previousMonthDeliveries = DeliveryLog::whereMonth('delivery_date', Carbon::now()->subMonth()->month)
            ->whereYear('delivery_date', Carbon::now()->subMonth()->year)
            ->sum('quantity');

        $deliveryTrend = $previousMonthDeliveries > 0
            ? (($currentMonthDeliveries - $previousMonthDeliveries) / $previousMonthDeliveries) * 100
            : 0;

        return view('dashboard.pages.analytics', compact(
            'user',
            'tankFillLevels',
            'tankTypeDistribution',
            'monthlyDeliveries',
            'tankUsageDistribution',
            'totalTanks',
            'totalTankTypes',
            'totalTankUses',
            'totalDeliveries',
            'lowStockTanks',
            'recentDeliveries',
            'currentMonthDeliveries',
            'previousMonthDeliveries',
            'deliveryTrend',
            'breadcrumbs'
        ));
    }
}
