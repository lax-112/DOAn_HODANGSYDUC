@extends('layouts.client')

@section('content')
    <!-------------------- Breadcrumb -------------------->
    <div class="breadcrumb-wrap">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="#">Khách Sạn</a></li>
                </ol>
            </nav>
        </div>
    </div>

    <!-------------------- Hotel Details -------------------->
    <div class="hotel-details container mt-5">
        <div class="hotel-intro">
            <div class="booking-info">
                <div class="hotel-name">
                    <h2>KHÁCH SẠN: {{ $hotteldetails->hotel_name }}</h2>
                </div>
            </div>
            <div class="main-image">
                <img src="{{ asset('storage/images/rooms/'.$hotteldetails->image) }}" alt="Hotel Image" class="img-fluid rounded shadow-sm">
            </div>
            <div class="intro-section mt-4">
                <h5 class="section-title">Giới thiệu về khách sạn</h5>
                <h6>Mô tả:</h6>
                <p>{{ $hotteldetails->description }}</p>
            </div>
            <h5 class="section-title mt-5">Phòng</h5>
            <div>
                <p class="price"><i class="fas fa-money-bill-wave"></i> {{ number_format($hotteldetails->price, 0, ',', '.') }} VNĐ</p>
                <h6>Tên phòng: {{ $hotteldetails->name }}</h6>
                <!-------------------- Slideshow -------------------->
        <div class="container">
            <!-- Full-width images with number text -->
            @foreach ($image_room as $key => $image)
                <div class="mySlides">
                    <div class="numbertext">{{ $key + 1 }} / {{ count($image_room) }}</div>
                    <img src="{{ asset('storage/images/galleries_room/'.$image->image) }}" style="width:100%;height: 450px;">
                </div>
            @endforeach

            <!-- Next and previous buttons -->
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>

            <!-- Image text -->
            <div class="caption-container">
                <p id="caption"></p>
            </div>

            <!-- Thumbnail images -->
            <div class="owl-carousel owl-theme" style="margin-left:0px;margin-right:0px;">
                @foreach ($image_room as $key => $image)
                    <div class="item">
                        <img class="demo cursor" src="{{ asset('storage/images/galleries_room/'.$image->image) }}" style="width:100%;height: 100px;margin-top:20px;" onclick="currentSlide({{ $key + 1 }})" alt="">
                    </div>
                @endforeach
            </div>
        </div>
        <!-------------------- End Slideshow -------------------->


                <a href="{{ route('hottels.book', ['id' => $hotteldetails->id]) }}" class="btn btn-primary" style="margin-top: 20px;width: 97%;margin-left: 15px;margin-right: 15px;">Đặt phòng</a>
            </div>
            <h5 class="section-title mt-5">Tiện ích</h5>
            <div class="amenities mt-3">
                <div class=""><i class="icon-wifi"></i> Wifi</div>
                <div class=""><i class="icon-bar"></i> Bar</div>
                <div class=""><i class="icon-restaurant"></i> Nhà hàng</div>
                <div class=""><i class="icon-laundry"></i> Giặt là</div>
                <div class=""><i class="icon-gym"></i> Gym</div>
                <div class=""><i class="icon-vending-machine"></i> Máy bán hàng tự động</div>
                <div class=""><i class="icon-kiosk"></i> Kiosk</div>
                <div class=""><i class="icon-locker"></i> Tủ đồ cá nhân</div>
                <div class=""><i class="icon-games"></i> Trò chơi</div>
            </div>
        </div>
    </div>

    <style>
        /* General Style */
        .hotel-intro {
            font-family: Arial, sans-serif;
            color: #333;
        }

        .breadcrumb-wrap {
            background-color: #f7f7f7;
            padding: 15px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .booking-info {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .hotel-name h2 {
            font-size: 24px;
            color: #6a1b9a;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .main-image img {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: cover;
        }

        .intro-section {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 20px;
            font-weight: bold;
            color: #6a1b9a;
            margin-bottom: 15px;
        }

        .price {
            font-size: 18px;
            color: #333;
            margin-top: 5px;
        }

        .amenities {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 10px;
            margin-bottom: 50px;
        }

        .amenity {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            padding: 10px 15px;
            background-color: #f3f3f3;
            border-radius: 6px;
            width: 160px;
            text-align: left;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .amenity i {
            font-size: 20px;
            color: #6a1b9a;
        }

        /* Icon Definitions */
        .icon-wifi::before { content: "📶"; }
        .icon-bar::before { content: "🍸"; }
        .icon-restaurant::before { content: "🍴"; }
        .icon-laundry::before { content: "🧺"; }
        .icon-gym::before { content: "🏋️"; }
        .icon-vending-machine::before { content: "🛒"; }
        .icon-kiosk::before { content: "💻"; }
        .icon-locker::before { content: "🔒"; }
        .icon-games::before { content: "🎮"; }

        /* CSS cho slideshow */
        * {
        box-sizing: border-box;
        }

        .hotel-intro {
            font-family: Arial, sans-serif;
            color: #333;
        }

        .highlight {
            border: 3px solid #6a1b9a;
            opacity: 1 !important;
            transition: border-color 0.3s ease;
        }

        /* CSS cho slideshow */
        * {
            box-sizing: border-box;
        }

        .container {
            position: relative;
        }

        .mySlides {
            display: none;
        }

        .cursor {
            cursor: pointer;
        }

        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 40%;
            width: auto;
            padding: 16px;
            color: white;
            font-weight: bold;
            font-size: 20px;
            border-radius: 0 3px 3px 0;
            user-select: none;
        }

        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        .caption-container {
            /* text-align: center;
            background-color: #222;
            padding: 2px 16px;
            color: white; */
        }

        .active,
        .demo:hover {
            opacity: 1;
        }

        .owl-nav {
            display: none;
        }


    </style>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function() {
            const owl = $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                dots: false,
                responsive: {
                    0: { items: 2 },
                    600: { items: 3 },
                    1000: { items: 5 }
                }
            });

            let slideIndex = 1;
            showSlides(slideIndex);

            window.plusSlides = function(n) {
                showSlides(slideIndex += n);
            };

            window.currentSlide = function(n) {
                showSlides(slideIndex = n);
            };

            function showSlides(n) {
                let slides = document.getElementsByClassName("mySlides");
                let dots = document.getElementsByClassName("demo");
                let captionText = document.getElementById("caption");

                if (n > slides.length) { slideIndex = 1 }
                if (n < 1) { slideIndex = slides.length }

                // Ẩn tất cả ảnh lớn
                Array.from(slides).forEach(slide => slide.style.display = "none");

                // Xóa lớp 'highlight' khỏi tất cả thumbnail
                Array.from(dots).forEach(dot => dot.classList.remove("highlight"));

                // Hiển thị ảnh lớn và thêm 'highlight' cho thumbnail tương ứng
                slides[slideIndex - 1].style.display = "block";
                dots[slideIndex - 1].classList.add("highlight");
                captionText.innerHTML = dots[slideIndex - 1].alt;

                // Di chuyển slider đến vị trí giữa của thumbnail
                owl.trigger('to.owl.carousel', [slideIndex - 1, 300]);
            }

            // Tự động chuyển ảnh sau mỗi 5 giây
            setInterval(function() {
                plusSlides(1);
            }, 5000);
        });
    </script>

@endsection
