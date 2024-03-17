
@extends('layouts.admin')
@section('title', 'DashBoard')
@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="col">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-header">HOÀN THÀNH</div>
                <div class="card-body">
                    <h5 class="card-title">{{$count[0]}}</h5>
                    <p class="card-text">Đơn hàng giao dịch thành công</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐANG XỬ LÝ</div>
                <div class="card-body">
                    <h5 class="card-title">{{$count[1]}}</h5>
                    <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                <div class="card-header">DOANH SỐ</div>
                <div class="card-body">
                    <h5 class="card-title">{{number_format($total, 0, '', '.')}}đ</h5>
                    <p class="card-text">Doanh số hệ thống</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG HỦY</div>
                <div class="card-body">
                    <h5 class="card-title">{{$sum_order_trash}}</h5>
                    <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <figure class="highcharts-figure-revenue">
                <div id="container-revenue"></div>                
            </figure>
        </div>
        <div class="col-4">
            <figure class="highcharts-figure">
                <div id="container"></div>               
            </figure>
        </div>
       
    </div>
    <!-- end analytic  -->
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>            
    @endif
    <div class="card">
        <div class="card-header font-weight-bold">
            ĐƠN HÀNG MỚI
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Mã đơn hàng</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Kiểu/Loại</th>
                        <th scope="col">Màu</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Giá trị</th>
                        <th scope="col">Tổng giá trị</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thời gian</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $stt=0;
                    @endphp
                    @foreach ($list_order_detail as $order_detail)
                        @php
                            $stt++;
                        @endphp
                        <tr>
                            <td>{{$stt}}</td>
                            <td>{{$order_detail->order->code}}</td>
                            <td>{{$order_detail->product->name}}</td>
                            <td>{{$order_detail->type}}</td>
                            <td>{{$order_detail->color}}</td>
                            <td>{{$order_detail->quantity}}</td>
                            <td>{{number_format($order_detail->price, 0, '', '.')}}</td>
                            <td>{{number_format($order_detail->total, 0, '', '.')}}</td>
                            <td>
                                @if ($order_detail->status_id == 1)
                                    <span class="badge badge-warning">{{$order_detail->status->name}}</span>
                                    @else
                                    <span class="badge badge-success">{{$order_detail->status->name}}</span>
                                    @endif
                            </td>
                            <td>{{$order_detail->created_at}}</td>
                            <td>
                                <a href="{{route('delete_order', $order_detail->id)}}" onclick="return confirm('Bạn có chắc muốn hủy Đơn hàng?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach        
                </tbody>
            </table>
           {{$list_order_detail->links()}}
        </div>
    </div>

</div>
@endsection



@section("script_revenue")
    <style>
        .highcharts-figure-revenue,
        .highcharts-data-table table {
            min-width: 360px;
            max-width: 800px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

    </style>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script type="text/javascript">
  
        Highcharts.chart('container-revenue', {
        title: {
            text: 'Biểu đồ thống kê doanh thu theo tháng',
            align: 'center'
        },        

        yAxis: {
            title: {
                text: 'Giá trị VNĐ'
            }           
        },

        xAxis: {
            categories: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6',
                'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
            accessibility: {
                description: 'Months of the year'
            }
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineColor: '#666666',
                    lineWidth: 2
                }
            }
        },

        series: [{
            name: 'Doanh thu',
            data: <?php echo json_encode($dataForChart); ?>
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

        });

    </script>
@endsection



@section("script_Order")
<style>
    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 320px;
        max-width: 660px;
        margin: 1em auto;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #ebebeb;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }

</style>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script type="text/javascript">
    var order_hoanthanh = {{ $count[0] }};
    var order_dangxuly = {{ $count[1] }};  
    var order_huy = {{ $sum_order_trash }};      
    var totalOrders = order_hoanthanh + order_dangxuly + order_huy; 

    // Tính phần trăm cho mỗi loại order
    var percentageHoanthanh = parseFloat((order_hoanthanh / totalOrders * 100).toFixed(2));
    var percentageDangxuly = parseFloat((order_dangxuly / totalOrders * 100).toFixed(2));
    var percentageHuy = parseFloat((order_huy / totalOrders * 100).toFixed(2));
    
    // Create the chart
    Highcharts.chart('container', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Thông kế đơn hàng',
            align: 'center'
        },
        accessibility: {
            announceNewData: {
                enabled: true
            },
            point: {
                valueSuffix: '%'
            }
        },

        plotOptions: {
            series: {
                borderRadius: 5,
                dataLabels: [{
                    enabled: true,
                    distance: 15,
                    format: '{point.name}'
                }, {
                    enabled: true,
                    distance: '-30%',
                    filter: {
                        property: 'percentage',
                        operator: '>',
                        value: 5
                    },
                    format: '{point.y:.1f}%',
                    style: {
                        fontSize: '0.9em',
                        textOutline: 'none'
                    }
                }]
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },

        series: [
            {
                name: 'Đơn hàng',
                colorByPoint: true,
                data: [
                    {
                        name: 'Đang xử lý',
                        y: percentageDangxuly,
                        // drilldown: 'Chrome'
                    },
                    {
                        name: 'Hoàn thành',
                        y: percentageHoanthanh,
                        // drilldown: 'Safari'
                    },
                    {
                        name: 'Hủy',
                        y: percentageHuy,
                        // drilldown: 'Edge'
                    },
                
                ]
            }
        ],
    });

</script>
@endsection