@extends('layouts.client')

@section('content')
<!-------------------- Breadcrumb -------------------->
    <div class="breadcrumb-wrap">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: ''" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">vé máy bay</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Đặt vé máy bay</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mt-5">
        <h2 class="mb-4">Đặt vé máy bay : {{ $ticket->departure_city }} <i class="fas fa-arrow-right" style="margin-right: 5px;margin-left: 5px;"></i> {{ $ticket->arrival_city }}</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('flight-tickets.book.store', $ticket->id) }}" method="POST" class="p-4 border rounded" style="background-color: #f8f9fa;">
            @csrf
            <!-- Thông tin khách hàng -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="user_name" class="form-label">Tên khách hàng</label>
                    <input type="text" class="form-control" id="user_name" name="user_name" value="{{ old('user_name') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="num_of_passengers" class="form-label">Số lượng hành khách (còn lại: {{ $ticket->available_seats }})</label>
                    <input type="number" class="form-control" id="num_of_passengers" name="num_of_passengers" min="1" value="1" max="{{ $ticket->available_seats }}" required>
                </div>
            </div>

            <!-- Chọn ngày khởi hành và khứ hồi -->
            <div class="mb-4">
                <label class="form-label">Ngày khởi hành:</label>
                <input type="date" class="form-control" id="departure_date" name="departure_date" value="{{ date('Y-m-d', strtotime($ticket->departure_time)) }}" required>
            </div>

            <!-- Checkbox cho vé khứ hồi -->
            <div class="form-check mb-4">
                <input type="checkbox" class="form-check-input" id="return_ticket" name="return_ticket">
                <label for="return_ticket" class="form-check-label">Đặt vé khứ hồi</label>
            </div>

            <!-- Phần chọn ngày cho vé khứ hồi -->
            <div class="mb-4" id="return_date_container">
                <label class="form-label">Ngày về:</label>
                <input type="date" class="form-control" id="return_date" name="return_date" disabled>
            </div>

            <!-- Hiển thị giá vé -->
            <div class="mb-3">
                <label class="form-label">Giá vé cho một người:</label>
                <p>{{ number_format($ticket->price) }} VND</p>
            </div>

            <!-- Tổng tiền -->
            <div class="mb-4">
                <label class="form-label">Tổng tiền:</label>
                <p id="total_price" class="fw-bold" style="font-size: 1.25rem;">{{ number_format($ticket->price) }} VND</p>
            </div>

            <button type="submit" class="btn btn-success w-100">Đặt vé</button>
        </form>
    </div>

    <script>
        // Hiển thị ô chọn ngày về khi chọn vé khứ hồi
        document.getElementById('return_ticket').addEventListener('change', function () {
            const returnDateInput = document.getElementById('return_date');
            if (this.checked) {
                returnDateInput.disabled = false; // Kích hoạt ô chọn ngày về
            } else {
                returnDateInput.disabled = true; // Khóa ô chọn ngày về
                returnDateInput.value = ''; // Đặt lại giá trị ô chọn ngày về
            }
            updateTotalPrice(); // Cập nhật tổng tiền khi thay đổi vé khứ hồi
        });

        // Tính tổng tiền dựa trên số lượng hành khách và vé khứ hồi
        document.getElementById('num_of_passengers').addEventListener('input', function () {
            const availableSeats = {{ $ticket->available_seats }};  // Số ghế còn lại
            const num_of_passengers = this.value;

            // Kiểm tra nếu số hành khách lớn hơn số ghế còn lại
            if (num_of_passengers > availableSeats) {
                alert('Số lượng hành khách không được lớn hơn số ghế còn lại.');
                this.value = availableSeats; // Đặt lại giá trị thành số ghế còn lại
            }

            updateTotalPrice(); // Cập nhật lại tổng tiền
        });

        // Cập nhật min cho ngày về khi ngày khởi hành thay đổi
        document.getElementById('departure_date').addEventListener('input', function () {
            const departureDate = this.value;
            const returnDate = document.getElementById('return_date');

            // Đặt min cho ngày về là ngày khởi hành
            returnDate.setAttribute('min', departureDate);

            // Nếu ngày về hiện tại nhỏ hơn ngày khởi hành, đặt lại giá trị ngày về
            if (returnDate.value < departureDate) {
                returnDate.value = departureDate; // Đặt lại giá trị ngày về
            }
        });

        // Cập nhật tổng tiền
        function updateTotalPrice() {
            const price = {{ $ticket->price }};  // Giá vé một người
            const num_of_passengers = document.getElementById('num_of_passengers').value;  // Số lượng hành khách
            const return_ticket = document.getElementById('return_ticket').checked;  // Kiểm tra xem có vé khứ hồi hay không

            let total_price = price * num_of_passengers;

            // Nếu chọn vé khứ hồi, tổng giá nhân đôi
            if (return_ticket) {
                total_price *= 2;
            }

            // Hiển thị tổng tiền đã định dạng
            document.getElementById('total_price').textContent = new Intl.NumberFormat().format(total_price) + ' VND';
        }
    </script>
@endsection
