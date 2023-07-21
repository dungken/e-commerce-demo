<?php

namespace App\Http\Controllers;

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
        $orders = Order::orderBy('id', 'desc')->paginate(4);
        $cnt_order_completed = Order::where('status', 'completed')->count();
        $cnt_order_processing = Order::where('status', 'processing')->count();
        $cnt_total_revenue = 0;
        foreach (Order::where('status', 'completed')->get() as $e) {
            $cnt_total_revenue += $e['qty'] * $e['price'];
        }
        $cnt_total_trash = Order::onlyTrashed()->count();

        $cnt = [$cnt_order_completed, $cnt_order_processing, $cnt_total_revenue, $cnt_total_trash];

        return view('admin.dashboard', compact('orders', 'cnt'));
    }

    public function delete($id)
    {
        Order::destroy($id);
        return redirect('dashboard')->with('status', 'Đã xóa thành công');
    }
}
