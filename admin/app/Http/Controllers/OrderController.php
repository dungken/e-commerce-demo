<?php

namespace App\Http\Controllers;

use App\Client;
use App\Order;
use App\Product;
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

        if ($request->status == 'paid') {
            $status = 'paid';
            $action = [
                'trash' => 'Xóa'
            ];

            $clients = Client::where(
                [
                    ['status', 'paid'],
                    ['name', 'LIKE', "%{$keyword}%"]
                ]
            )->paginate(8);
        } else if ($request->status == 'received') {
            $status = 'received';
            $action = [
                'paid' => 'Đã thanh toán',
            ];

            $clients = Client::where(
                [
                    ['status', 'received'],
                    ['name', 'LIKE', "%{$keyword}%"]
                ]
            )->paginate(8);
        } else if ($request->status == 'delivering') {
            $status = 'delivering';
            $action = [
                'received' => 'Đã giao',
                'paid' => 'Đã thanh toán',
            ];

            $clients = Client::where(
                [
                    ['status', 'delivering'],
                    ['name', 'LIKE', "%{$keyword}%"]
                ]
            )->paginate(8);
        } else if ($request->status == 'approved') {
            $status = 'approved';
            $action = [
                'delivering' => 'Đang vận chuyển',
                'received' => 'Đã giao',
                'paid' => 'Đã thanh toán',
            ];

            $clients = Client::where(
                [
                    ['status', 'approved'],
                    ['name', 'LIKE', "%{$keyword}%"]
                ]
            )->paginate(8);
        } else {
            $status = 'pending';
            $action = [
                'approved' => 'Đã duyệt',
                'delivering' => 'Đang vận chuyển',
                'received' => 'Đã giao',
                'paid' => 'Đã thanh toán',
            ];

            $clients = Client::where(
                [
                    ['status', 'pending'],
                    ['name', 'LIKE', "%{$keyword}%"]
                ]
            )->paginate(8);
        }


        if ($clients->total() == 0) {
            $clients = [];
        }


        $cnt_client_pending = Client::where('status', 'pending')->count();
        $cnt_client_apprroved = Client::where('status', 'approved')->count();
        $cnt_client_delivering = Client::where('status', 'delivering')->count();
        $cnt_client_received = Client::where('status', 'received')->count();
        $cnt_client_paid = Client::where('status', 'paid')->count();

        $cnt_client = [$cnt_client_pending, $cnt_client_apprroved, $cnt_client_delivering, $cnt_client_received, $cnt_client_paid];

        return view('admin.order.list', compact('clients', 'action', 'status', 'cnt_client'));
    }

    public function detail($id)
    {
        $client = Client::find($id);

        $orders = Order::where('client_id', $id)->get();

        $products = Product::all();

        // return $orders;


        return view('admin.order.detail', compact('client', 'orders', 'products'));
    }

    public function action(Request $request)
    {
        $action = $request->action;

        $status = $request->status;

        $check_list = $request->check_list;


        if ($status == 'paid') {
            if ($action == '0') {
                return redirect('order/list?status=paid')->with('status_error', 'Bạn cần chọn thao tác để thực hiện!');
            } else if (empty($check_list)) {
                return redirect('order/list?status=paid')->with('status_error', 'Bạn cần tick để thực hiện!');
            } else {
                Client::destroy($check_list);
                return redirect('order/list?status=paid')->with('status', 'Đã xóa thành công!');
            }
        } else if ($status == 'received') {
            if ($action == '0') {
                return redirect('order/list?status=received')->with('status_error', 'Bạn cần chọn thao tác để thực hiện!');
            } else if (empty($check_list)) {
                return redirect('order/list?status=received')->with('status_error', 'Bạn cần tick để thực hiện!');
            } else {
                if ($action == 'paid') {
                    foreach ($check_list as $id) {
                        Client::where('id', $id)
                            ->update(['status' => 'paid']);
                    }
                    return redirect('order/list?status=paid')->with('status', 'Đã chuyển sang đã thanh toán thành công!');
                }
            }
        } else if ($status == 'delivering') {
            if ($action == '0') {
                return redirect('order/list?status=delivering')->with('status_error', 'Bạn cần chọn thao tác để thực hiện!');
            } else if (empty($check_list)) {
                return redirect('order/list?status=delivering')->with('status_error', 'Bạn cần tick để thực hiện!');
            } else {
                if ($action == 'paid') {
                    foreach ($check_list as $id) {
                        Client::where('id', $id)
                            ->update(['status' => 'paid']);
                    }
                    return redirect('order/list?status=paid')->with('status', 'Đã chuyển sang đã thanh toán thành công!');
                } else if ($action == 'received') {
                    foreach ($check_list as $id) {
                        Client::where('id', $id)
                            ->update(['status' => 'received']);
                    }
                    return redirect('order/list?status=paid')->with('status', 'Đã chuyển sang đã nhận thành công!');
                }
            }
        } else if ($status == 'approved') {
            if ($action == '0') {
                return redirect('order/list?status=approved')->with('status_error', 'Bạn cần chọn thao tác để thực hiện!');
            } else if (empty($check_list)) {
                return redirect('order/list?status=approved')->with('status_error', 'Bạn cần tick để thực hiện!');
            } else {
                if ($action == 'paid') {
                    foreach ($check_list as $id) {
                        Client::where('id', $id)
                            ->update(['status' => 'paid']);
                    }
                    return redirect('order/list?status=approved')->with('status', 'Đã chuyển sang đã thanh toán thành công!');
                } else if ($action == 'received') {
                    foreach ($check_list as $id) {
                        Client::where('id', $id)
                            ->update(['status' => 'received']);
                    }
                    return redirect('order/list?status=approved')->with('status', 'Đã chuyển sang đã nhận thành công!');
                } else {
                    foreach ($check_list as $id) {
                        Client::where('id', $id)
                            ->update(['status' => 'delivering']);
                    }
                    return redirect('order/list?status=approved')->with('status', 'Đã chuyển sang đang vận chuyển thành công!');
                }
            }
        } else {
            if ($action == '0') {
                return redirect('order/list?status=pending')->with('status_error', 'Bạn cần chọn thao tác để thực hiện!');
            } else if (empty($check_list)) {
                return redirect('order/list?status=pending')->with('status_error', 'Bạn cần tick để thực hiện!');
            } else {
                if ($action == 'paid') {
                    foreach ($check_list as $id) {
                        Client::where('id', $id)
                            ->update(['status' => 'paid']);
                    }
                    return redirect('order/list?status=pending')->with('status', 'Đã chuyển sang đã thanh toán thành công!');
                } else if ($action == 'received') {
                    foreach ($check_list as $id) {
                        Client::where('id', $id)
                            ->update(['status' => 'received']);
                    }
                    return redirect('order/list?status=pending')->with('status', 'Đã chuyển sang đã nhận thành công!');
                } else if ($action == 'approved') {
                    foreach ($check_list as $id) {
                        Client::where('id', $id)
                            ->update(['status' => 'approved']);
                    }
                    return redirect('order/list?status=pending')->with('status', 'Đã chuyển sang đã duyệt thành công!');
                } else {
                    foreach ($check_list as $id) {
                        Client::where('id', $id)
                            ->update(['status' => 'delivering']);
                    }
                    return redirect('order/list?status=pending')->with('status', 'Đã chuyển sang đang vận chuyển thành công!');
                }
            }
        }
    }
    public function delete($id)
    {
        Client::destroy($id);
        return redirect('order/list')->with('status', 'Đã xóa thành công');
    }

    public function update(Request $request, $id)
    {
        $status = $request->input('status');

        Client::where('id', $id)->update(['status' => $status]);

        return redirect()->back()->with('status', 'Đã cập nhật thành công');
    }
}
