<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();

        $totalCustomers = Customer::count();

        $totalSales = Sale::count();

        $totalRevenue = Sale::sum('total_price');

        return view('dashboard', compact(
            'totalProducts',
            'totalCustomers',
            'totalSales',
            'totalRevenue'
        ));
    }
}
