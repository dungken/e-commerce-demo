<?php

namespace App\Http\Controllers;

use App\Ads;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class AdsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['mod_active' => 'ads']);
            return $next($request);
        });
    }
    
    public function add()
    {
        return view('admin.ads.add');
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'desc' => 'required',
                'link' => 'required',
                'banner' => 'required'
            ],
            [
                'required' => ':attribute không được để trống!'
            ],
            [
                'desc' => 'Mô tả quảng cáo',
                'link' => 'Đường dẫn liên kết',
                'banner' => 'Banner',
            ]
        );

        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $filename = $file->getClientOriginalName();
            $file->move('public/uploads', $filename);
        }

        

        $data = [
            'desc' => $request->input('desc'),
            'link' => $request->input('link'),
            'banner' => 'public/uploads/' . $filename,
            'status' => $request->input('status')
        ];

        Ads::create($data);

        return redirect('ads/list')->with('status', 'Đã thêm quảng cáo mới thành công!');
    }


    public function list()
    {
        $list_ads = Ads::paginate(8);

        return view('admin.ads.list', compact('list_ads'));
    }
    public function edit($id)
    {
        $ads = Ads::find($id);

        return view('admin.ads.edit', compact('ads'));
    }
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'desc' => 'required',
                'link' => 'required',
                'banner' => 'required'
            ],
            [
                'required' => ':attribute không được để trống!'
            ],
            [
                'desc' => 'Mô tả quảng cáo',
                'link' => 'Đường dẫn liên kết',
                'banner' => 'Banner',
            ]
        );

        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $filename = $file->getClientOriginalName();
            $file->move('public/uploads', $filename);
        }

    
        $data = [
            'desc' => $request->input('desc'),
            'link' => $request->input('link'),
            'banner' => 'public/uploads/' . $filename,
            'status' => $request->input('status')
        ];

        Ads::where('id', $id)->update($data);

        return redirect('ads/list')->with('status', 'Đã cập nhật quảng cáo thành công!');
    }
    public function delete($id)
    {
        Ads::where('id', $id)->delete();
        return redirect('ads/list')->with('status', 'Đã xóa thành công!');
    }
}
