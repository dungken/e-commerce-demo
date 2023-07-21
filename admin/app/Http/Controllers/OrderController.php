<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['mod_active' => 'order']);
            return $next($request);
        });
    }

    public function list(Request $request)
    {

        if ($request->keyword) {
            $keyword = $request->keyword;
        } else {
            $keyword = " ";
        }

        if ($request->status == 'disable') {
            $status = 'disable';
            $action = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $orders = Order::where('name',  'LIKE', "%{$keyword}%")->onlyTrashed()->paginate(4);
        } else if ($request->status == 'processing') {
            $status = 'processing';
            $action = [
                'completed' => 'Hoàn thành',
                'delete' => 'Xóa tạm thời'
            ];

            $orders = Order::where(
                [
                    ['status', 'processing'],
                    ['name', 'LIKE', "%{$keyword}%"]
                ]
            )->paginate(4);
        } else {
            $status = 'completed';
            $action = [
                'processing' => 'Đang xử lí',
                'delete' => 'Xóa tạm thời'
            ];
            $orders = Order::where(
                [
                    ['status', 'completed'],
                    ['name', 'LIKE', "%{$keyword}%"]
                ]
            )->paginate(4);
        }

        if ($orders->total() == 0) {
            $orders = [];
        }
        $cnt_order_completed = Order::where('status', 'completed')->count();
        $cnt_order_processing = Order::where('status', 'processing')->count();
        $cnt_order_delete = Order::onlyTrashed()->count();

        $cnt_order = [$cnt_order_completed, $cnt_order_processing, $cnt_order_delete];

        return view('admin.order.list', compact('orders', 'action', 'status', 'cnt_order'));
    }
    public function action(Request $request)
    {
        $action = $request->action;

        $status = $request->status;

        $check_list = $request->check_list;

        if ($status == 'completed') {
            if ($action == null) {
                return redirect('order/list')->with('status_error', 'Bạn cần chọn thao tác để thực hiện!');
            } else if (empty($check_list)) {
                return redirect('order/list')->with('status_error', 'Bạn cần tick để thực hiện!');
            } else {
                if ($action == 'delete') {
                    Order::destroy($check_list);
                    return redirect('order/list')->with('status', 'Đã xóa tạm thời thành công!');
                } else {
                    foreach ($check_list as $id) {
                        Order::where('id', $id)
                            ->update(['status' => 'processing']);
                    }
                    return redirect('order/list')->with('status', 'Đã chuyển sang đang xử lí thành công!');
                }
            }
        } else if ($status == 'processing') {
            if ($action == null) {
                return redirect('order/list?status=processing')->with('status_error', 'Bạn cần chọn thao tác để thực hiện!');
            } else if (empty($check_list)) {
                return redirect('order/list?status=processing')->with('status_error', 'Bạn cần tick để thực hiện!');
            } else {
                if ($action == 'delete') {
                    Order::destroy($check_list);

                    return redirect('order/list?status=processing')->with('status', 'Đã xóa tạm thời thành công!');
                } else {
                    foreach ($check_list as $id) {
                        Order::where('id', $id)
                            ->update(['status' => 'completed']);
                    }

                    return redirect('order/list?status=processing')->with('status', 'Đã chuyển sang hoàn thành thành công!');
                }
            }
        } else {
            if ($action == null) {
                return redirect('order/list?status=disable')->with('status_error', 'Bạn cần chọn thao tác để thực hiện!');
            } else if (empty($check_list)) {
                return redirect('order/list?status=disable')->with('status_error', 'Bạn cần tick để thực hiện!');
            } else {
                if ($action == 'forceDelete') {
                    Order::onlyTrashed()->forceDelete();

                    return redirect('order/list?status=disable')->with('status', 'Đã xóa vĩnh viễn thành công!');
                } else {
                    Order::onlyTrashed()->restore();

                    return redirect('order/list?status=disable')->with('status', 'Đã khôi phục thành công!');
                }
            }
        }
    }
    public function delete($id)
    {
        Order::destroy($id);
        return redirect('order/list')->with('status', 'Đã xóa thành công');
    }
}
