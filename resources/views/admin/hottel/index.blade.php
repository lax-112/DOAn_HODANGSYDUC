@extends('layouts.admin')

@section('admin')

<div class="" style="margin-left: 50px;margin-right: 50px;">
    <h2 class="mb-4">Danh sách đặt phòng khách sạn</h2>

    @if ($bookings->isEmpty())
        <div class="alert alert-warning">
            Chưa có đặt phòng nào.
        </div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên khách hàng</th>
                    <th>Thông tin liên lạc</th>
                    <th>Phòng</th>
                    <th>Ngày nhận phòng</th>
                    <th>Ngày trả phòng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->customer_name }}</td>
                        <td>{{ $booking->contact_info }}</td>
                        <td>{{ $booking->room ? $booking->room->name : 'Không xác định' }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('d/m/Y') }}</td>
                        <td>{{ number_format($booking->total_price) }} VND</td>
                        <td>{{ ucfirst($booking->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
