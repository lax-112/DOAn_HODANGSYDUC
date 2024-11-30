@extends('layouts.client')
@section('content')
    <!-------------------- Breadcrumb -------------------->
    <div class="breadcrumb-wrap">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: ''" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="#">Khách Sạn</a></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="box-slide slide-tour list-tours">
        <div class="container" style="margin-bottom: 50px;">
            <div class="header-slide d-flex align-items-end">
                <p class="title-slide" style="margin-bottom: 50px;">Danh sách khách sạn</p>
            </div>
            <div style="display: flex; flex-wrap: wrap; gap: 15px;">
                @foreach($hottels as $room)
                    <div class="hotel-card">
                        <h6 class="hotel-name">Khách sạn: {{ $room->hotel_name }}</h6>
                        <div class="hotel-image">
                            <img src="{{ asset('storage/images/rooms/'.$room->image) }}" alt="{{ $room->hotel_name }}">
                        </div>
                        <a href="{{ route('client.hottel.detail', ['id' => $room->id]) }}" class="btn btn-primary book-button">Xem phòng</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        .hotel-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            width: 360px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 280px; /* Đảm bảo chiều cao đủ lớn để chứa tất cả nội dung */
        }

        .hotel-image img {
            max-height: 150px;
            width: auto;
            height: auto;
            max-width: 100%;
            margin-bottom: 10px; /* Khoảng cách dưới ảnh */
        }

        .book-button {
            background-color: #007bff;
            border: none;
            margin-top: auto; /* Đẩy nút xuống dưới cùng */
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .book-button:hover {
            background-color: #0056b3; /* Hiệu ứng hover cho nút */
        }
    </style>
@endsection
