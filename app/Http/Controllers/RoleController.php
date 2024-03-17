<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    //
   
    function list(Request $request){
      
        if(! Gate::allows('role.view')){
            abort(403);
        }
        $list_act = [
            'delete'=> "Xóa",
        ];
        $key = "";
        if($request->input('key')){
            $key = $request->input('key');               
        }    
        $list_role = Role::where('name', 'like', '%' . $key . '%')->paginate(5);  
        return view('admin.role.list', compact('list_role', 'list_act'));
    }

    function action(Request $request){
        $list_check = $request-> input('list_check');
        if($list_check){            
            //Thực hiện tác vụ
            if(!empty($list_check)){
                $act = $request->input('act');
                if($act == ''){
                    return redirect('admin/role/list')->with('status', 'Vui lòng chọn hành động');
                }
                if($act == "delete"){
                    Role::destroy($list_check);
                    return redirect('admin/role/list')->with('status', 'Xóa thành công các phần tử đã chọn');
                }
            }            
        }
        else{
            return redirect('admin/role/list')->with('status', 'Vui lòng chọn phần tử để thực hiện thao tác');
        }
    }

    function delete($id){
        Role::find($id)->delete();
        return redirect('admin/role/list')->with('status', 'Xóa thành công');
    }
    
    function add(){
        // if(! Gate::allows('role.add')){
        //     abort(403);
        // }
        $list_permission = Permission::all()->groupBy(function($permission){
            return explode('.', $permission->slug)[0];
        });
        return view('admin.role.add', compact('list_permission'));
    }

    function store(Request $request){
        $request -> validate(
            [
                'name' => 'required|max:255|unique:roles,name,',
                'description' => 'required',
                'permission_id'=> 'nullable|array',
                'permission_id.*' => 'exists:permissions,id',
                // 'permission_id'=> 'present|array'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => 'Dữ liệu tối đa 255 ký tự',
                'unique' => ':attribute đã tồn tại trên hệ thống',
                // 'present' => 'Vui lòng chọn quyền cho vai trò'
            ],
            [
                'name' => 'Tên quyền',
                'description' => 'Mô tả vai trò'
            ]
        );
        //Thêm role
        $role = Role::create(
            [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
            ]
        );
        //Thêm permission của role vừa thêm vào bảng role_permission
        $role -> permissions()->attach($request->input('permission_id'));    
        
        return redirect('admin/role/add')->with('status', 'Thêm vai trò thành công');
        
    }

    function edit($id){
        $list_permission = Permission::all()->groupBy(function($permission){
            return explode('.', $permission->slug)[0];
        });
        $role = Role::find($id);
        return view('admin.role.edit', compact('role', 'list_permission'));
    }
    function update($id, Request $request){
        $role = Role::find($id);
        $request -> validate(
            [
                'name' => 'required|max:255|unique:roles,name,'.$role->id,
                'description' => 'required',
                'permission_id'=> 'nullable|array',
                'permission_id.*' => 'exists:permissions,id',
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => 'Dữ liệu tối đa 255 ký tự',
                'unique' => ':attribute đã tồn tại trên hệ thống',
            ],
            [
                'name' => 'Tên quyền',
                'description' => 'Mô tả vai trò'
            ]
        );
        
        $role->update(
            [
                'name' => $request->name,
                'description' => $request->description,
            ]
        );
        //Thay vì sử dụng attach() để gán quyền cho vai trò, chúng ta sử dụng sync() 
        //để đồng bộ hóa danh sách quyền đã chọn với vai trò. 
        //Phương thức sync() sẽ tự động loại bỏ các quyền không được chọn và cập nhật danh sách quyền mới.
        $role->permissions()->sync($request->input('permission_id', []));
        return redirect('admin/role/list')->with('status', 'Chỉnh sửa thông tin của vai trò thành công');
    }
}
