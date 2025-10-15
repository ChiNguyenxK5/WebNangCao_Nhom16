<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Store</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-inline.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded@48,400,0,0" />
    <script src="https://kit.fontawesome.com/03bca92048.js" crossorigin="anonymous"></script>
</head>


<body class="@auth logged-in @endauth">
<header>
    <div class="container">
        <div class="content__header">
            <div class="logo__header">
                <img src="{{ asset('uploads/logopizza (1).png') }}" alt="">
            </div>
            <div class="menu__header">
                <nav>
                    <ul class="nav__link">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="#">Giới thiệu</a></li>
                        <li><a href="#">Sản phẩm</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </nav>
            </div>

            {{-- Hiển thị user profile nếu đã đăng nhập --}}
            @auth
<div class="user-profile logged-in">
    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
    <div class="user-info">
        <span class="user-greeting">Xin chào,</span>
        <span class="user-email">{{ auth()->user()->email }}</span>
    </div>
    <div class="user-dropdown">
        <a href="#" class="dropdown-item" id="favorite-menu">
            <i class="fas fa-heart"></i>
            <span>Pizzas yêu thích</span>
        </a>
        <div class="favorite-list">
            <div class="no-favorites">Chưa có pizza yêu thích</div>
        </div>
        <div class="dropdown-divider"></div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item" id="logout-link">
                <i class="fas fa-sign-out-alt"></i>
                <span>Đăng xuất</span>
            </button>
        </form>
    </div>
</div>
@endauth


            {{-- Nếu chưa đăng nhập --}}
            @guest
                <a href="{{ route('login') }}" class="login-btn">ĐĂNG NHẬP</a>
                <a href="{{ route('register') }}" class="login-btn">ĐĂNG KÝ</a>
            @endguest


            <div class="card__head">
                <div class="card" id="popup_card">
                    <img src="{{ asset('uploads/Group 16.png') }}" alt="">
                    <span>2</span>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- Phần thân giữ nguyên --}}
<div class="main-content">
    {{-- Slide --}}
    <section class="slide__body">
        <div class="container">
            <div class="container_slide">
                <div class="slides">
                    <div class="item"><img src="{{ asset('uploads/uudai2.png') }}" alt=""></div>
                    <div class="item"><img src="{{ asset('uploads/uudai1 (1).png') }}" alt=""></div>
                    <div class="item"><img src="{{ asset('uploads/uudai3.png') }}" alt=""></div>
                </div>
                <div class="next"><i class="fas fa-arrow-right"></i></div>
                <div class="prev"><i class="fas fa-arrow-left"></i></div>
            </div>
        </div>
    </section>

    {{-- Giữ nguyên danh sách sản phẩm --}}
    @include('user.partials.pizzas')
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-4">
                <h3 class="name_website">PIZZA COMPANY</h3>
                <p>Hotline: 1900 1234 - Giao hàng nhanh tận nơi</p>
            </div>
            <div class="col-4">
                <h3 class="title">GIỚI THIỆU</h3>
                <ul>
                    <li><a href="#">Tin tức & Sự kiện</a></li>
                    <li><a href="#">Tuyển dụng</a></li>
                </ul>
            </div>
            <div class="col-4">
                <h3 class="title">LIÊN HỆ</h3>
                <ul>
                    <li><a href="#">Chính sách bảo mật</a></li>
                    <li><a href="#">Điều khoản và điều kiện</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<script src="{{ asset('js/slide.js') }}"></script>
<script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
