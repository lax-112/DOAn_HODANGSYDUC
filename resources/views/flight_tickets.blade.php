@extends('layouts.client')
@section('content')
    <!-------------------- Breadcrumb -------------------->
    <div class="breadcrumb-wrap">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: ''" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="#">Vé máy bay</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            @foreach ($flight_tickets as $ticket)
                <div class="col-md-4 mb-4">
                    <div class="card" style="border: 1px solid #ddd; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center;">
                        <!-- Thêm logo hình máy bay -->
                        <i class="fas fa-plane-departure" style="font-size: 2rem; color: #007bff; margin-bottom: 10px;"></i>
                        
                        <h5 class="card-title" style="font-size: 1.25rem; font-weight: bold; margin-bottom: 10px;">
                            {{ $ticket->departure_city }} <i class="fas fa-arrow-right" style="margin-right: 5px;margin-left: 5px;"></i> {{  $ticket->arrival_city }}
                        </h5>
                        <p class="card-text" style="font-size: 1rem; color: #777; margin-bottom: 10px;">
                            khởi hành: {{ date('d/m/Y H:i', strtotime($ticket->departure_time)) }} <br>
                            Đến: {{ date('d/m/Y H:i', strtotime($ticket->arrival_time)) }}
                        </p>
                        <p class="card-price" style="font-size: 1.5rem; color: #d63384; font-weight: bold; margin-bottom: 10px;">
                            {{ number_format($ticket->price) }} VND
                        </p>
                        <a href="{{ route('flight-tickets.book', $ticket->id) }}" class="btn btn-primary" style="background-color: #007bff; border: none; margin-top: 10px;">Đặt vé</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
