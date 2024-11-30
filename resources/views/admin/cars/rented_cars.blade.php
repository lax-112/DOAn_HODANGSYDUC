@extends('layouts.admin')

@section('admin')
<div class="" style="margin-left: 50px;margin-right: 50px;">
    <h1 class="mb-4 text-center">Danh sách xe đã đặt</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped table-hover">
        <thead style="background-color: white; color: black;">
            <tr>
                <th scope="col" class="text-center">STT</th>
                <th scope="col">Tên xe</th>
                <th scope="col">Hãng xe</th>
                <th scope="col">Biển số</th>
                <th scope="col">Loại xe</th>
                <th scope="col">Số ghế</th>
                <th scope="col">Giá thuê (VND/ngày)</th>
                <th scope="col">Người đặt</th>
                <th scope="col">Ngày bắt đầu</th>
                <th scope="col">Ngày kết thúc</th>
                <th scope="col" class="text-center">Số điện thoại</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rentedCars as $index => $order)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $order->car_name }}</td>
                <td>{{ $order->car_brand }}</td>
                <td>{{ $order->license_plate }}</td>
                <td>{{ $order->type }}</td>
                <td>{{ $order->seats }}</td>
                <td>{{ number_format($order->price_per_day, 0, ',', '.') }} VND</td>
                <td>{{ $order->user_name }}</td>
                <td>{{ $order->start_date }}</td>
                <td>{{ $order->end_date }}</td>
                <td>{{ $order->phone }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
