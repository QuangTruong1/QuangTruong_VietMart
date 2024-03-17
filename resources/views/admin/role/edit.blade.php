@extends('layouts.admin')
@section('title', 'Chỉnh sửa thông tin vai trò')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>            
        @endif
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Chỉnh sửa thông tin vai trò</h5>
        </div>
        <div class="card-body">
            {!! Form::open(['route' => ['role.update', $role->id]]) !!}
            <div class="form-group">
                {!! Form::label('name', 'Tên vài trò') !!}
                {!! Form::text('name', $role->name, ['class'=>'form-control', 'id'=>'name']) !!}
                @error('name')
                    <small class="form-text text-danger">{{$message}}</small>                    
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Mô tả') !!}
                {!! Form::textarea('description', $role->description, ['class'=>'form-control', 'id'=>'description', 'rows'=>3]) !!}
                @error('description')
                    <small class="form-text text-danger">{{$message}}</small>                    
                @enderror
            </div>
            <strong>Vai trò này có quyền gì?</strong>
            <small class="form-text text-muted pb-2">Check vào module hoặc các hành động bên dưới để chọn quyền.</small>
            @error('permission_id')
                    <small class="form-text text-danger">{{$message}}</small>                    
            @enderror
            @forelse ($list_permission as $moduleName => $modulePermission)
            <div class="card my-4 border">
                <div class="card-header">
                    {!! Form::checkbox(null, null, null, ['class' => 'check-all', 'id' => $moduleName]) !!}
                    {!! html_entity_decode(Form::label($moduleName, '<strong>Module '. ucfirst($moduleName) .'</strong>')) !!}
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($modulePermission as $permission)
                            <div class="col-md-3">
                                {!! Form::checkbox('permission_id[]', $permission->id,  in_array($permission->id, $role->permissions->pluck('id')->toArray()), ['id' => $permission->slug, 'class' => 'permission']) !!}
                                {!! Form::label($permission->slug, $permission->name) !!}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @empty
                <p>Không tồn tại quyền nào trong hệ thống</p>
            @endforelse

            <input type="submit" name="btn-add" class="btn btn-primary" value="Lưu">
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $('.check-all').click(function () {
        $(this).closest('.card').find('.permission').prop('checked', this.checked)
      })
</script>
@endsection