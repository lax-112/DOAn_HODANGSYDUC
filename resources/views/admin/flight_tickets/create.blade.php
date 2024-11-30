@extends('layouts.admin')

@section('admin')

<div class="container">
    <h1>Tạo vé máy bay mới</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('flight_tickets.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="flight_number">Số chuyến bay</label>
            <input type="text" name="flight_number" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="airline">Hãng hàng không</label>
            <input type="text" name="airline" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="departure_city">Thành phố khởi hành</label>
            <input type="text" name="departure_city" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="arrival_city">Thành phố đến</label>
            <input type="text" name="arrival_city" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="departure_time">Thời gian khởi hành</label>
            <input type="datetime-local" name="departure_time" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="arrival_time">Thời gian đến</label>
            <input type="datetime-local" name="arrival_time" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="price">Giá</label>
            <input type="number" name="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="available_seats">Số ghế còn</label>
            <input type="number" name="available_seats" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
</div>

@endsection
