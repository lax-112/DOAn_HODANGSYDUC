@extends('layouts.admin')

@section('admin')

<div class="" style="margin-left: 50px;margin-right: 50px;">
    <h1 class="mb-4 text-center">Danh sách vé máy bay</h1>

    <a href="{{ route('flight_tickets.create') }}" class="btn btn-primary mb-3">
        Thêm vé máy bay
    </a>

    <a href="{{ route('booked_flights.index') }}" class="btn btn-secondary mb-3 ml-2">
        Xem danh sách vé máy bay đã đặt
    </a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped table-hover">
        <thead style="background-color: white; color: black;">
            <tr>
                <th scope="col" class="text-center">STT</th>
                <th scope="col">Số chuyến bay</th>
                <th scope="col">Hãng hàng không</th>
                <th scope="col">Thành phố khởi hành</th>
                <th scope="col">Thành phố đến</th>
                <th scope="col">Thời gian khởi hành</th>
                <th scope="col">Thời gian đến</th>
                <th scope="col">Giá</th>
                <th scope="col">Số ghế còn</th>
                <th scope="col" class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($flightTickets as $index => $flightTicket)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $flightTicket->flight_number }}</td>
                    <td>{{ $flightTicket->airline }}</td>
                    <td>{{ $flightTicket->departure_city }}</td>
                    <td>{{ $flightTicket->arrival_city }}</td>
                    <td>{{ \Carbon\Carbon::parse($flightTicket->departure_time)->format('d/m/Y H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($flightTicket->arrival_time)->format('d/m/Y H:i') }}</td>
                    <td>{{ number_format($flightTicket->price, 0, ',', '.') }} VND</td>
                    <td>{{ $flightTicket->available_seats }}</td>
                    <td class="text-center">
                        <a href="{{ route('flight_tickets.edit', $flightTicket->id) }}" class="btn btn-warning btn-sm mb-1">
                            <i class="fa fa-edit"></i>
                        </a>

                        <form action="{{ route('flight_tickets.destroy', $flightTicket->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
