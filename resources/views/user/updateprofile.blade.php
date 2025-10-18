<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân - Pizza Store</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <!-- Header giữ nguyên từ home.blade.php -->
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
                                <a href="#" class="pizza-nav-link">
                                    <span>Thông tin cá nhân</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- User Actions Section -->
                <div class="pizza-user-section">
                    <div class="pizza-user-profile">
                        <div class="pizza-user-avatar">
                            <span class="avatar-text">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                        <div class="pizza-user-info">
                            <span class="user-name">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="profile-container">
        <div class="container">
            <div class="profile-header">
                <h1>🍕 Thông tin cá nhân</h1>
                <p>Cập nhật thông tin để chúng tôi phục vụ bạn tốt hơn</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>❌ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="profile-content">
                <form method="POST" action="{{ route('profile.user.update') }}" class="profile-form">
                    @csrf
                    @method('PUT')

                    <div class="form-section">
                        <h3>📋 Thông tin cơ bản</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">👤 Họ và tên</label>
                                <input type="text" id="name" name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">📧 Email</label>
                                <input type="email" id="email" name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">📞 Số điện thoại</label>
                                <input type="tel" id="phone" name="phone" 
                                       value="{{ old('phone', $user->phone) }}" 
                                       placeholder="0123456789">
                            </div>
                            
                            <div class="form-group">
                                <label for="date_of_birth">🎂 Ngày sinh</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" 
                                       value="{{ old('date_of_birth', $user->date_of_birth) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">🏠 Địa chỉ giao hàng</label>
                            <textarea id="address" name="address" rows="3" 
                                      placeholder="Nhập địa chỉ đầy đủ để chúng tôi giao hàng chính xác...">{{ old('address', $user->address) }}</textarea>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>🔒 Đổi mật khẩu</h3>
                        <p class="section-note">Để trống nếu không muốn đổi mật khẩu</p>
                        
                        <div class="form-group">
                            <label for="current_password">🔑 Mật khẩu hiện tại</label>
                            <input type="password" id="current_password" name="current_password">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="new_password">🆕 Mật khẩu mới</label>
                                <input type="password" id="new_password" name="new_password">
                            </div>
                            
                            <div class="form-group">
                                <label for="new_password_confirmation">✅ Xác nhận mật khẩu mới</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-save">
                            💾 Lưu thông tin
                        </button>
                        <a href="{{ url('/') }}" class="btn-cancel">
                            ↩️ Quay lại trang chủ
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .profile-container {
            min-height: 100vh;
            background: gray;
            padding: 120px 0 60px 0;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }

        .profile-header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .profile-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .profile-content {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .alert-error {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .alert ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .form-section {
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 2px solid #f1f5f9;
        }

        .form-section:last-of-type {
            border-bottom: none;
        }

        .form-section h3 {
            color: #ff6b35;
            font-size: 1.4rem;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .section-note {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 20px;
            font-style: italic;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
            font-size: 1rem;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #ff6b35;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-actions {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 40px;
        }

        .btn-save {
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #e55a2b, #e8841a);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 107, 53, 0.3);
        }

        .btn-cancel {
            background: #6b7280;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-cancel:hover {
            background: #4b5563;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .profile-content {
                padding: 30px 20px;
                margin: 0 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .profile-header h1 {
                font-size: 2rem;
            }

            .form-actions {
                flex-direction: column;
                align-items: center;
            }

            .btn-save, .btn-cancel {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</body>
</html>