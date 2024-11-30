@extends('layouts.client')

@section('content')
    <!-------------------- Breadcrumb -------------------->
    <div class="breadcrumb-wrap">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: ''" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="#">Xe du lịch</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-------------------- Car List -------------------->
    <div class="container mt-4" style="margin-bottom: 50px;">
        <h1 class="text-center">Danh sách xe du lịch</h1>
        <div class="row">
            @foreach($cars as $car)
                <div class="col-md-6 mb-6" style="margin-bottom: 50px;">
                    <div class="card" style="border: none; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); transition: transform 0.3s;">
                        <img src="{{ asset('storage/'.$car->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="">
                        <h3 class="card-title" style="text-align: center;">{{ $car->name }}</h3>
                        <div class="card-body" style="text-align: center;    display: flex;flex-direction: row;flex-wrap: nowrap;justify-content: space-around;">
                            <div class="d-flex justify-content-center align-items-center">
                                <i class="fas fa-car" style="margin-right: 5px;"></i> {{ $car->brand }}
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <i class="fas fa-tag" style="margin-right: 5px;"></i> {{ $car->license_plate }}
                            </div>
                            <!-- <div class="d-flex justify-content-center align-items-center">
                                <i class="fas fa-car-side" style="margin-right: 5px;"></i> {{ $car->type }}
                            </div> -->
                            <div class="d-flex justify-content-center align-items-center">
                                <i class="fas fa-users" style="margin-right: 5px;"></i> {{ $car->seats }}
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <i class="fas fa-money-bill-wave" style="margin-right: 5px;"></i> {{ number_format($car->price_per_day, 0, ',', '.') }} VNĐ
                            </div>
                            <!-- <div class="d-flex justify-content-center align-items-center">
                                <i class="fas fa-check-circle" style="margin-right: 5px;"></i>
                                <p class="card-text" style="margin: 0;">Trạng thái: {{ $car->is_available ? 'Có sẵn' : 'Không có sẵn' }}</p>
                            </div> -->
                        </div>
                        <a href="{{ route('cars.order', ['id' => $car->id]) }}" class="btn btn-primary" style="background-color: #007bff; border: none;">Đặt xe</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
