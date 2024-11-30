@extends('layouts.client')

@section('content')
    <!-------------------- Breadcrumb -------------------->
    <div class="breadcrumb-wrap">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: ''" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="#">Tin tức</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-------------------- End Breadcrumb -------------------->

    <!-------------------- Content -------------------->
    <div class="container mt-4">
        <header>
            <h1>Tin Tức Du Lịch</h1>
        </header>

        <section id="home">
            <h2>Chào Mừng Đến Với Tin Tức Du Lịch</h2>
            <p>Cập nhật những tin tức mới nhất về du lịch, những điểm đến hấp dẫn và những mẹo hữu ích cho chuyến đi của bạn.</p>
        </section>

        <section id="destinations">
            <h2>Điểm Đến Hấp Dẫn</h2>
            <article>
                <h3>Hà Nội</h3>
                <img src="https://static.vinwonders.com/production/ho-hoan-kiem-2.jpg" alt="Hà Nội" class="img-fluid">
                <p>Khám phá vẻ đẹp của Hà Nội với các địa điểm nổi tiếng như Hồ Gươm, Văn Miếu và nhiều hơn nữa.</p>
                <!-- <p><i class="fas fa-arrow-right"></i> <a href="#">Xem thêm</a></p> -->
            </article>
            <article>
                <h3>Đà Nẵng</h3>
                <img src="https://tourism.danang.vn/wp-content/uploads/2023/02/bai-bien-my-khe-da-nang.jpg" alt="Đà Nẵng" class="img-fluid">
                <p>Thành phố biển Đà Nẵng nổi tiếng với Bà Nà Hills và bãi biển Mỹ Khê tuyệt đẹp.</p>
                <!-- <p><i class="fas fa-arrow-right"></i> <a href="#">Xem thêm</a></p> -->
            </article>
            <article>
                <h3>Hồ Chí Minh</h3>
                <img src="https://www.new7wonders.com/app/uploads/sites/5/2016/10/ho-chi-minh-city-1348092-1920x1280.jpg" alt="Hồ Chí Minh" class="img-fluid">
                <p>Khám phá sự nhộn nhịp của thành phố Hồ Chí Minh với các trung tâm thương mại và món ăn đường phố ngon.</p>
                <!-- <p><i class="fas fa-arrow-right"></i> <a href="#">Xem thêm</a></p> -->
            </article>
        </section>

        <section id="articles">
            <h2>Bài Viết Mới Nhất</h2>
            <article>
                <h3>5 Lý Do Nên Đi Du Lịch</h3>
                <img src="https://cdn.tgdd.vn/Files/2021/07/03/1365413/luu-ngay-10-dia-diem-du-lich-cuc-lang-man-danh-cho-cac-cap-doi-tai-viet-nam-202206021609456544.jpg" alt="Du Lịch" class="img-fluid">
                <p>Du lịch không chỉ giúp bạn thư giãn mà còn mở mang kiến thức và trải nghiệm văn hóa mới.</p>
                <!-- <p><i class="fas fa-arrow-right"></i> <a href="#">Đọc thêm</a></p> -->
            </article>
            <article>
                <h3>Mẹo Du Lịch Tiết Kiệm</h3>
                <img src="https://eurotravel.com.vn/wp-content/uploads/2023/06/tich-luy-mot-khoan-tien-co-dinh-moi-thang.jpg" alt="Mẹo Du Lịch" class="img-fluid">
                <p>Học cách tiết kiệm chi phí trong chuyến du lịch của bạn mà vẫn tận hưởng những trải nghiệm tuyệt vời.</p>
                <!-- <p><i class="fas fa-arrow-right"></i> <a href="#">Đọc thêm</a></p> -->
            </article>
        </section>
    </div>
    <!-------------------- End Content -------------------->

    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
        }

        header {
            text-align: center;
            margin-top: 20px;
        }

        section {
            margin-bottom: 30px;
        }

        article {
            background: #f4f4f4;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
        }

        article img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .breadcrumb-wrap {
            background: #f8f9fa;
            padding: 10px 0;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background: #333;
            color: white;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
@endsection
