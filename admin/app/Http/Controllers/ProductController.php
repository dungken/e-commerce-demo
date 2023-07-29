<?php

namespace App\Http\Controllers;

use App\ImagesRelateProduct;
use App\Product;
use App\ProductCat;
use Illuminate\Http\Request;
use Stringable;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['mod_active' => 'product']);
            return $next($request);
        });
    }
    //


    //==========================PRODUCT CAT=============================


    public function has_child($data, $cat_id)
    {
        foreach ($data as $v) {
            if ($v['parent_id'] == $cat_id)
                return true;
        }
        return false;
    }


    public function data_tree($data, $parent_id = 0, $level = 0)
    {
        $result = array();
        foreach ($data as $v) {
            if ($v['parent_id'] == $parent_id) {
                $v['level'] = $level;
                $result[] = $v;
                if ($this->has_child($data, $v['cat_id'])) {
                    $result_child = $this->data_tree($data, $v['cat_id'], $level + 1);
                    $result = array_merge($result, $result_child);
                }
            }
        }
        return $result;
    }


    public function addCat()
    {
        $cats = ProductCat::all();
        $cat_data = [];
        foreach ($cats as $cat) {
            $cat_data[] = [
                'cat_id' => $cat->id,
                'name' => $cat->name,
                'parent_id' => $cat->parent_id,
                'status' => $cat->status
            ];
        }

        $cats_data_level = $this->data_tree($cat_data);

        return view('admin.product.addCat', compact('cats', 'cats_data_level'));
    }


    public function catStore(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'min:3'],
                'parent_id' => ['required'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'max' => ':attribute có tối đa :max kí tự!',
                'min' => ':attribute có tối thiểu :min kí tự!',
            ],
            [
                'name' => 'Tên danh mục',
                'parent_id' => 'Loại danh mục',
            ]
        );

        ProductCat::create(
            [
                'name' => $request->input('name'),
                'status' => $request->input('status'),
                'parent_id' => $request->input('parent_id'),
                'slug' => Str::slug($request->input('name'))
            ]
        );

        return redirect('product/cat/add')->with('status', 'Đã thêm danh mục mới thành công!');
    }


    public function deleteCat($catId)
    {
        ProductCat::where('id', $catId)->delete();
        return redirect('product/cat/add')->with('status', 'Đã xóa danh mục thành công!');
    }


    public function updateCat(Request $request, $catId)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'min:3'],
                'parent_id' => ['required'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'max' => ':attribute có tối đa :max kí tự!',
                'min' => ':attribute có tối thiểu :min kí tự!',
            ],
            [
                'name' => 'Tên danh mục',
                'parent_id' => 'Loại danh mục',
            ]
        );

        $url_slug = Str::slug($request->input('name'));

        ProductCat::where('id', $catId)->update(
            [
                'name' => $request->input('name'),
                'status' => $request->input('status'),
                'parent_id' => $request->input('parent_id'),
                'slug' => Str::slug($request->input('name'))
            ]
        );
        return redirect('product/cat/add')->with('status', 'Đã cập nhật danh mục thành công!');
    }


    public function editCat($catId)
    {
        $info_cat = ProductCat::find($catId);
        $cats = ProductCat::all();
        $cat_data = [];
        foreach ($cats as $cat) {
            $cat_data[] = [
                'cat_id' => $cat->id,
                'name' => $cat->name,
                'parent_id' => $cat->parent_id,
                'status' => $cat->status
            ];
        }

        $cats_data_level = $this->data_tree($cat_data);

        return view('admin.product.editCat', compact('info_cat', 'cats', 'cats_data_level'));
    }


    // //==========================PRODUCT=============================


    public function store(Request $request)
    {
        // return $request;

        $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'min:2'],
                'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
                'detail' => ['required', 'string'],
                'desc' => ['required', 'string', 'min:10'],
                'catId' => ['required'],
                'thumbnail' => ['required'],
                'qty_on_hand' => 'required',
            ],
            [
                'required' => ':attribute không được để trống!',
                'string' => ':attribute là chuỗi',
                'max' => ':attribute có tối đa :max kí tự!',
                'min' => ':attribute có tối thiểu :min kí tự!',
            ],
            [
                'name' => 'Tên sản phẩm',
                'price' => 'Giá sản phẩm',
                'detail' => 'Chi tiết sản phẩm',
                'desc' => 'Mô tả sản phẩm',
                'catId' => 'Danh mục',
                'thumbnail' => 'Ảnh đại diện',
                'qty_on_hand' => 'Số lượng'
            ]
        );


        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = $file->getClientOriginalName();
            $file->move('public/uploads', $filename);
        }

        $count = Product::all()->count();
        $count_code = $count + 1;

        $data = [
            'name' => $request->input('name'),
            'desc' => $request->input('desc'),
            'price' => $request->input('price'),
            'detail' => $request->input('detail'),
            'thumbnail' => 'public/uploads/' . $filename,
            'cat_id' => $request->input('catId'),
            'status' => $request->input('status'),
            'slug' => Str::slug($request->input('name')),
            'qty_on_hand' => $request->input('qty_on_hand'),
            'product_code' => "VDHSTORE#" . "{$count_code}"
        ];

        $product_id = Product::create($data);

        if ($request->hasFile('imgs_relate')) {
            $multi_file = $request->file('imgs_relate');
            foreach ($multi_file as $file) {
                $multi_filename = $file->getClientOriginalName();
                $file->move('public/uploads', $multi_filename);
                ImagesRelateProduct::create(
                    [
                        'thumb_id' => $product_id->id,
                        'path' => 'public/uploads/' . $multi_filename,
                    ]
                );
            }
        }


        return redirect('product/list')->with('status', 'Đã thêm bài viết mới thành công!');
    }


    public function add()
    {
        $list_cat = ProductCat::all();
        return view('admin.product.add', compact('list_cat'));
    }


    public function list(Request $request)
    {

        $cats = ProductCat::all();


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
            $products = Product::where('name', 'LIKE', "%{$keyword}%")->onlyTrashed()->paginate(8);
            // $products = Product::onlyTrashed()->paginate(4);
            // return $products;

        } else if ($request->status == 'soldOut') {
            $status = 'soldOut';
            $action = [
                'inStock' => 'Còn hàng',
                'delete' => 'Xóa tạm thời'
            ];

            $products = Product::where(
                [
                    ['status', 'soldOut'],
                    ['name', 'LIKE', "%{$keyword}%"]
                ]
            )->paginate(8);
            // dd($products);
        } else {
            $status = 'inStock';
            $action = [
                'soldOut' => 'Hết hàng',
                'delete' => 'Xóa tạm thời'
            ];
            $products = Product::where(
                [
                    ['status', 'inStock'],
                    ['name', 'LIKE', "%{$keyword}%"]
                ]
            )->paginate(8);
        }

        if ($products->total() == 0) {
            $products = [];
        }

        // return $products;    


        $cnt_product_soldOut = Product::where('status', 'soldOut')->count();
        $cnt_product_inStock = Product::where('status', 'inStock')->count();
        $cnt_product_delete = Product::onlyTrashed()->count();

        $cnt_product = [$cnt_product_soldOut, $cnt_product_inStock, $cnt_product_delete];

        return view('admin.product.list', compact('products', 'action', 'status', 'cnt_product', 'cats'));
    }


    public function action(Request $request)
    {
        $action = $request->action;

        $status = $request->status;

        $check_list = $request->check_list;

        if ($status == 'inStock') {
            if ($action == null) {
                return redirect('product/list')->with('status_error', 'Bạn cần chọn thao tác để thực hiện!');
            } else if (empty($check_list)) {
                return redirect('product/list')->with('status_error', 'Bạn cần tick để thực hiện!');
            } else {
                if ($action == 'delete') {
                    Product::destroy($check_list);
                    return redirect('product/list')->with('status', 'Đã xóa tạm thời thành công!');
                } else {
                    foreach ($check_list as $id) {
                        Product::where('id', $id)
                            ->update(['status' => 'soldOut']);
                    }
                    return redirect('product/list')->with('status', 'Đã chuyển sang hết hàng thành công!');
                }
            }
        } else if ($status == 'soldOut') {
            if ($action == null) {
                return redirect('product/list?status=soldOut')->with('status_error', 'Bạn cần chọn thao tác để thực hiện!');
            } else if (empty($check_list)) {
                return redirect('product/list?status=soldOut')->with('status_error', 'Bạn cần tick để thực hiện!');
            } else {
                if ($action == 'delete') {
                    Product::destroy($check_list);

                    return redirect('product/list?status=soldOut')->with('status', 'Đã xóa tạm thời thành công!');
                } else {
                    foreach ($check_list as $id) {
                        Product::where('id', $id)
                            ->update(['status' => 'inStock']);
                    }

                    return redirect('product/list?status=soldOut')->with('status', 'Đã chuyển sang còn hàng thành công!');
                }
            }
        } else {
            if ($action == null) {
                return redirect('product/list?status=disable')->with('status_error', 'Bạn cần chọn thao tác để thực hiện!');
            } else if (empty($check_list)) {
                return redirect('product/list?status=disable')->with('status_error', 'Bạn cần tick để thực hiện!');
            } else {
                if ($action == 'forceDelete') {
                    Product::onlyTrashed()->forceDelete();

                    return redirect('product/list?status=disable')->with('status', 'Đã xóa vĩnh viễn thành công!');
                } else {
                    Product::onlyTrashed()->restore();

                    return redirect('product/list?status=disable')->with('status', 'Đã khôi phục thành công!');
                }
            }
        }
    }


    public function delete($id)
    {
        Product::where('id', $id)->delete();
        return redirect('product/list')->with('status', 'Đã xóa tạm thời thành công!');
    }


    public function edit($id)
    {
        $product = Product::find($id);

        $list_cat = ProductCat::all();

        return view('admin.product.edit', compact('product', 'list_cat'));
    }


    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'min:2'],
                'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
                'detail' => ['required', 'string'],
                'desc' => ['required', 'string', 'min:10'],
                'catId' => ['required'],
                'thumbnail' => ['required'],
                'qty_on_hand' => ['required']
            ],
            [
                'required' => ':attribute không được để trống!',
                'string' => ':attribute là chuỗi',
                'max' => ':attribute có tối đa :max kí tự!',
                'min' => ':attribute có tối thiểu :min kí tự!',
            ],
            [
                'name' => 'Tên sản phẩm',
                'price' => 'Giá sản phẩm',
                'detail' => 'Chi tiết sản phẩm',
                'desc' => 'Mô tả sản phẩm',
                'catId' => 'Danh mục',
                'thumbnail' => 'Ảnh đại diện',
                'qty_on_hand' => 'Số lượng'
            ]
        );


        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = $file->getClientOriginalName();
            $file->move('public/uploads', $filename);
        }

        $data = [
            'name' => $request->input('name'),
            'desc' => $request->input('desc'),
            'price' => $request->input('price'),
            'detail' => $request->input('detail'),
            'thumbnail' => 'public/uploads/' . $filename,
            'cat_id' => $request->input('catId'),
            'status' => $request->input('status'),
            'slug' => Str::slug($request->input('name')),
            'qty_on_hand' => $request->input('qty_on_hand'),
        ];


        Product::where('id', $id)->update($data);

        ImagesRelateProduct::where('thumb_id', $id)->delete();

        if ($request->hasFile('imgs_relate')) {
            $multi_file = $request->file('imgs_relate');
            foreach ($multi_file as $file) {
                $multi_filename = $file->getClientOriginalName();
                $file->move('public/uploads', $multi_filename);
                ImagesRelateProduct::create(
                    [
                        'thumb_id' => $id,
                        'path' => 'public/uploads/' . $multi_filename,
                    ]
                );
            }
        }

        return redirect('product/list')->with('status', 'Đã cập nhật sản phẩm thành công!');
    }
}
