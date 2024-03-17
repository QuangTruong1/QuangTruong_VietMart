@extends('layouts.admin')
@section('title', 'Danh sách vai trò')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>            
        @endif
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách vai trò</h5>
            <div class="form-search form-inline">
                <form action="{{url('admin/role/list')}}" method="get">
                    <input style="max-width: 65%;" type="text" name='key' value="{{request()->input('key')}}" class="form-control form-search" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <form action="{{url('admin/role/action')}}" method="post">
                @csrf
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" name="act" id="">
                        <option value ="">Chọn</option>
                        @foreach ($list_act as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach                        
                    </select>
                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Vai trò</th>
                            <th scope="col">Mô tả</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $stt = 1;
                        @endphp
                        @forelse ($list_role as $role)
                        <tr>
                            <td>
                                <input type="checkbox"  name="list_check[]" value="{{$role->id}}">
                            </td>
                            <td scope="row">{{$stt++}}</td>
                            <td><a href="">{{$role->name}}</a></td>
                            <td>{!! $role->description !!}</td>
                            <td>{{$role->created_at}}</td>
                            <td>
                                <a href="{{route('role.edit', $role->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                <a href="{{route('role.delete', $role->id)}}" onclick="return confirm('Bạn có chắc muốn xóa vai trò?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr class="bg-white">
                            <td colspan="4">
                                <p>Không tồn tại vai trò nào</p>
                            </td>
                        </tr>
                          
                        @endforelse
                     
                    </tbody>
                </table>
            </form>
            {{$list_role->links()}}
        </div>
    </div>
</div>
@endsection