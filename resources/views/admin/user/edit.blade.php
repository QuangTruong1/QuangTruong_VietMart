@extends('layouts.admin')
@section('title', 'Chỉnh sửa thông tin người dùng')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Chỉnh sửa thông tin người dùng
        </div>
        <div class="card-body">
            <form action="{{route('user.update', $user->id)}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input class="form-control" type="text" name="name" id="name" value="{{$user->name}}">
                    @error('name')                        
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="text" name="email" id="email" value="{{$user->email}}" disabled>
                    @error('email')                        
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="">Nhóm quyền</label>
                    <select class="form-control" id="roles" multiple = 'true' name="roles[]">
                        @foreach ($list_role as $role)
                        <option value="{{$role->id}}" @if(in_array($role->id, $user->roles->pluck('id')->toArray())) selected @endif>{{$role->name}}</option>
                      @endforeach                     
                    </select>
                </div>

                <button type="submit" value="Thêm mới" name="btn-add" class="btn btn-primary">Lưu</button>
            </form>
        </div>
    </div>
</div>
    
@endsection