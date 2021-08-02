# Laravel Setting Package

#### Cập nhật

- `V1.0`:
    + Sử dụng driver filesystem để lưu trữ cài đặt
    + Sử dụng cho mảng đa chiều (ghi đè các tệp config)

#### Cài đặt
`composer require ducnt/setting`

#### File configuration

- Bạn có thể tùy chỉnh lại các cài đặt bằng cách chạy đoạn mã sau tại thư mục root dự án của mình:

```php
php artisan vendor:publish --tag=setting
```

** Hệ thống sẽ sinh ra file `setting.php` tại thư mục `config`. Sau đây là các thông số:

- `default`: Chỉ ra đâu là driver mặc định để sử dụng.
- 'drivers': Chứa các driver sử dụng và cấu hình của chúng:
    + `file`:
        + `path`: Đường dẫn lưu lại các dữ liệu
- `auto_save`: có bật tự động lưu không. Khi để là `true` thì bạn sẽ không cần phải gọi method `save()` nữa hệ thống sẽ
  tự lưu giúp bạn khi có thay đổi
- `cache`:
    + `enabled`: có sử dụng cache hay không. Nếu driver sử dụng là `file` thì không cần thiết phải bật tính năng này
    + `'key`: `key cache` để phân biệt với các package khác

#### Các thao tác hỗ trợ

Sử dụng `Facade`:

```php
use Ducnt\Plugins\Setting\Facades\Setting;
```

- Lấy tất cả dữ liệu:

```php
Setting::all();
```

- Lấy duữ liệu theo `$key`:

```php
Setting::get('locale');
hoặc 
Setting::get('app.locale');
```

- Xóa `$key` khỏi dữ liệu:

```php
Setting::forget('locale');
hoặc 
Setting::forget('app.locale');
```

- Xóa tất cả:

```php
Setting::flush();
```

- Lưu dữ liệu:

```php
Setting::save();
```

#### Gỡ cài đặt

`composer remove ducnt/setting`