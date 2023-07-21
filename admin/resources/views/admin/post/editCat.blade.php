@extends('layouts.admin')
@section('title', 'Edit Cat Post')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif
                    <div class="card-header font-weight-bold">
                        Cập nhật danh mục
                    </div>
                    <div class="card-body">
                        <form action="{{ route('post.cat.update', $info_cat->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên danh mục</label>
                                <br>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <input class="form-control" type="text" name="name" id="name"
                                    value="{{ $info_cat->name }}">
                            </div>
                            <div class="form-group">
                                <label for="parent_id">Thuộc danh mục</label>
                                <br>
                                @error('parent_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <select class="form-control" name="parent_id" id="parent_id">
                                    <option value="">Chọn danh mục</option>
                                    <option value="0">Danh mục cha</option>
                                    @foreach ($cats as $cat)
                                        <option {{ $info_cat->parent_id == $cat->id ? 'selected' : '' }}
                                            value="{{ $cat->id }}">{{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Trạng thái</label>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="waiting"
                                        value="waiting" {{ $info_cat->status == 'waiting' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="waiting">
                                        Chờ duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="public"
                                        value="public" {{ $info_cat->status == 'public' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="public">
                                        Công khai
                                    </label>
                                </div>
                            </div>
                            <button type="submit" name="btn_edit_cat" value="Cập nhật danh mục" class="btn btn-primary">Cập
                                nhật</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh mục
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Tên danh mục</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($cats_data_level))
                                    @php
                                        $status_translate = [
                                            'waiting' => 'Chờ duyệt',
                                            'public' => 'Công khai',
                                        ];
                                    @endphp
                                    @foreach ($cats_data_level as $k => $e)
                                        <tr>
                                            <td>
                                                @php
                                                    echo str_repeat('|--', $e['level']) . $e['name'];
                                                @endphp
                                            </td>
                                            <td>{{ $status_translate[$e['status']] }}</td>
                                            <td>
                                                <a href="{{ route('post.cat.edit', $e['cat_id']) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                @if (
                                                    ($k < count($cats_data_level) - 1 && $cats_data_level[$k + 1]['level'] - $cats_data_level[$k]['level'] <= 0) ||
                                                        $k == count($cats_data_level) - 1)
                                                    <a href="" class="btn btn-danger btn-sm rounded-0 text-white"
                                                        type="button" data-toggle="tooltip" data-placement="top"
                                                        title="Delete"
                                                        onclick="return confirm('Bạn có muốn xóa danh mục này không?')"><i
                                                            class="fa fa-trash"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-danger">
                                            <strong>Không có danh mục nào!</strong>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
