@extends('layouts.admin')
@section('title', 'List Slide')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách slide</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Slide</th>
                            <th scope="col">Link</th>
                            <th scope="col">Mô tả</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($list_slide))
                            @php
                                $cnt = 0;
                            @endphp
                            @foreach ($list_slide as $slide)
                                @php
                                    $cnt++;
                                    $status = ['public' => 'Công khai', 'waiting' => 'Chờ duyệt'];
                                @endphp
                                <tr>
                                    <td scope="row">{{ $cnt }}</td>
                                    <td><img style="max-width: 100px; height: auto;" src="{{ url($slide->slide) }}"
                                            alt=""></td>
                                    <td><a href="{{ $slide->link }}">{{ $slide->link }}</a></td>
                                    <td>{{ Str::limit($slide->desc, 50, '...') }}</td>
                                    <td>{{ $status[$slide->status] }}</td>
                                    <td>{{ $slide->created_at }}</td>
                                    <td>
                                        <a href="{{ route('slide.edit', $slide->id) }}"
                                            class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        <a href="{{ route('slide.delete', $slide->id) }}"
                                            class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Delete"
                                            onclick="return confirm('Bạn có muốn xóa slide này không?')"><i
                                                class="fa fa-trash"></i></a>

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
                @if (!empty($list_ads))
                    {{ $list_ads->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection
