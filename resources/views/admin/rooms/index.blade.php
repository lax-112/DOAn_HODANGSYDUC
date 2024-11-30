@extends('layouts.admin')

@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Khách Sạn</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('tours.index') }}">Tour</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Khách Sạn</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid row">
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('rooms.store', $tourId) }}" id="formAddRoom" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            Tên Khách Sạn
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control" name="hotel_name" id="hotel_name" placeholder="Tên Khách Sạn">
                            <p class="text-danger" id="errorhotel_name"></p>
                        </div>
                        <div class="form-group">
                            Hình ảnh
                            <span class="text-danger">*</span>
                            <div class="input-group mb-3">
                                <input type="file" id="image" name="image">
                            </div>
                            <div>
                                <img id="showImg" style="max-height: 150px; margin: 10px 2px">
                            </div>
                            @error('image')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            Tên phòng
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Tên phòng">
                            <p class="text-danger" id="errorName"></p>
                        </div>

                        <div class="form-group">
                            Giá phòng
                            <span class="text-danger">*</span>
                            <input type="number" min="0" class="form-control" name="price" id="price" placeholder="Giá phòng">
                            <p class="text-danger" id="errorPrice"></p>
                        </div>

                        <div class="form-group row">
                            <label for="number" class="col-12">Số lượng<span class="text-danger">*</span></label>
                            <div class="col-12">
                                <input type="number" min="0" class="form-control" name="number" id="number" placeholder="Số lượng">
                                <p class="text-danger" id="errorNumber"></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-12">Mô tả<span class="text-danger">*</span></label>
                            <div class="col-12">
                                <input type="description" min="0" class="form-control" name="description" id="description" placeholder="Mô tả chi tiết">
                                {{-- <p class="text-danger" id="errorNumber"></p> --}}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group m-r-5">
                                <input type="hidden" name="status" id="status">
                                @include('components.button_switch', [
                                    'status' => old('status', 1),
                                    'id' => 'btnStatus',
                                ])
                                <label for="status" class="m-l-5 m-t-5">Trạng thái</label>
                            </div>
                            @error('status')
                                <p class="text-danger" id="errorStatus"></p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-info mb-3">
                                Thêm Khách sạn
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Danh sách khách sạn</h4>
                    <table class="table table-striped table-bordered" id="destinationTable">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Khách sạn</th>
                                <th>Ảnh</th>
                                <th>Tên phòng</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Mô tả</th>
                                <th>Trạng thái</th>
                                <th>Hình ảnh phòng</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="formEditRoom">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Sửa thông tin khách sạn</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="hotel_nameEdit">Tên khách sạn<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="hotel_name" id="hotel_nameEdit" placeholder="Tên khách sạn">
                                <p class="text-danger" id="errorhotel_nameEdit"></p>
                            </div>
                            <div class="form-group">
                                <label for="imageEdit">Hình ảnh</label>
                                <div class="input-group mb-3">
                                    <input type="file" id="imageEdit" name="imageEdit">
                                </div>
                                <div>
                                    <img id="showImgEdit" style="max-height: 150px; margin: 10px 2px">
                                </div>
                                @error('image')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nameEdit">Tên phòng<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="nameEdit" placeholder="Tên phòng">
                                <p class="text-danger" id="errorNameEdit"></p>
                            </div>
                            <div class="form-group">
                                <label for="priceEdit">Giá phòng<span class="text-danger">*</span></label>
                                <input type="number" min="0" class="form-control" name="price" id="priceEdit" placeholder="Giá phòng">
                                <p class="text-danger" id="errorPriceEdit"></p>
                            </div>
                            <div class="form-group">
                                <label for="numberEdit">Số lượng<span class="text-danger">*</span></label>
                                <input type="number" min="0" class="form-control" name="number" id="numberEdit" placeholder="Số lượng">
                                <p class="text-danger" id="errorNumberEdit"></p>
                            </div>
                            <div class="form-group">
                                <label for="descriptionEdit">Mô tả<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="description" id="descriptionEdit" placeholder="Mô tả chi tiết">
                                <p class="text-danger" id="errorDescriptionEdit"></p>
                            </div>
                            <div class="form-group">
                                <label for="statusEdit">Trạng thái<span class="text-danger">*</span></label>
                                <div class="input-group m-r-5">
                                    <input type="hidden" name="status" id="statusEdit">
                                    @include('components.button_switch', [
                                        'status' => old('status', 1),
                                        'id' => 'btnStatusEdit',
                                    ])
                                </div>
                                @error('status')
                                    <p class="text-danger" id="errorStatusEdit"></p>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-info" id="btnSubmitEdit">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        table.dataTable td:nth-child(7) {
            display: none;
        }
        table.dataTable th:nth-child(7) {
            display: none;
        }
    </style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        let linkEditRoom = '';

        // Hiển thị hình ảnh khi người dùng chọn tệp
        $('#image').change(function(e) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#showImg').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });

        // Hiển thị hình ảnh hiện tại trong modal chỉnh sửa
        $(document).on('click', '.edit', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let row = $('#Room-' + id);
            console.log(row); 

            // Lấy thông tin từ dòng
            let hotelName = row.children().eq(1).text();
            let imageSrc = row.children().eq(2).find('img').attr('src');
            let nameRoom = row.children().eq(3).text();
            let priceRoom = row.children().eq(4).text().replace(/\D+/g, '');
            let numberRoom = row.children().eq(5).text();
            let descriptionRoom = row.children().eq(6).text();
            console.log('Description:', descriptionRoom); 
            let status = row.children().eq(7).find('input').val();

            // Điền thông tin vào các trường của modal
            $('#hotel_nameEdit').val(hotelName);
            $('#nameEdit').val(nameRoom);
            $('#priceEdit').val(priceRoom);
            $('#numberEdit').val(numberRoom);
            $('#descriptionEdit').val(descriptionRoom);
            $('#statusEdit').val(status);
            $('#btnStatusEdit').prop('checked', status == 1);
            $('#showImgEdit').attr('src', imageSrc);

            // Lưu liên kết chỉnh sửa để sử dụng khi gửi dữ liệu
            linkEditRoom = $(this).attr('href');
            $('#editModal').modal('show');
        });

        // Xử lý sự kiện submit cho form chỉnh sửa
        $('#formEditRoom').submit(function(e) {
            e.preventDefault();

            let status = $('#btnStatusEdit').is(":checked") ? 1 : 0;
            $('#statusEdit').val(status);

            let formData = new FormData(this);
            formData.append('_method', 'PUT'); // Thêm phương thức PUT

            $.ajax({
                url: linkEditRoom,
                method: "POST", // Phương thức POST khi dùng FormData
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    toastrMessage(response['alert-type'], response['message']);
                    if (response['alert-type'] === 'success') {
                        datatable.ajax.reload(null, false);
                        $('#editModal').modal('hide');
                    }
                },
                error: function(jqXHR) {
                    toastrMessage('error', 'Cập nhật thông tin Khách sạn không thành công');
                    let response = jqXHR.responseJSON;
                    if (response?.errors?.hotel_name) {
                        $('#errorhotel_nameEdit').text(response.errors.hotel_name[0]);
                    }
                    if (response?.errors?.name) {
                        $('#errorNameEdit').text(response.errors.name[0]);
                    }
                    if (response?.errors?.price) {
                        $('#errorPriceEdit').text(response.errors.price[0]);
                    }
                    if (response?.errors?.number) {
                        $('#errorNumberEdit').text(response.errors.number[0]);
                    }
                    if (response?.errors?.description) { // Kiểm tra lỗi cho mô tả
                        $('#errorDescriptionEdit').text(response.errors.description[0]);
                    }
                    if (response?.errors?.status) {
                        $('#errorStatusEdit').text(response.errors.status[0]);
                    }
                }
            });
        });

        // Khởi tạo DataTable
        let datatable = $('#destinationTable').DataTable({
            processing: true,
            responsive: true,
            serverSide: true,
            searching: false,
            stateSave: true,
            ordering: false,
            ajax: {
                url: "{!! route('rooms.data', $tourId) !!}",
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'hotel_name', name: 'hotel_name' },
                { data: 'image', name: 'image' },
                { data: 'name', name: 'name' },
                { data: 'price', name: 'price' },
                { data: 'number', name: 'number' },
                { data: 'description', name: 'description' },
                {data: 'status', name: 'status'},
                {data: 'detail', name: 'detail', width: '185px'},
                { data: 'action', name: 'action', className: 'align-middle text-center', width: 65 },
            ],
        });

        // Xử lý sự kiện xóa Khách sạn
        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            let link = $(this).attr("href");
            Swal.fire({
                title: 'Bạn có chắc chắn không?',
                text: "Bạn sẽ không thể khôi phục lại!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có, xóa nó!',
                cancelButtonText: 'Không, hủy!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: link,
                        type: 'DELETE',
                        success: function(response) {
                            toastr.success('Xóa Khách sạn thành công');
                            datatable.ajax.reload(null, false);
                        },
                        error: function() {
                            toastr.error('Xóa Khách sạn không thành công');
                        }
                    });
                }
            });
        });

        // Xử lý trạng thái của phòng trong modal chỉnh sửa
        $('#btnStatusEdit').change(function() {
            $('#statusEdit').val($(this).is(":checked") ? 1 : 0);
        });

        // Xử lý hình ảnh trong modal chỉnh sửa
        $('#imageEdit').change(function(e) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#showImgEdit').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });

        // Xử lý form thêm mới phòng
        $('#formAddRoom').submit(function(e) {
            e.preventDefault();

            let status = $('#btnStatus').is(":checked") ? 1 : 0;
            $('#status').val(status);

            let formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                method: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    toastrMessage(response['alert-type'], response['message']);
                    if (response['alert-type'] === 'success') {
                        datatable.ajax.reload(null, false);
                        $('#formAddRoom')[0].reset();
                        $('#showImg').attr('src', '');
                    }
                },
                error: function(jqXHR) {
                    toastrMessage('error', 'Thêm mới Khách sạn không thành công');
                    let response = jqXHR.responseJSON;
                    if (response?.errors?.hotel_name) {
                        $('#errorhotel_name').text(response.errors.hotel_name[0]);
                    }
                    if (response?.errors?.name) {
                        $('#errorName').text(response.errors.name[0]);
                    }
                    if (response?.errors?.price) {
                        $('#errorPrice').text(response.errors.price[0]);
                    }
                    if (response?.errors?.number) {
                        $('#errorNumber').text(response.errors.number[0]);
                    }
                    if (response?.errors?.status) {
                        $('#errorStatus').text(response.errors.status[0]);
                    }
                }
            });
        });

        // Xử lý trạng thái của phòng trong form thêm mới
        $('#btnStatus').change(function() {
            $('#status').val($(this).is(":checked") ? 1 : 0);
        });
    });
</script>
@endsection

