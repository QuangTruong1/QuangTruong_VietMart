<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/solid.min.css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    {{-- @can('post.add', 'product.add') --}}
    <script src="https://cdn.tiny.cloud/1/li0xlj16d21qiirdngsl2ptrkbidkinkeqggekoqxemch66g/tinymce/4/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        var editor_config = {
            path_absolute : "http://localhost/DoAn/vietmart/",
            selector: "textarea",
            plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
            file_browser_callback : function(field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.open({
                file : cmsURL,
                title : 'Filemanager',
                width : x * 0.8,
                height : y * 0.8,
                resizable : "yes",
                close_previous : "no"
            });
            }
        };

        tinymce.init(editor_config);
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    {{-- @endcan --}}

    <title>@yield('title')</title>
</head>

<body>
    <div id="warpper" class="nav-fixed">
        <nav class="topnav shadow navbar-light bg-white d-flex">
            <div class="navbar-brand"><a href="?"> VIET MART</a></div>
            <div class="nav-right ">
                <div class="btn-group mr-auto">
                                 
                </div>
                <div class="btn-group">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button> 
                 
                    <div class="dropdown-menu dropdown-menu-right">                        
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Tài khoản') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('home')">
                            {{ __('Quay về') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Thoát') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        <!-- end nav  -->
        @php
            $module_active = session('module_active') 
        @endphp
        <div id="page-body" class="d-flex">
            <div id="sidebar" class="bg-white">               
                <ul id="sidebar-menu">
                    @canany(['dashboard.view'])
                    <li class="nav-link {{$module_active == 'dashboard' ? 'active' : ''}}">
                        <a href="{{url('admin')}}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Dashboard
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                    </li>
                    @endcanany                                    

                    @canany(['post.view', 'post.add', 'post.edit', 'post.delete'])
                    <li class="nav-link {{$module_active == 'post' ? 'active' : ''}}">
                        <a href="{{url('admin/post/list')}}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Bài viết
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            @can('post.add')
                            <li><a href="{{url('admin/post/add')}}">Thêm mới</a></li>
                            @endcan
                            @can('post.view')
                            <li><a href="{{url('admin/post/list')}}">Danh sách</a></li></li>
                            @endcan
                            <li><a href="{{url('admin/post/cat/list')}}">Danh mục</a></li>
                        </ul>
                    </li>
                    @endcanany

                    @canany(['product.view', 'product.add', 'product.edit', 'product.delete'])
                    <li class="nav-link {{$module_active == 'product' ? 'active' : ''}}">
                        <a href="{{url('admin/product/list?status=approved')}}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Sản phẩm
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            @can('product.add')
                            <li><a href="{{url('admin/product/add')}}">Thêm mới</a></li>
                            @endcan

                            @can('product.view')
                            <li><a href="{{url('admin/product/list?status=approved')}}">Danh sách</a></li>
                            @endcan

                            @can('industry.view')
                            <li><a href="{{url('admin/product/industry/list')}}">Danh mục ngành</a></li>
                            @endcan

                            @can('segment.view')
                            <li><a href="{{url('admin/product/segment/list')}}">Danh mục phân khúc</a></li>
                            @endcan

                            @can('product.view_cat')
                            <li><a href="{{url('admin/product/cat/list')}}">Danh mục loại</a></li>
                            @endcan

                            @canany(['general_info.view', 'general_info.add', 'general_info.edit', 'general_info.delete'])
                            <li class="nav-link 
                                @if(isset($module_active_child))
                                    {{$module_active_child == 'general_info' ? 'active' : ''}}"
                                @endif
                                
                                id="general_info" >
                                <a style="display: block; padding: 0" href="#">
                                    Thông tin chung
                                    <i class="arrow-child fas fa-angle-right"></i>
                                </a>
                                
                                <ul class="sub-menu-child">
                                    <li><a href="{{url('admin/product/material/list')}}">Chất liệu</a></li>
                                    <li><a href="{{url('admin/product/brand/list')}}">Thương hiệu</a></li>
                                    <li><a href="{{url('admin/product/pattern/list')}}">Mẫu</a></li>
                                </ul>
                            </li>
                            @endcanany
                            @canany(['attribute.view', 'attribute_value.view'])
                            <li class="nav-link 
                                @if(isset($module_active_child))
                                    {{$module_active_child == 'private_info' ? 'active' : ''}}"
                                @endif
                            id="private_info" >
                                <a style="display: block; padding: 0" href="#">
                                    Thông tin riêng 
                                    <i class="arrow-child fas fa-angle-right"></i>
                                </a>
                                
                                <ul class="sub-menu-child">
                                    @can('attribute.view')
                                    <li><a href="{{url('admin/product/attribute/list')}}">Danh mục thuộc tính phát sinh</a></li>
                                    @endcan
        
                                    @can('attribute_value.view')
                                    <li><a href="{{url('admin/product/attribute_value/list')}}">Giá trị thuộc tính phát sinh</a></li>
                                    @endcan
                                </ul>
                            </li>
                            @endcanany
                        </ul>
                    </li>
                    @endcanany
            
                    @canany(['order.view', 'order.delete', 'reply_comment.view'])
                    <li class="nav-link {{$module_active == 'order' ? 'active' : ''}}">
                        <a href="{{url('admin/order/list?status=finish')}}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Bán hàng
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            @can('order.view')
                            <li><a href="{{url('admin/order/list?status=finish')}}">Đơn hàng</a></li>
                            @endcan

                            @can('reply_comment.view')
                            <li><a href="{{url('admin/product/comments?status=wait_reply')}}">Đánh giá sản phẩm</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany

                    @canany(['voucher.view', 'voucher.edit', 'voucher.add', 'voucher.delete'])
                    <li class="nav-link {{$module_active == 'voucher' ? 'active' : ''}}">
                        <a href="{{url('admin/voucher/list?status=valid')}}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Khuyến mãi 
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            @can('voucher.add')
                            <li><a href="{{url('admin/voucher/add')}}">Thêm mới</a></li>
                            @endcan

                            @can('voucher.view')
                            <li><a href="{{url('admin/voucher/list?status=valid')}}">Danh sách</a></li>
                            @endcan
                        
                        </ul>
                    </li>
                    @endcanany

                    @canany(['user.view', 'user.add', 'user.edit', 'user.delete'])
                    <li class="nav-link {{$module_active == 'user' ? 'active' : ''}}">
                        <a href="{{url('admin/user/list')}}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Users
                        </a>
                        <i class="arrow fas fa-angle-right"></i>

                        <ul class="sub-menu">
                            @can('user.add')
                            <li><a href="{{url('admin/user/add')}}">Thêm mới</a></li>
                            @endcan
                            @can('user.view')
                            <li><a href="{{url('admin/user/list')}}">Danh sách</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany

                    {{-- Phân quyền view, để có thể hiển thị hoặc không --}}
                    @canany(['role.view', 'role.add', 'role.edit', 'role.delete', 'permission.view'])
                    <li class="nav-link {{$module_active == 'permission' ? 'active' : ''}}">
                        <a href="{{route('permission.add')}}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Phân quyền
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            @can('permission.view')
                            <li><a href="{{route('permission.add')}}">Quyền</a></li>
                            @endcan
                            @can('role.add')
                            <li><a href="{{url('admin/role/add')}}">Thêm vai trò</a></li>
                            @endcan
                            <li><a href="{{url('admin/role/list')}}">Danh sách vai trò</a></li>
                            
                        </ul>
                    </li>
                    @endcanany

                </ul>
            </div>
            <div id="wp-content">
                @yield('content')            
            </div>
        </div>


    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{asset('js/app.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    @yield("script_revenue")
    @yield("script_Order")
</body>

</html>