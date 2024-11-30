@extends('layouts.admin')

@section('admin')

<div class="" style="margin-left: 50px;margin-right: 50px;">
    <h1 class="mb-4 text-center">Danh sách xe</h1>

    <a href="{{ route('cars.create') }}" class="btn btn-primary mb-3">
        Thêm xe mới
    </a>
    <a href="{{ route('cars.rented') }}" class="btn btn-secondary mb-3">
        Xem xe đã được đặt
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
            <th scope="col">Tên xe</th>
            <th scope="col">Hãng xe</th>
            <th scope="col">Biển số</th>
            <th scope="col">Loại xe</th>
            <th scope="col">Số ghế</th>
            <th scope="col">Giá thuê (VND/ngày)</th>
            <th scope="col">Tình trạng</th>
            <th scope="col">Hình ảnh</th> <!-- Cột Hình ảnh -->
            <th scope="col" class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cars as $index => $car)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $car->name }}</td>
            <td>{{ $car->brand }}</td>
            <td>{{ $car->license_plate }}</td>
            <td>{{ $car->type }}</td>
            <td>{{ $car->seats }}</td>
            <td>{{ number_format($car->price_per_day, 0, ',', '.') }} VND</td>
            <td>{{ $car->is_available ? 'Còn' : 'Hết' }}</td>
            <td>
                <img src="{{ asset('storage/' . $car->image) }}" width="100"> <!-- Hiển thị hình ảnh -->
            </td>
            <td class="text-center">
                <a href="{{ route('cars.edit', ['id' => $car->id]) }}" class="btn btn-warning btn-sm mb-1"><i class="fa fa-edit"></i></a>

                <form action="{{ route('cars.destroy', ['id' => $car->id]) }}" method="POST" class="d-inline-block">
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
