<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function sales_reports(Request $request)
    {
    	
    	$order_status = Order::order_status();

    	if (isset($request->date_filter)) {

            $parts = explode(' - ' , $request->date_filter);
            $date_from = $parts[0];
            $date_to = $parts[1];
            $orders = Order::where('created_at', '>=', $date_from." 00:00:00")->where('created_at', '<=', $date_to." 23:59:59")->orderBy('created_at');
            
        } else {

            $carbon_date_from = new Carbon('last Monday');
            $date_from = $carbon_date_from->toDateString();
            $carbon_date_to = new Carbon('this Sunday');
            $date_to = $carbon_date_to->toDateString();

            $orders = Order::orderBy('created_at','desc');
        }

        $orders = $orders->get();

        // dd($request->date_filter);
        

        return view('backend.reports.sales-reports', compact('orders','order_status'));
    }
}
