@extends('layouts.admin')

@section('admin')

<div class="container">
    <h1>Sửa xe</h1>

    <!-- Hiển thị lỗi nếu có -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form update xe -->
    <form action="{{ route('cars.update', ['id' => $car->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Các trường nhập liệu -->
        <div class="form-group">
            <label for="name">Tên xe</label>
            <input type="text" name="name" class="form-control" value="{{ $car->name }}" required>
        </div>
        <div class="form-group">
            <label for="brand">Hãng xe</label>
            <input type="text" name="brand" class="form-control" value="{{ $car->brand }}" required>
        </div>
        <div class="form-group">
            <label for="license_plate">Biển số xe</label>
            <input type="text" name="license_plate" class="form-control" value="{{ $car->license_plate }}" required>
        </div>
        <div class="form-group">
            <label for="type">Loại xe</label>
            <input type="text" name="type" class="form-control" value="{{ $car->type }}" required>
        </div>
        <div class="form-group">
            <label for="seats">Số ghế</label>
            <input type="number" name="seats" class="form-control" value="{{ $car->seats }}" required>
        </div>
        <div class="form-group">
            <label for="price_per_day">Giá thuê mỗi ngày</label>
            <input type="number" name="price_per_day" class="form-control" value="{{ $car->price_per_day }}" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="is_available">Trạng thái sẵn sàng</label>
            <select name="is_available" class="form-control" required>
                <option value="1" {{ $car->is_available ? 'selected' : '' }}>Có sẵn</option>
                <option value="0" {{ !$car->is_available ? 'selected' : '' }}>Không có sẵn</option>
            </select>
        </div>
        
        <!-- Hiển thị hình ảnh hiện tại -->
        <div class="form-group">
            <label for="image">Hình ảnh hiện tại</label><br>
            <img src="{{ asset('storage/' . $car->image) }}" alt="Current Car Image" style="max-width: 200px; max-height: 150px;"><br><br>
            <label for="image">Chọn hình ảnh mới (nếu có)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <!-- Nút submit -->
        <button type="submit" class="btn btn-success">Cập nhật xe</button>
    </form>
</div>

@endsection
