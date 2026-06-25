<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    
    public function index()
    {
        $totalExpenses = Purchase::sum('total');
        $totalStock = Stock::sum('quantity');
        $totalProduct = Product::count();
        $totalRevenue = Sale::sum('total');

        $recentPurchases = Purchase::with('details.product')->orderBy('purchase_date', 'desc')->take(5)->get();
        $recentSales = Sale::with('details.product')->orderBy('sale_date', 'desc')->take(5)->get();

        $purchasesChart = Purchase::select(
            DB::raw('DATE(purchase_date) as date'),
            DB::raw('SUM(total) as total')
        )
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $purchasesChartData = $purchasesChart->map(function ($item) {
            return [
                'date' => $item->date,
                'total' => $item->total,
            ];
        });

        return view('dashboard', compact(
            'totalExpenses',
            'totalStock',
            'totalProduct',
            'totalRevenue',
            'recentPurchases',
            'recentSales',
            'purchasesChartData'
        ));
    }
}
