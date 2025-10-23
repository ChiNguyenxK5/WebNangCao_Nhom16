# 🍕 Laravel Pizza Ordering System

Website **bán pizza trực tuyến** được xây dựng bằng **Laravel**.  
Cho phép khách hàng đặt pizza nhanh chóng, dễ sử dụng, và quản trị viên có thể quản lý sản phẩm, đơn hàng, người dùng, v.v.

---

## 🌟 GIỚI THIỆU CHÍNH

### 🛒 Dành cho khách hàng:
- Xem danh sách pizza và chi tiết sản phẩm  
- Thêm sản phẩm vào giỏ hàng  
- Đặt hàng trực tuyến  
- Đăng ký, đăng nhập tài khoản  

### 🧑‍💻 Dành cho quản trị viên:
- Đăng nhập trang quản trị  
- Quản lý danh mục pizza  
- Quản lý đơn hàng, người dùng  
- Thống kê doanh thu cơ bản  

---

## 🚀 CÁC BƯỚC CHẠY DỰ ÁN SAU KHI CLONE

### 🔹 Bước 1: Clone project
git clone https://github.com/ChiNguyenxK5/WebNangCao_Nhom14.git
cd WebNangCao_Nhom14
🔹 Bước 2: Cài đặt PHP dependencies
bash
Sao chép mã
composer install
🔹 Bước 3: Cài đặt Node.js dependencies
bash
Sao chép mã
npm install
🔹 Bước 4: Tạo file môi trường .env
bash
Sao chép mã
# Trên Windows
copy .env.example .env

# Hoặc trên Linux/Mac
cp .env.example .env
🔹 Bước 5: Tạo application key
bash
Sao chép mã
php artisan key:generate
🔹 Bước 6: Cấu hình database trong .env
Ví dụ:

env
Sao chép mã
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_booking
DB_USERNAME=root
DB_PASSWORD=
🔹 Bước 7: Tạo database & migrate
Tạo database hotel_booking trong phpMyAdmin hoặc MySQL, sau đó chạy:

bash
Sao chép mã
php artisan migrate
php artisan db:seed
🔹 Bước 8: Build assets (frontend)
bash
Sao chép mã
npm run build
# hoặc chạy ở chế độ development:
npm run dev
🔹 Bước 9: Khởi động server
bash
Sao chép mã
php artisan serve
💻 CÔNG NGHỆ SỬ DỤNG
Laravel 10+

PHP 8.2

MySQL

Node.js & NPM

Blade Template

Bootstrap / Tailwind CSS

❤️ TÁC GIẢ
👩‍💻 Nhóm 14 - Web Nâng Cao

Nếu bạn thấy dự án hữu ích, hãy ⭐ Star để ủng hộ nhé!
