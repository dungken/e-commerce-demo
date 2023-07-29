<?php

namespace App\Http\Controllers;

use App\Slide;
use Illuminate\Http\Request;

class SlideController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['mod_active' => 'slide']);
            return $next($request);
        });
    }
    
    public function add()
    {
        return view('admin.slide.add');
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'desc' => 'required',
                'link' => 'required',
                'slide' => 'required'
            ],
            [
                'required' => ':attribute không được để trống!'
            ],
            [
                'desc' => 'Mô tả slide',
                'link' => 'Đường dẫn liên kết',
                'slide' => 'Slide',
            ]
        );

        if ($request->hasFile('slide')) {
            $file = $request->file('slide');
            $filename = $file->getClientOriginalName();
            $file->move('public/uploads', $filename);
        }

        

        $data = [
            'desc' => $request->input('desc'),
            'link' => $request->input('link'),
            'slide' => 'public/uploads/' . $filename,
            'status' => $request->input('status')
        ];

        Slide::create($data);

        return redirect('slide/list')->with('status', 'Đã thêm slide mới thành công!');
    }


    public function list()
    {
        $list_slide = Slide::paginate(8);

        return view('admin.slide.list', compact('list_slide'));
    }
    public function edit($id)
    {
        $slide = Slide::find($id);

        return view('admin.slide.edit', compact('slide'));
    }
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'desc' => 'required',
                'link' => 'required',
                'slide' => 'required'
            ],
            [
                'required' => ':attribute không được để trống!'
            ],
            [
                'desc' => 'Mô tả slide',
                'link' => 'Đường dẫn liên kết',
                'slide' => 'Slide',
            ]
        );

        if ($request->hasFile('slide')) {
            $file = $request->file('slide');
            $filename = $file->getClientOriginalName();
            $file->move('public/uploads', $filename);
        }

    
        $data = [
            'desc' => $request->input('desc'),
            'link' => $request->input('link'),
            'slide' => 'public/uploads/' . $filename,
            'status' => $request->input('status')
        ];

        Slide::where('id', $id)->update($data);

        return redirect('slide/list')->with('status', 'Đã cập nhật slide thành công!');
    }
    public function delete($id)
    {
        Slide::where('id', $id)->delete();
        return redirect('slide/list')->with('status', 'Đã xóa thành công!');
    }
}
