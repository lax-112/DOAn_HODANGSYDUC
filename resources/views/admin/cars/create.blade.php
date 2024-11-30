@extends('layouts.admin')

@section('admin')

<div class="container">
    <h1>Tạo xe mới</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Tên xe</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="brand">Hãng xe</label>
            <input type="text" name="brand" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="license_plate">Biển số xe</label>
            <input type="text" name="license_plate" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="type">Loại xe</label>
            <input type="text" name="type" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="seats">Số ghế</label>
            <input type="number" name="seats" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="price_per_day">Giá thuê mỗi ngày</label>
            <input type="number" name="price_per_day" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="is_available">Trạng thái sẵn sàng</label>
            <select name="is_available" class="form-control">
                <option value="1">Có sẵn</option>
                <option value="0">Không có sẵn</option>
            </select>
        </div>
        <div class="form-group">
            <label for="image">Hình ảnh</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
</div>

@endsection
