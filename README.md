🍕 Laravel Pizza Ordering System

Website bán pizza trực tuyến được xây dựng bằng Laravel.
Cho phép khách hàng đặt pizza nhanh chóng, dễ sử dụng, và quản trị viên có thể quản lý sản phẩm, đơn hàng, người dùng, v.v.

🌟 Giới thiệu chính
🛒 Dành cho khách hàng

Xem danh sách pizza và chi tiết sản phẩm

Thêm sản phẩm vào giỏ hàng

Đặt hàng trực tuyến

Đăng ký, đăng nhập tài khoản

🧑‍💻 Dành cho quản trị viên

Đăng nhập trang quản trị

Quản lý danh mục pizza

Quản lý đơn hàng và người dùng

Xem thống kê doanh thu cơ bản

⚙️ Cách chạy dự án sau khi clone
🔹 Bước 1: Clone project
git clone https://github.com/ChiNguyenxK5/WebNangCao_Nhom14.git
cd WebNangCao_Nhom14

🔹 Bước 2: Cài đặt PHP dependencies
composer install

🔹 Bước 3: Cài đặt Node.js dependencies
npm install

🔹 Bước 4: Tạo file môi trường .env
# Trên Windows
copy .env.example .env

# Hoặc trên Linux/Mac
cp .env.example .env

🔹 Bước 5: Tạo application key
php artisan key:generate

🔹 Bước 6: Cấu hình database trong .env

Ví dụ:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pizza_ordering
DB_USERNAME=root
DB_PASSWORD=

🔹 Bước 7: Tạo database & migrate

Tạo database pizza_ordering trong phpMyAdmin hoặc MySQL, sau đó chạy:

php artisan migrate
php artisan db:seed

🔹 Bước 8: Build assets (frontend)
# Build cho production
npm run build

# Hoặc chạy ở chế độ development
npm run dev

🔹 Bước 9: Khởi động server
php artisan serve


Sau đó truy cập:
👉 http://localhost:8000

💻 Công nghệ sử dụng
Công nghệ	Mô tả
🧱 Laravel 10+	Framework chính cho backend
🐘 PHP 8.2	Ngôn ngữ lập trình chính
🗄️ MySQL	Hệ quản trị cơ sở dữ liệu
⚡ Node.js & NPM	Quản lý gói frontend
🎨 Blade Template	Template engine của Laravel
💅 Bootstrap / Tailwind CSS	Tạo giao diện hiện đại, responsive
❤️ Tác giả

👩‍💻 Nhóm 16 - Web Nâng Cao
Nếu bạn thấy dự án hữu ích, hãy ⭐ Star để ủng hộ nhé!
