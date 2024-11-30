@extends('layouts.client')

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-wrap">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">Khách sạn</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Đặt khách sạn</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mt-5" style="background-color: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <h2 style="margin-bottom: 20px; font-weight: bold; color: #333;">Đặt Phòng</h2>

        <!-- Hiển thị thông báo nếu có -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('hottels.store') }}" method="POST" id="bookingForm">
            @csrf
            <input type="hidden" name="room_id" value="{{ $hottels->id }}">
            <input type="hidden" id="total_price" name="total_price" value="">

            <div class="mb-3">
                <label for="name" class="form-label">Tên Khách Hàng</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="contact_info" class="form-label">Thông Tin Liên Lạc</label>
                <input type="text" class="form-control" id="contact_info" name="contact_info" required>
            </div>

            <div class="mb-3">
                <label for="number" class="form-label">Số Lượng Phòng (Tối đa: {{ $hottels->number }})</label>
                <input type="number" class="form-control" id="number" name="number" min="1" max="{{ $hottels->number }}" required>
            </div>

            <div class="mb-3">
                <label for="check_in" class="form-label">Ngày Nhận Phòng</label>
                <input type="date" class="form-control" id="check_in" name="check_in" required>
            </div>

            <div class="mb-3">
                <label for="check_out" class="form-label">Ngày Trả Phòng</label>
                <input type="date" class="form-control" id="check_out" name="check_out" required>
            </div>

            <div class="mb-3">
                <label for="total" class="form-label">Tổng Tiền</label>
                <input type="text" class="form-control" id="total" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Đặt Phòng</button>
        </form>
    </div>

    <script>
        const pricePerDay = {{ $hottels->price }}; // Lấy giá phòng từ dữ liệu máy chủ
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');
        const numberInput = document.getElementById('number');
        const maxRooms = {{ $hottels->number }}; // Số lượng phòng tối đa

        // Thiết lập ngày hiện tại cho trường ngày nhận phòng
        const today = new Date().toISOString().split('T')[0];
        checkInInput.setAttribute('min', today);
        
        // Ngăn không cho chọn ngày trả phòng nhỏ hơn ngày nhận phòng
        checkInInput.addEventListener('change', function() {
            const checkInDate = new Date(this.value);
            const nextDay = new Date(checkInDate);
            nextDay.setDate(checkInDate.getDate() + 1);
            checkOutInput.setAttribute('min', nextDay.toISOString().split('T')[0]);
            calculateTotal(); // Tính tổng khi ngày nhận phòng thay đổi
        });

        checkInInput.addEventListener('change', calculateTotal);
        checkOutInput.addEventListener('change', calculateTotal);
        numberInput.addEventListener('change', function() {
            const numberOfRooms = parseInt(this.value, 10);

            // Kiểm tra số lượng phòng nhập vào có lớn hơn số phòng tối đa không
            if (numberOfRooms > maxRooms) {
                alert('Số lượng phòng không được vượt quá ' + maxRooms);
                this.value = maxRooms; // Đặt lại giá trị về max
            }

            calculateTotal();
        });

        function calculateTotal() {
            const checkIn = new Date(checkInInput.value);
            const checkOut = new Date(checkOutInput.value);
            const numberOfRooms = parseInt(numberInput.value, 10);
            
            if (checkIn && checkOut && numberOfRooms) {
                // Kiểm tra ngày trả phòng không được nhỏ hơn ngày nhận phòng
                if (checkOut < checkIn) {
                    document.getElementById('total').value = 'Ngày trả phòng không được nhỏ hơn ngày nhận phòng';
                    document.getElementById('total_price').value = '';
                    return;
                }

                const timeDiff = Math.abs(checkOut - checkIn);
                const days = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));

                if (days > 0) {
                    const totalPrice = days * pricePerDay * numberOfRooms;
                    document.getElementById('total').value = totalPrice + ' VND';
                    document.getElementById('total_price').value = totalPrice;
                } else {
                    document.getElementById('total').value = '0 VND';
                }
            }
        }
    </script>
@endsection
