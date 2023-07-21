<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostCat;
use Illuminate\Http\Request;
use Stringable;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['mod_active' => 'post']);
            return $next($request);
        });
    }
    //


    //==========================POST CAT=============================


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
        $cats = PostCat::all();
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

        return view('admin.post.addCat', compact('cats', 'cats_data_level'));
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

        $url_slug = Str::slug($request->input('name'));

        PostCat::create(
            [
                'name' => $request->input('name'),
                'status' => $request->input('status'),
                'parent_id' => $request->input('parent_id'),
                'url' => "http://localhost/Project/vandunghastore.com/bai-viet/{$url_slug}/"
            ]
        );

        return redirect('post/cat/add')->with('status', 'Đã thêm danh mục mới thành công!');
    }


    public function deleteCat($catId)
    {
        PostCat::where('id', $catId)->delete();
        return redirect('post/cat/add')->with('status', 'Đã xóa danh mục thành công!');
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

        PostCat::where('id', $catId)->update(
            [
                'name' => $request->input('name'),
                'status' => $request->input('status'),
                'parent_id' => $request->input('parent_id'),
                'url' => "http://localhost/Project/vandunghastore.com/bai-viet/{$url_slug}/"
            ]
        );
        return redirect('post/cat/add')->with('status', 'Đã cập nhật danh mục thành công!');
    }


    public function editCat($catId)
    {
        $info_cat = PostCat::find($catId);
        $cats = PostCat::all();
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

        return view('admin.post.editCat', compact('info_cat', 'cats', 'cats_data_level'));
    }


    //==========================POST=============================


    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => ['required', 'string', 'max:255', 'min:10'],
                'content' => ['required', 'string'],
                'catId' => ['required'],
                'thumbnail' => ['required']
            ],
            [
                'required' => ':attribute không được để trống!',
                'string' => ':attribute là chuỗi',
                'max' => ':attribute có tối đa :max kí tự!',
                'min' => ':attribute có tối thiểu :min kí tự!',
            ],
            [
                'title' => 'Tiêu đề bài viết',
                'content' => 'Nội dung',
                'catId' => 'Danh mục',
                'thumbnail' => 'Ảnh đại diện'
            ]
        );

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = $file->getClientOriginalName();
            $file->move('public/uploads', $filename);
        }

        $data = [
            'title' => $request->input('title'),
            'desc' => $request->input('desc'),
            'content' => $request->input('content'),
            'thumbnail' => 'public/uploads/' . $filename,
            'cat_id' => $request->input('catId'),
            'user_id' => 1,
            'status' => $request->input('status')
        ];

        Post::create($data);

        return redirect('post/list')->with('status', 'Đã thêm bài viết mới thành công!');
    }


    public function add()
    {
        $list_cat = PostCat::all();

        return view('admin.post.add', compact('list_cat'));
    }


    public function list(Request $request)
    {
        $cats = PostCat::all();

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
            $posts = Post::where('title',  'LIKE', "%{$keyword}%")->onlyTrashed()->paginate(4);
        } else if ($request->status == 'waiting') {
            $status = 'waiting';
            $action = [
                'public' => 'Công khai',
                'delete' => 'Xóa tạm thời'
            ];

            $posts = Post::where(
                [
                    ['status', 'waiting'],
                    ['title', 'LIKE', "%{$keyword}%"]
                ]
            )->paginate(4);
        } else {
            $status = 'public';
            $action = [
                'waiting' => 'Chờ duyệt',
                'delete' => 'Xóa tạm thời'
            ];
            $posts = Post::where(
                [
                    ['status', 'public'],
                    ['title', 'LIKE', "%{$keyword}%"]
                ]
            )->paginate(4);
        }

        if ($posts->total() == 0) {
            $posts = [];
        }

        $cnt_post_public = Post::where('status', 'public')->count();
        $cnt_post_waiting = Post::where('status', 'waiting')->count();
        $cnt_post_delete = Post::onlyTrashed()->count();

        $cnt_post = [$cnt_post_public, $cnt_post_waiting, $cnt_post_delete];

        return view('admin.post.list', compact('posts', 'action', 'status', 'cnt_post', 'cats'));
    }


    public function action(Request $request)
    {
        $action = $request->action;

        $status = $request->status;

        $check_list = $request->check_list;

        if ($status == 'public') {
            if ($action == null) {
                return redirect('post/list')->with('status_error', 'Bạn cần chọn thao tác để thực hiện!');
            } else if (empty($check_list)) {
                return redirect('post/list')->with('status_error', 'Bạn cần tick để thực hiện!');
            } else {
                if ($action == 'delete') {
                    Post::destroy($check_list);
                    return redirect('post/list')->with('status', 'Đã xóa tạm thời thành công!');
                } else {
                    foreach ($check_list as $id) {
                        Post::where('id', $id)
                            ->update(['status' => 'waiting']);
                    }

                    return redirect('post/list')->with('status', 'Đã chuyển sang chờ duyệt thành công!');
                }
            }
        } else if ($status == 'waiting') {
            if ($action == null) {
                return redirect('post/list?status=waiting')->with('status_error', 'Bạn cần chọn thao tác để thực hiện!');
            } else if (empty($check_list)) {
                return redirect('post/list?status=waiting')->with('status_error', 'Bạn cần tick để thực hiện!');
            } else {
                if ($action == 'delete') {
                    Post::destroy($check_list);

                    return redirect('post/list?status=waiting')->with('status', 'Đã xóa tạm thời thành công!');
                } else {
                    foreach ($check_list as $id) {
                        Post::where('id', $id)
                            ->update(['status' => 'public']);
                    }

                    return redirect('post/list?status=waiting')->with('status', 'Đã chuyển sang công khai thành công!');
                }
            }
        } else {
            if ($action == null) {
                return redirect('post/list?status=disable')->with('status_error', 'Bạn cần chọn thao tác để thực hiện!');
            } else if (empty($check_list)) {
                return redirect('post/list?status=disable')->with('status_error', 'Bạn cần tick để thực hiện!');
            } else {
                if ($action == 'forceDelete') {
                    Post::onlyTrashed()->forceDelete();

                    return redirect('post/list?status=disable')->with('status', 'Đã xóa vĩnh viễn thành công!');
                } else {
                    Post::onlyTrashed()->restore();

                    return redirect('post/list?status=disable')->with('status', 'Đã khôi phục thành công!');
                }
            }
        }
    }


    public function delete($id)
    {
        Post::where('id', $id)->delete();
        return redirect('post/list')->with('status', 'Đã xóa tạm thời thành công!');
    }


    public function edit($id)
    {
        $post = Post::find($id);

        $list_cat = PostCat::all();

        return view('admin.post.edit', compact('post', 'list_cat'));
    }


    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'title' => ['required', 'string', 'max:255', 'min:10'],
                'content' => ['required', 'string'],
                'catId' => ['required'],
                'thumbnail' => ['required']
            ],
            [
                'required' => ':attribute không được để trống!',
                'string' => ':attribute là chuỗi',
                'max' => ':attribute có tối đa :max kí tự!',
                'min' => ':attribute có tối thiểu :min kí tự!',
            ],
            [
                'title' => 'Tiêu đề bài viết',
                'content' => 'Nội dung',
                'catId' => 'Danh mục',
                'thumbnail' => 'Ảnh đại diện'
            ]
        );

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = $file->getClientOriginalName();
            $file->move('public/uploads', $filename);
        }

        $data = [
            'title' => $request->input('title'),
            'desc' => $request->input('desc'),
            'content' => $request->input('content'),
            'thumbnail' => 'public/uploads/' . $filename,
            'cat_id' => $request->input('catId'),
            'user_id' => 1,
            'status' => $request->input('status')
        ];
        Post::where('id', $id)->update($data);
        return redirect('post/list')->with('status', 'Đã cập nhật bài viết thành công!');
    }
}
