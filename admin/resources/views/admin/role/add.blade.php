@extends('layouts.admin')

@section('title', 'Add Role')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Thêm mới vai trò</h5>
            </div>
            <div class="card-body">
                {!! Form::open(['route' => 'role.add.store']) !!}

                <div class="form-group">
                    {!! Form::label('name', 'Tên vai trò', ['class' => 'text-strong']) !!}
                    {!! Form::text('name', old('name'), ['id' => 'name', 'class' => 'form-control']) !!}
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    {!! Form::label('description', 'Mô tả', ['class' => 'text-strong']) !!}
                    {!! Form::textarea('description', old('description'), ['id' => 'description', 'class' => 'form-control']) !!}
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <strong>Vai trò này có quyền gì?</strong>
                <small class="form-text text-muted pb-2">Check vào module hoặc các hành động bên dưới để chọn
                    quyền.</small>
                <!-- List Permission  -->
                @foreach ($permissions as $module => $dataPermission)
                    <div class="card my-4 border">
                        <div class="card-header">
                            {!! Form::checkbox('', '', '', ['class' => 'check-all', 'id' => $module, 'name' => 'permission_id[]']) !!}
                            {!! html_entity_decode(Form::label($module, '<strong>Module ' . ucfirst($module) . '</strong>')) !!}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($dataPermission as $pms)
                                    <div class="col-md-3">
                                        {!! Form::checkbox('permission_id[]', $pms->id, '', ['class' => 'permission', 'id' => $pms->slug]) !!}
                                        {!! Form::label($pms->slug, $pms->name) !!}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
                {!! Form::submit('Thêm mới', ['name' => 'btn-add', 'class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('.check-all').click(function() {
            $(this).closest('.card').find('.permission').prop('checked', this.checked)
        })
    </script>
@endsection
