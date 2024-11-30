@extends('layouts.admin')

@section('admin')

<div class="container mt-4">
    <h1 class="mb-4">Sửa vé máy bay</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('flight_tickets.update', $flightTicket->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="flight_number">Số chuyến bay</label>
            <input type="text" name="flight_number" class="form-control" value="{{ $flightTicket->flight_number }}" required>
        </div>
        <div class="form-group">
            <label for="airline">Hãng hàng không</label>
            <input type="text" name="airline" class="form-control" value="{{ $flightTicket->airline }}" required>
        </div>
        <div class="form-group">
            <label for="departure_city">Thành phố khởi hành</label>
            <input type="text" name="departure_city" class="form-control" value="{{ $flightTicket->departure_city }}" required>
        </div>
        <div class="form-group">
            <label for="arrival_city">Thành phố đến</label>
            <input type="text" name="arrival_city" class="form-control" value="{{ $flightTicket->arrival_city }}" required>
        </div>
        <div class="form-group">
            <label for="departure_time">Thời gian khởi hành</label>
            <input type="datetime-local" name="departure_time" class="form-control" value="{{ \Carbon\Carbon::parse($flightTicket->departure_time)->format('Y-m-d\TH:i') }}" required>
        </div>
        <div class="form-group">
            <label for="arrival_time">Thời gian đến</label>
            <input type="datetime-local" name="arrival_time" class="form-control" value="{{ \Carbon\Carbon::parse($flightTicket->arrival_time)->format('Y-m-d\TH:i') }}" required>
        </div>
        <div class="form-group">
            <label for="price">Giá vé</label>
            <input type="number" name="price" class="form-control" value="{{ $flightTicket->price }}" required>
        </div>
        <div class="form-group">
            <label for="available_seats">Số ghế trống</label>
            <input type="number" name="available_seats" class="form-control" value="{{ $flightTicket->available_seats }}" required>
        </div>
        <button type="submit" class="btn btn-success">Cập nhật vé máy bay</button>
    </form>

</div>

@endsection
