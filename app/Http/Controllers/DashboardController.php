<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function kasirDashboard()
    {
        $userId = Auth::id();

        // Statistik hari ini
        $today = Carbon::today();
        $todayTransactions = Transaction::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->count();
        $todayRevenue = Transaction::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->sum('total_amount');

        // Statistik bulan ini
        $thisMonth = Carbon::now();
        $monthlyTransactions = Transaction::where('user_id', $userId)
            ->whereMonth('created_at', $thisMonth->month)
            ->whereYear('created_at', $thisMonth->year)
            ->count();
        $monthlyRevenue = Transaction::where('user_id', $userId)
            ->whereMonth('created_at', $thisMonth->month)
            ->whereYear('created_at', $thisMonth->year)
            ->sum('total_amount');

        // Transaksi terbaru (5 terakhir)
        $recentTransactions = Transaction::where('user_id', $userId)
            ->with(['details.product'])
            ->latest()
            ->take(5)
            ->get();

        // Produk dengan stok rendah
        $lowStockProducts = Product::with('category')
            ->where('stock', '<=', 10)
            ->where('status', 'active')
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        // Total produk aktif
        $activeProducts = Product::where('status', 'active')->count();

        // Statistik performa mingguan (7 hari terakhir)
        $weeklyStats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dayTransactions = Transaction::where('user_id', $userId)
                ->whereDate('created_at', $date)
                ->count();
            $dayRevenue = Transaction::where('user_id', $userId)
                ->whereDate('created_at', $date)
                ->sum('total_amount');

            $weeklyStats[] = [
                'date' => $date->format('d/m'),
                'day' => $date->format('D'),
                'transactions' => $dayTransactions,
                'revenue' => $dayRevenue
            ];
        }

        return view('kasir.dashboard', compact(
            'todayTransactions',
            'todayRevenue',
            'monthlyTransactions',
            'monthlyRevenue',
            'recentTransactions',
            'lowStockProducts',
            'activeProducts',
            'weeklyStats'
        ));
    }

    public function adminDashboard()
    {
        // Statistik Umum
        $totalUsers = User::count();
        $totalKasir = User::where('role', 'kasir')->count();
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 'active')->count();
        $inactiveProducts = Product::where('status', 'inactive')->count();
        $totalCategories = Category::count();

        // Statistik Transaksi
        $today = Carbon::today();
        $thisMonth = Carbon::now();
        $thisYear = Carbon::now();

        // Hari ini
        $todayTransactions = Transaction::whereDate('created_at', $today)->count();
        $todayRevenue = Transaction::whereDate('created_at', $today)->sum('total_amount');

        // Bulan ini
        $monthlyTransactions = Transaction::whereMonth('created_at', $thisMonth->month)
            ->whereYear('created_at', $thisMonth->year)
            ->count();
        $monthlyRevenue = Transaction::whereMonth('created_at', $thisMonth->month)
            ->whereYear('created_at', $thisMonth->year)
            ->sum('total_amount');

        // Tahun ini
        $yearlyTransactions = Transaction::whereYear('created_at', $thisYear->year)->count();
        $yearlyRevenue = Transaction::whereYear('created_at', $thisYear->year)->sum('total_amount');

        // Top Products (bulan ini)
        $topProducts = DB::table('transaction_details')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereMonth('transactions.created_at', $thisMonth->month)
            ->whereYear('transactions.created_at', $thisMonth->year)
            ->select(
                'products.name as product_name',
                'categories.name as category_name',
                DB::raw('SUM(transaction_details.quantity) as total_sold'),
                DB::raw('SUM(transaction_details.subtotal) as total_revenue'),
                'products.stock'
            )
            ->groupBy('products.id', 'products.name', 'categories.name', 'products.stock')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        // Low Stock Products
        $lowStockProducts = Product::with('category')
            ->where('stock', '<=', 10)
            ->where('status', 'active')
            ->orderBy('stock', 'asc')
            ->limit(10)
            ->get();

        // Recent Transactions (10 terakhir)
        $recentTransactions = Transaction::with(['user', 'details.product'])
            ->latest()
            ->limit(10)
            ->get();

        // Monthly Revenue Chart Data (12 bulan terakhir)
        $monthlyRevenueChart = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $revenue = Transaction::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_amount');
            $monthlyRevenueChart->push([
                'month' => $date->format('M Y'),
                'revenue' => $revenue
            ]);
        }

        // Kasir Performance (bulan ini) - FIXED: Menggunakan query builder manual
        $kasirPerformance = DB::table('users')
            ->leftJoin('transactions', function ($join) use ($thisMonth) {
                $join->on('users.id', '=', 'transactions.user_id')
                    ->whereMonth('transactions.created_at', $thisMonth->month)
                    ->whereYear('transactions.created_at', $thisMonth->year);
            })
            ->where('users.role', 'kasir')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COUNT(transactions.id) as monthly_transactions'),
                DB::raw('COALESCE(SUM(transactions.total_amount), 0) as monthly_revenue')
            )
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderByDesc('monthly_revenue')
            ->get();

        // Category Performance
        $categoryPerformance = Category::withCount('products')
            ->get()
            ->map(function ($category) use ($thisMonth) {
                $categoryRevenue = DB::table('transaction_details')
                    ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
                    ->join('products', 'transaction_details.product_id', '=', 'products.id')
                    ->where('products.category_id', $category->id)
                    ->whereMonth('transactions.created_at', $thisMonth->month)
                    ->whereYear('transactions.created_at', $thisMonth->year)
                    ->sum('transaction_details.subtotal');

                $activeProductsCount = Product::where('category_id', $category->id)
                    ->where('status', 'active')
                    ->count();

                $category->monthly_revenue = $categoryRevenue;
                $category->active_products_count = $activeProductsCount;
                return $category;
            })
            ->sortByDesc('monthly_revenue');

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalKasir',
            'totalProducts',
            'activeProducts',
            'inactiveProducts',
            'totalCategories',
            'todayTransactions',
            'todayRevenue',
            'monthlyTransactions',
            'monthlyRevenue',
            'yearlyTransactions',
            'yearlyRevenue',
            'topProducts',
            'lowStockProducts',
            'recentTransactions',
            'monthlyRevenueChart',
            'kasirPerformance',
            'categoryPerformance'
        ));
    }
}
