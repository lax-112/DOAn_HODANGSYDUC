@extends('layouts.admin')

@section('admin')

<div class="" style="margin-left: 50px;margin-right: 50px;">
    <h1 class="mb-4 text-center">Danh sách vé máy bay đã đặt</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped table-hover">
        <thead style="background-color: white; color: black;">
            <tr>
                <th scope="col" class="text-center">STT</th>
                <th scope="col">Tên khách hàng</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Email</th>
                <th scope="col">Số lượng hành khách</th>
                <th scope="col">Chuyến bay</th>
                <th scope="col">Tổng tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookedFlights as $index => $booking)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $booking->user_name }}</td>
                    <td>{{ $booking->phone }}</td>
                    <td>{{ $booking->email }}</td>
                    <td>{{ $booking->num_of_passengers }}</td>
                    <td>{{ $booking->flightTicket->flight_number ?? 'N/A' }}</td>
                    <td>{{ number_format($booking->total_price, 0, ',', '.') }} VND</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
