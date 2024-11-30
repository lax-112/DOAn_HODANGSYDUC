@extends('layouts.client')

@section('content')
    <!-------------------- Breadcrumb -------------------->
    <div class="breadcrumb-wrap">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: ''" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">Xe du lịch</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Đặt xe</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-------------------- Order Form -------------------->
    <div class="container mt-4" style="margin-bottom: 50px;">
        <h1 class="text-center">Đặt xe: {{ $car->name }}</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
            <form action="{{ route('cars.confirmOrder', ['id' => $car->id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Ngày bắt đầu</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Ngày kết thúc</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_name" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <input type="hidden" name="car_id" value="{{ $car->id }}">
                    <button type="submit" class="btn btn-primary" style="background-color: #007bff; border: none;">Xác nhận đặt xe</button>
                </form>
            </div>
        </div>
    </div>
@endsection
