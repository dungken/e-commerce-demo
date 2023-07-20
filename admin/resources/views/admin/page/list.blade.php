@extends('layouts.admin')

@section('title', 'List Page')

@section('content')
    <div id="content" class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if (session('status_error'))
            <div class="alert alert-danger">{{ session('status_error') }}</div>
        @endif
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách trang</h5>
                <div class="form-search form-inline">
                    <form action="#" class=" d-flex">
                        <input type="text" name="keyword" value="{{request()->keyword}}" class="form-control form-search" placeholder="Tìm kiếm trang">
                        <input type="submit" name="btn_search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <form action="{{ route('page.action', $status) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="analytic">
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'public']) }}" class="text-primary">Công
                            khai<span class="text-muted">({{ $cnt_page[0] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'waiting']) }}" class="text-primary">Chờ
                            duyệt<span class="text-muted">({{ $cnt_page[1] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'disable']) }}" class="text-primary">Vô hiệu
                            hóa<span class="text-muted">({{ $cnt_page[2] }})</span></a>
                    </div>
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="" name="action">
                            <option value="">Chọn</option>
                            @foreach ($action as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn_action" value="Áp dụng" class="btn btn-primary">
                    </div>
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Tên trang</th>
                                <th scope="col">Nội dung</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Ngày tạo</th>
                                @if ($status == 'public' || $status == 'waiting')
                                    <th scope="col">Tác vụ</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($pages))
                                @php
                                    $cnt = 0;
                                    $status_translate = ['Chờ duyệt', 'Công khai'];
                                    $status_action = [
                                        0 => 'waiting',
                                        1 => 'public',
                                    ];
                                @endphp
                                @foreach ($pages as $page)
                                    @php
                                        $cnt++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="check_list[]" value="{{ $page->id }}">
                                        </td>
                                        <td scope="row">{{ $cnt }}</td>
                                        <td>{{ $page->name }}</td>
                                        <td>{{ Str::limit($page->content, 50, '.....') }}</td>
                                        <td>{{ $status_translate[$page->status] }}</td>
                                        <td>{{ $page->created_at }}</td>
                                        <td>
                                            @if ($status == $status_action[$page->status])
                                                <a href="{{ route('page.edit', $page->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ route('page.delete', $page->id) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"
                                                    onclick="return confirm('Bạn có muốn xóa tạm thời trang này không?')"><i
                                                        class="fa fa-trash"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-danger" colspan="7">
                                        <strong>Không có bản ghi nào!</strong>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    @if (!empty($pages))
                        {{ $pages->links() }}
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
