@extends('layouts.admin')
@section('title', 'Danh sách phản hồi từ khách hàng')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>            
        @endif
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách phản hồi từ khách hàng</h5>
            {{-- <div class="form-search form-inline">
                <div class="form-search form-inline">
                    <form action="{{url('admin/order/list')}}" method="get">
                        <input style="max-width: 65%;" type="text" name='key' value="{{request()->input('key')}}" class="form-control form-search" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div> --}}
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['status'=>'wait_reply'])}}" class="text-primary">Đang đợi phản hồi<span class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'reply'])}}" class="text-primary">Đã phản hồi<span class="text-muted">({{$count[1]}})</span></a>
            </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Tên khách hàng</th>
                            <th scope="col">Nội dung đánh giá</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Số sao</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Phản hồi</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $stt=0;
                        @endphp
                        @foreach ($list_comment as $comment)
                            @php
                                $stt++;
                            @endphp
                            <form action="{{route('rely_comment', $comment->id)}}" method="post" >
                                @csrf
                                <tr>
                                    <td>
                                        <input type="checkbox" name="list_check[]" value="{{$comment->id}}">
                                    </td>
                                    <td>{{$stt}}</td>
                                    <td>{{$comment->user->name}}</td>
                                    <td>{{$comment->content}}</td>
                                    <td>{{$comment->created_at}}</td>
                                    <td>
                                        @foreach ($ratings as $rating)
                                            @if ($rating->user_id == $comment->user_id && $rating->product_id == $comment->product_id)
                                                {{$rating->rating_value}}/5
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{$comment->product->name}}</td>
                                    <td>
                                        @if ($comment->status_comment_id == 1)
                                        <span class="badge badge-warning">{{$comment->status_comment->name}}</span>
                                        @else
                                        <span class="badge badge-success">{{$comment->status_comment->name}}</span>
                                        @endif
                                       
                                    </td>
                                    <td>
                                        @if ($comment->status_comment_id == 1)
                                        <textarea name="reply_content" id="" cols="30" rows="10"></textarea>
                                        @else
                                            Đã phản hồi
                                        @endif
                                    </td>
                                    <td>
                                        @if ($comment->status_comment_id == 1)
                                        <button class="btn btn-success">Phản hồi</button>
                                        @else
                                        
                                        @endif
                                        
                                    </td>
                                </tr>
                            </form>
                           
                        @endforeach        
                    </tbody>
                </table>
            {{$list_comment->links()}}
        </div>
    </div>
</div>
    
@endsection