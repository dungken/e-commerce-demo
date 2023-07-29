<?php

namespace App\Http\Controllers;

use App\Client;
use App\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['mod_active' => 'dashboard']);
            return $next($request);
        });
    }

    public function show()
    {
        $clients = Client::orderBy('id', 'desc')->paginate(8);

        $cnt_order_paid = Client::where('status', 'paid')->count();

        $cnt_order_pending = Client::where('status', 'pending')->count();

        $cnt_order_cancel = Client::onlyTrashed()->count();


        $cnt_total_revenue = 0;

        foreach (Client::where('status', 'paid')->get() as $e) {
            $cnt_total_revenue += $e['total'];
        }

        $cnt = [$cnt_order_paid, $cnt_order_pending, $cnt_total_revenue, $cnt_order_cancel];

        return view('admin.dashboard', compact('clients', 'cnt'));
    }
}
