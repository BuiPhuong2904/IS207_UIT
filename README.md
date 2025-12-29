# TRƯỜNG ĐẠI HỌC CÔNG NGHỆ THÔNG TIN
# IS207 - PHÁT TRIỂN ỨNG DỤNG WEB

## BẢNG MỤC LỤC
* [Giới thiệu môn học](#gioithieumonhoc)
* [Giảng viên hướng dẫn](#giangvien)
* [Thành viên nhóm](#thanhvien)
* [Seminar](#seminar)
* [Đồ án môn học](#doan)
* [Công nghệ sử dụng](#congnghe)
* [Chức năng hệ thống](#chucnang)
* [Cài đặt và Triển khai](#caidat)


## GIỚI THIỆU MÔN HỌC
<a name="gioithieumonhoc"></a>
* **Tên môn học**: Phát triển ứng dụng Web - Web Development
* **Mã môn học**: IS207
* **Lớp học**: IS207.Q13
* **Năm học**: 2025-2026

## GIẢNG VIÊN HƯỚNG DẪN
<a name="giangvien"></a>
* ThS. **Tạ Việt Phương** - *phuongtv@uit.edu.vn*

## THÀNH VIÊN NHÓM
<a name="thanhvien"></a>
| STT | MSSV | Họ và Tên | Github | Email | 
| --- | --- | --- | --- | --- | 
| 1 | 23521239 | Bùi Phạm Bích Phương | [BuiPhuong2904](https://github.com/BuiPhuong2904) | 23521239@gm.uit.edu.vn | 
| 2 | 23520910 | Nguyễn Thị Thanh Mai | [Mywayyy](https://github.com/Mywayyy) | 23520910@gm.uit.edu.vn | 
| 3 | 23520039 | Đào Thị Quỳnh Anh | [Umashu-QA](https://github.com/Umashu-QA) | 23520039@gm.uit.edu.vn |
| 4 | 23520225 | Đỗ Hải Đăng | [dohaidang-git](https://github.com/dohaidang-git) | 23520225@gm.uit.edu.vn | 
| 5 | 23520889 | Trần Hoàng Long | [THoangLong](https://github.com/THoangLong) | 23520889@gm.uit.edu.vn | 
| 6 | 23521105 | Đỗ Tuyết Nhi | [tweitnhyy](https://github.com/tweitnhyy) | 23521105@gm.uit.edu.vn | 

## SEMINAR
<a name="seminar"></a>
Seminar nhóm: Việc ứng dụng AI vào trang web Thương mại điện tử. Việc này có ưu khuyết điểm gì, có khó khăn gì. Trình bày 1 số giải pháp và cách thực hiện. Ví dụ: Tích hợp AI Chatbot/Agent vào Website, Ứng dụng Recommendation Systems.

## ĐỒ ÁN MÔN HỌC
<a name="doan"></a>
**Tên đề tài:** Website thương mại điện tử B2C phòng GYM - **GRYND (Team Yobae)**.

**Mô tả:**
Xây dựng hệ thống website B2C toàn diện cho phòng tập Gym, tích hợp các tính năng thương mại điện tử và quản lý hội viên. Hệ thống giải quyết bài toán quản lý rời rạc của các phòng gym truyền thống thông qua nền tảng số hóa, bao gồm quản lý gói tập, lớp học, huấn luyện viên và cửa hàng dụng cụ thể thao.

**Điểm nhấn:**
Dự án tích hợp **AI Chatbot** (sử dụng Google Gemini API) để hỗ trợ trả lời câu hỏi thường gặp và **Hệ thống gợi ý sản phẩm** (Recommendation System) để nâng cao trải nghiệm người dùng.

## CÔNG NGHỆ SỬ DỤNG
<a name="congnghe"></a>
* **Backend:** PHP (v8.1 trở lên), Laravel Framework (v10.x/11.x).
* **Frontend:** HTML5, Tailwind CSS, JavaScript (ES6), Blade Template.
* **Database:** MySQL.
* **AI Integration:** Google Gemini API.
* **Thư viện:** dompdf, cloudinary-laravel, socialite, sanctum.
* **Công cụ:** Visual Studio Code, Figma, XAMPP/Laragon, Git/GitHub.

## CHỨC NĂNG HỆ THỐNG
<a name="chucnang"></a>

### 1. Phân hệ Khách hàng (User)
* **Tài khoản:** Đăng ký, Đăng nhập (Google/Facebook), Quản lý hồ sơ cá nhân, Lịch sử mượn trả.
* **Dịch vụ phòng tập:** Xem danh sách và đăng ký Gói tập (Tháng/Quý/Năm), Đặt lịch Lớp học (Yoga, Gym, Boxing...), Thuê Huấn luyện viên (PT).
* **Cửa hàng (E-commerce):** Xem sản phẩm, Thêm vào giỏ hàng, Thanh toán trực tuyến (VNPay/MoMo) hoặc COD, Theo dõi trạng thái đơn hàng.
* **Hỗ trợ:** Chatbot AI tư vấn lộ trình và giải đáp thắc mắc.

### 2. Phân hệ Quản trị (Admin)
* **Dashboard:** Thống kê tổng quan doanh thu, số lượng hội viên mới, lớp học đang mở theo thời gian thực.
* **Quản lý kinh doanh:** Quản lý Đơn hàng, Sản phẩm, Kho hàng, Mã giảm giá (Khuyến mãi).
* **Quản lý phòng tập:** Quản lý Lịch lớp học, Gói tập, Danh sách Huấn luyện viên (PT), Chi nhánh.
* **Quản lý vận hành:** Quản lý Người dùng (Hội viên/Nhân viên), Quản lý Mượn/Trả dụng cụ tập luyện.
* **CMS:** Quản lý bài viết Blog, Banner quảng cáo.

## CÀI ĐẶT VÀ TRIỂN KHAI
<a name="caidat"></a>

### Yêu cầu tiên quyết
Để chạy được dự án, đảm bảo máy tính đã cài đặt:
* PHP >= 8.1
* Composer
* Node.js & NPM
* MySQL (thông qua XAMPP hoặc Laragon)

### Các bước cài đặt chi tiết

**Bước 1: Clone mã nguồn dự án**
Mở terminal và chạy lệnh sau để tải source code về máy:
```bash
git clone [https://github.com/BuiPhuong2904/IS207_UIT.git](https://github.com/BuiPhuong2904/IS207_UIT)
```

**Bước 2: Cài đặt các thư viện phụ thuộc Cài đặt thư viện cho Backend (PHP) và Frontend (JS/CSS):**
```bash
composer install
npm install
```

**Bước 3: Cấu hình môi trường (.env) Sao chép file cấu hình mẫu và chỉnh sửa thông tin kết nối Database, Mail Server và API Key:**

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=webgym
DB_USERNAME=root          
DB_PASSWORD=             

GEMINI_API_KEY=AIzaSyDjhVEk9WV9L_PT0KjKgqdLSpbk7TCePiY
GEMINI_MODEL=gemini-2.5-flash

VITE_APP_NAME="${APP_NAME}"
VNPAY_TMN_CODE=C2SW1SCG
VNPAY_HASH_SECRET=0D7OXKV12T4P1BMF3IOW2Q44QOLVVBW3
VNPAY_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html

MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=grynd.yobae@gmail.com
MAIL_PASSWORD=ypjxdzxmizlaelqe
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=grynd.yobae@gmail.com
MAIL_FROM_NAME="GRYND"

```
**Bước 4: Khởi tạo Database và Dữ liệu mẫu Tạo Database trong MySQL**
```bash
php artisan key:generate
php artisan migrate --seed
```
**Bước 5: Build Frontend**
```bash
npm run build
```
**Bước 6: Khởi chạy Server**
```bash
php artisan serve
```
