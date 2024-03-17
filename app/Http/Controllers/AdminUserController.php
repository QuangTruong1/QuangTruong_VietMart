<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    //
    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'user']);
            return $next($request);
        });    

    }
    function list(Request $request){
        $status = $request->input('status');
        $list_act = [
            'delete'=> "Xóa tạm thời",
        ];
        if($status == 'trash'){
            $list_act = [
                'restore' => "Khôi phục",
                'force' => 'Xóa vĩnh viễn',
            ];
            $users = User::onlyTrashed()->paginate(5); 
        }else{
            $key = "";
            if($request->input('key')){
                $key = $request->input('key');               
            }    
            $users = User::where('name', 'like', '%' . $key . '%')->paginate(5);  
        }
        $count_user_trash = User::onlyTrashed()->count();
        $count_user_active = User::count();
        $count = [$count_user_active, $count_user_trash];
        return view('admin.user.list', compact(['users', 'count', 'list_act']));
    }

    
    function add(){     
        $list_role = Role::all();
        return view('admin.user.add', compact('list_role'));
    }
    
    function store(Request $request){
        if($request->input('btn-add')){

            //Validation dữ liệu vào
            $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                ],
                [
                    'required' => ':attribute không được để trống',
                    'unique' => ':attribute đã tồn tại trên hệ thống',     
                    'max' => ':attribute có độ dài tối đa 255 ký tự',
                    'email' => 'Chưa đúng định dạng email',    
                    'confirmed' => 'Xác nhận mật khẩu không đúng',     
                ],
                [
                    'name' => "Họ và tên",
                    'email' => "Email người dùng",
                    'password' => "Mật khẩu",
                ]
            );
            //Thêm dữ liệu user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user -> roles()->attach($request->input('roles'));    

            return redirect('admin/user/list')->with('status', 'Thêm mới user thành công');

        }
    }

    function delete($id){
        if(Auth::id() != $id){
            $user = User::find($id);

            $user->delete();

            return redirect('admin/user/list')->with('status', 'Xóa thành công!');
        }else{
            return redirect('admin/user/list')->with('status', 'Bạn không thể tự xóa chính mình');
        }
    }

    function action(Request $request){
        $list_check = $request-> input('list_check');
        if($list_check){
            //Xóa phần tử đang đăng nhập
            foreach($list_check as $k => $id){
                if(Auth::id() == $id){
                    unset($list_check[$k]);
                }
            }
            //Thực hiện tác vụ
            if(!empty($list_check)){
                $act = $request->input('act');
                if($act == "delete"){
                    User::destroy($list_check);
                    return redirect('admin/user/list')->with('status', 'Xóa thành công các phần tử đã chọn');
                }
                else if($act == "restore"){
                    User::withTrashed()->whereIn('id', $list_check) -> restore();
                    return redirect('admin/user/list')->with('status', 'Khôi phục thành công các phần tử đã chọn');
                }
                else{
                    User::withTrashed()->whereIn('id', $list_check) -> forceDelete();
                    return redirect('admin/user/list')->with('status', 'Xóa vĩnh viễn thành công các phần tử đã chọn');
                }
            }
            return redirect('admin/user/list')->with('status', 'Bạn không thể thao tác trên chính phần tử là bạn');
        }
        else{
            return redirect('admin/user/list')->with('status', 'Vui lòng chọn phần tử để thực hiện thao tác');
        }
    }

    function edit($id){
        $user = User::find($id);   
        $list_role = Role::all();     
        return view('admin.user.edit', compact('user', 'list_role'));
    }

    function update(Request $request, $id){
        $user = User::find($id);
        $request->validate(
            [
                'name' => 'required|string|max:255',                
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài tối đa 255 ký tự',                 
            ],
            [
                'name' => "Họ và tên",               
            ]
        );
        //Chỉnh sửa dữ liệu
        $user->update([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);
        $user->roles()->sync($request->input('roles', []));
        return redirect('admin/user/list')->with('status', 'Cập nhật thành công');
    }
}
