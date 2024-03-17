<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    //
    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'permission']);
            return $next($request);
        });    

    }
    function add(){

        $permissions = Permission::all()->groupBy(function($permission){
            return explode('.', $permission->slug)[0];
        });
    
        return view('admin.permission.add', compact('permissions'));
    }

    function store(Request $request){
        $request -> validate(
            [
                'name' => 'required|max:255',
                'slug' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => 'Dữ liệu tối đa 255 ký tự',
            ],
            [
                'name' => 'Tên quyền',
                'slug' => 'Đường dẫn ngắn'
            ]
        );
        Permission::create([
            'name'=> $request->name,
            'slug'=> $request->slug,
            'description' => $request->description,
        ]);
        return redirect('admin/permission/add')->with('status', 'Thêm thành công');
    }

    function edit($id){
        $permissions = Permission::all()->groupBy(function($permission){
            return explode('.', $permission->slug)[0];
        });
        $permission = Permission::find($id);
        return view('admin.permission.edit', compact('permission', 'permissions'));
    }
    function update($id, Request $request){
        $request -> validate(
            [
                'name' => 'required|max:255',
                'slug' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => 'Dữ liệu tối đa 255 ký tự',
            ],
            [
                'name' => 'Tên quyền',
                'slug' => 'Đường dẫn ngắn'
            ]
        );

        Permission::where('id', $id) -> update(
            [
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
            ]
        );
        
        return redirect('admin/permission/add')->with('status', "Chỉnh sửa thông tin quyền thành công");
    }

    function delete($id){
       Permission::where('id', $id) -> delete();
       return redirect('admin/permission/add')->with('status', "Xóa quyền thành công");
    }
}
