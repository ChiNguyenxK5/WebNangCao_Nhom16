<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Store</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-inline.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded@48,400,0,0" />
    <script src="https://kit.fontawesome.com/03bca92048.js" crossorigin="anonymous"></script>
</head>


<body class="@auth logged-in @endauth">
<header class="pizza-header">
    <div class="container">
        <div class="pizza-navbar">
            <!-- Logo Section -->
            <div class="pizza-logo-section">
                <div class="pizza-logo">
                    <span class="pizza-icon">🍕</span>
                    <img src="{{ asset('uploads/logopizza (1).png') }}" alt="Pizza Store" class="logo-img">
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="pizza-nav-menu">
    <nav>
        <ul class="pizza-nav-links">
            <li class="pizza-nav-item">
                <a href="/" class="pizza-nav-link">
                    <span>Trang chủ</span>
                </a>
            </li>
            <li class="pizza-nav-item">
                <a href="#footer-section" class="pizza-nav-link smooth-scroll">
                    <span>Giới thiệu</span>
                </a>
            </li>
            <li class="pizza-nav-item">
                <a href="#" class="pizza-nav-link">
                    <span>Sản phẩm</span>
                </a>
            </li>
            <li class="pizza-nav-item">
                <a href="#footer-section" class="pizza-nav-link smooth-scroll">
                    <span>Liên hệ</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

            <!-- User Actions Section -->
            <div class="pizza-user-section">
                @auth
                    <div class="pizza-user-profile">
                        <div class="pizza-user-avatar">
                            <span class="avatar-text">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            <div class="avatar-status"></div>
                        </div>
                        <div class="pizza-user-info">
                            <span class="user-greeting">Xin chào!</span>
                            <span class="user-name">{{ auth()->user()->name }}</span>
                        </div>
                        <div class="pizza-user-dropdown">
                            <a href="{{ route('profile.user.show') }}" class="pizza-dropdown-item">
                                <span>Thông tin cá nhân</span>
                            </a>
                            <a href="#" class="pizza-dropdown-item">
                                <span>Chi tiết đơn hàng</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="pizza-dropdown-item pizza-logout">
                                    <span>Đăng xuất</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

                @guest
                    <div class="pizza-auth-buttons">
                        <a href="{{ route('login') }}" class="pizza-login-btn">
                            ĐĂNG NHẬP
                        </a>
                        <a href="{{ route('register') }}" class="pizza-register-btn">
                            ĐĂNG KÝ
                        </a>
                    </div>
                @endguest

                <!-- Cart Section - Only show when logged in -->
                @auth
                    <div class="pizza-cart">
                        <div class="pizza-cart-icon" id="popup_card">
                            <div class="red-cart-icon">🛒</div>
                            <span class="cart-count"></span>
                        </div>
                    </div>
                @endauth
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
                <div class="next"><span>Tiếp</span></div>
                <div class="prev"><span>Trước</span></div>
            </div>
        </div>
    </section>

    {{-- Giữ nguyên danh sách sản phẩm --}}
    @include('user.partials.pizzas')
</div>

<<footer id="footer-section">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <h3 class="name_website">PIZZA COMPANY</h3>
                <p>📞Hotline: 1900 1234 - Giao hàng nhanh tận nơi</p>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lắng nghe tất cả links có class smooth-scroll
    const smoothScrollLinks = document.querySelectorAll('.smooth-scroll');
    
    smoothScrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault(); // Ngăn chặn hành vi mặc định
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                // Smooth scroll xuống target element
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script></body>
</html>
