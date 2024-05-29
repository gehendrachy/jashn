<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */

class DashboardController extends Controller
{
    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Super Admin', ['only' => ['index']]);
        
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $products_count = Product::all()->count();
        $orders_count = Order::all()->count();
        $customers_count = User::role('customer')->count();
        return view('backend.dashboard', compact('products_count', 'orders_count', 'customers_count'));
    }
}
