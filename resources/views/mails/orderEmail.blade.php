Xác nhận đơn hàng

Tên khách hàng: {{$name}}
Địa chỉ: Số {{$home_number}}, {{$address}}
Số điện thoại: {{$phone}}
Tổng đơn hàng: {{$total}}
<table>
    <thead>
        <th>Sản phẩm</th>
        <th>Số lượng</th>
        <th>Giá</th>
        <th>Tổng tiền</th>
    </thead>
    <tbody>
        @foreach ($cart as $product)
        <tr>
            <td>{{$product->name}}</td>
            <td>{{$product->quantity}}</td>
            <td>{{$product->price}}</td>
            <td>{{$product->price * $product->quantity}}</td>    
        </tr>
        @endforeach
        
    </tbody>
</table>