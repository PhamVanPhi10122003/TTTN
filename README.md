# XÂY DỰNG WEBSITE QUẢN LÝ CỬA HÀNG THỂ THAO

## 📝 Giới thiệu 

Đây là một website bán hàng thể thao cho phép quản lý và kinh doanh các sản phẩm như giày dép, quần áo, phụ kiện thể thao... Website được xây dựng bằng ngôn ngữ **PHP**, sử dụng hệ quản trị cơ sở dữ liệu MySQL, và phát triển trên nền tảng **Visual Studio Code / XAMPP**.

Ứng dụng hướng đến việc giúp chủ cửa hàng dễ dàng quản lý sản phẩm, đơn hàng, khách hàng, đồng thời cung cấp giao diện trực quan để khách hàng có thể xem sản phẩm, thêm vào giỏ hàng và đặt mua trực tuyến. Giao diện được thiết kế đơn giản, dễ sử dụng, tương thích tốt với cả máy tính.


## 🔧 Tính năng chính

**ADMIN**

- Quản lý danh mục : Hỗ trợ nhập, cập nhật, xoá.
- Quản lý loại sản phẩm : Hỗ trợ nhập, cập nhật, xoá và phân loại loại sản phẩm theo danh mục
- Quản lý sản phẩm : Hỗ trợ nhập, cập nhật, xoá , trạng thái sản phẩm thuê, mô tả chi tiết sản phẩm theo danh mục.
- Quản lý user : Lưu trữ thông tin user, thêm mới, cập nhật và xoá thông tin user, phân loại vai trò.
- Quản lý đơn hàng : Lưu trữ thông tin khách hàng đặt hàng, chi tiết đơn hàng, thay đổi trạng thái.
- Quản lý thuê sản phẩm : Lưu trữ thông tin khách hàng thuê sản phẩm, chi tiết đơn hàng thuê, thay đổi trạng thái.

**Khách hàng**

- Quản lý giỏ hàng : Xem tổng giá trị đơn hàng trước khi thanh toán.
- Theo dõi trạng thái đơn hàng : Xem tình trạng đơn hàng (Chờ xác nhận, Đang giao, Hoàn tất).
- Thuê sản phẩm : Tiết kiệm chi phí cho khách hàng so với mua, cơ hội trải nghiệm sản phẩm giá tiền cao.
- Tìm kiếm sản phẩm : Giúp cho khách hàng dễ dàng và nhanh chóng tìm thấy sản phẩm mình cần thông qua từ khóa

## ⚙️ Yêu cầu hệ thống

- Hệ điều hành: Windows, macOS hoặc Linux
- Công cụ phát triển: Visual Studio Code
- Server nội bộ: XAMPP (chạy Apache và MySQL)
- Ngôn ngữ lập trình: PHP, HTML, CSS, JavaScript
- Cơ sở dữ liệu: MySQL (qua phpMyAdmin)
- Trình duyệt hỗ trợ: Google Chrome


## 🚀 Cài đặt và chạy dự án

### 1. Cài đặt chương trình

- Truy cập [https://www.apachefriends.org/download.html](https://www.apachefriends.org/download.html) 
- Tải phiên bản phù hợp với hệ điều hành (Window)
- Làm theo hướng dẫn cài đặt.

### 2. Mở dự án
- Sau khi cài đặt xong cấu hình thì tải file 097_PhamVanPhi_21CNTT3.zip và giải nén vào thư thư mục C:/xampp/htdocs để chạy chương trình.
- Admin chạy chương trình ở cổng :
http://localhost:8080/TTTN/VANPHISPORT/admin/
- Khách hàng chạy chương trình ở cổng :
http://localhost:8080/TTTN/VANPHISPORT/view/trangchu.php

### 3. Cấu hình Visua Studio Code

- Mở Visua Studio Code -> chọn  **Extensions**
- Cài đặt PHP Extension Pack (gồm các công cụ hỗ trợ PHP)
- PHP Intelephense (code gợi ý, kiểm tra lỗi PHP)
- Live Server (nếu dùng cho HTML/JS tĩnh, không bắt buộc cho PHP)

### 4. Công nghệ và thư viện được sử dụng trong dự án
- Thư viện Composer (Gửi về mail để đổi password)
- Công nghệ sử dụng : Visual Studio Code
- Ngôn ngữ : PHP , JavaScript
- Mô hình : Sử dụng mô hình MVC


### 5. Cấu trúc của dự án

VANPHISPORT/
├── admin/                 # Khu vực quản trị
│   ├── class/             # Các class PHP xử lý logic 
│   ├── uploads/           # File và hình ảnh do admin upload lên
│   └── ...                # Các trang quản trị (dashboard, quản lý sản phẩm, v.v.)

├── config/                # Cấu hình hệ thống (kết nối CSDL, biến môi trường,...)

├── css/                   # File định dạng giao diện (CSS tĩnh)

├── image/                 # Ảnh giao diện người dùng (logo, banner,...)

├── js/                    # JavaScript xử lý tương tác người dùng (giỏ hàng, hiệu ứng,...)

├── view/                  # Giao diện người dùng (trang chủ, sản phẩm, thanh toán,...)

├── vendor/                # Thư viện bên thứ ba cài qua Composer (PHPMailer,...)

├── composer.json          # Khai báo thư viện PHP sử dụng trong dự án
├── composer.lock          # Ghi lại phiên bản thực tế của các thư viện PHP
├── README.md              # Tài liệu giới thiệu dự án

## 📬 Liên hệ
**Tác giả:** [Phạm Văn Phi]  
**Email:** [phipham101220033@gmail.com]  
**SĐT:** [0356771012]


