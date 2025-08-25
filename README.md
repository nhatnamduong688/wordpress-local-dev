# 🎨 WordPress Gallery Website - Local Development Setup

> **A complete WordPress 6.8.2 setup for art gallery websites with custom navigation and content structure**

Một WordPress site được cài đặt và cấu hình hoàn chỉnh cho phòng triển lãm nghệ thuật, bao gồm navigation menu tùy chỉnh và cấu trúc nội dung chuyên nghiệp.

[![WordPress](https://img.shields.io/badge/WordPress-6.8.2-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-8.4.11-purple.svg)](https://php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-9.4.0-orange.svg)](https://mysql.com/)
[![License](https://img.shields.io/badge/License-GPL%20v2-green.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

## 🌟 **Features**

- ✨ **Custom Navigation Menu** - Artwords & Artists sections
- 🎨 **Gallery-focused Content Structure** - Perfect for art exhibitions
- 🔗 **Clean URLs** - `/artwords/` and `/artists/` 
- 📱 **Responsive Design** - Mobile-friendly navigation
- ⚡ **Fast Setup** - Ready in 5 minutes
- 🛠️ **WP-CLI Integration** - Command-line management

## 🚀 **Quick Start**

```bash
# Clone the repository
git clone https://github.com/nhatnamduong688/wordpress-local-dev.git
cd wordpress-local-dev

# Install dependencies (macOS)
brew install php mysql wp-cli

# Start services
brew services start mysql

# Create database
mysql -u root -e "CREATE DATABASE wordpress_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -e "CREATE USER 'wp_user'@'localhost' IDENTIFIED BY 'wp_password123';"
mysql -u root -e "GRANT ALL PRIVILEGES ON wordpress_db.* TO 'wp_user'@'localhost';"

# Start WordPress
php -S localhost:8080
```

**🌐 Access your gallery website:** http://localhost:8080

## 📸 **What's Included**

### 🎨 **Artworks Section** (`/artwords/`)
- 8 professionally written blog posts about art
- Topics: Color Theory, Digital Art, Minimalism, Street Art, Sculpture, Photography
- Rich content with artist quotes and exhibition details

### 👥 **Artists Section** (`/artists/`)
- 2 detailed artist profiles
- Maria Rodriguez (Abstract Expressionism)
- James Chen (Digital Art Pioneer)
- Complete biographies and exhibition histories

### 🧭 **Navigation Menu**
- Clean, responsive header navigation
- Professional styling with hover effects
- Mobile-friendly design

## 📋 Thông tin Project

- **WordPress Version**: 6.8.2
- **PHP Version**: 8.4.11
- **MySQL Version**: 9.4.0
- **Theme**: Twenty Twenty-Five (mặc định)

## 🚀 Cài đặt và Chạy

### Yêu cầu hệ thống

- PHP 7.2+ (khuyến nghị 8.4+)
- MySQL 5.5+ hoặc MariaDB
- Homebrew (cho macOS)

### Cài đặt

1. **Clone repository**
   ```bash
   git clone <repository-url>
   cd wordpress
   ```

2. **Cài đặt dependencies**
   ```bash
   # Cài đặt PHP và MySQL (nếu chưa có)
   brew install php mysql

   # Khởi động MySQL
   brew services start mysql
   ```

3. **Tạo database**
   ```bash
   mysql -u root -e "CREATE DATABASE wordpress_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   mysql -u root -e "CREATE USER 'wp_user'@'localhost' IDENTIFIED BY 'wp_password123';"
   mysql -u root -e "GRANT ALL PRIVILEGES ON wordpress_db.* TO 'wp_user'@'localhost';"
   mysql -u root -e "FLUSH PRIVILEGES;"
   ```

4. **Cấu hình WordPress**
   ```bash
   # Copy và chỉnh sửa file config
   cp wp-config-sample.php wp-config.php
   # Cập nhật thông tin database trong wp-config.php
   ```

5. **Khởi động server**
   ```bash
   php -S localhost:8080
   ```

## 🌐 Truy cập Website

- **Website**: http://localhost:8080
- **Admin Panel**: http://localhost:8080/wp-admin/
- **Username**: admin
- **Password**: admin123

## 📁 Cấu trúc Project

```
wordpress/
├── wp-admin/           # WordPress admin interface
├── wp-content/         # Themes, plugins, uploads
│   ├── themes/         # WordPress themes
│   └── plugins/        # WordPress plugins
├── wp-includes/        # WordPress core files
├── wp-config.php       # WordPress configuration
├── .gitignore          # Git ignore rules
└── README.md           # Tài liệu này
```

## 🔧 Thông tin Database

- **Database Name**: wordpress_db
- **Username**: wp_user
- **Password**: wp_password123
- **Host**: localhost
- **Port**: 3306 (mặc định)

## 🛠️ Các lệnh hữu ích

### WordPress CLI (WP-CLI)
```bash
# Cài đặt WP-CLI
brew install wp-cli

# Kiểm tra version WordPress
wp core version

# Liệt kê users
wp user list

# Cài đặt plugin
wp plugin install <plugin-name> --activate

# Cài đặt theme
wp theme install <theme-name> --activate
```

### Database Management
```bash
# Backup database
mysqldump -u wp_user -p wordpress_db > backup.sql

# Restore database
mysql -u wp_user -p wordpress_db < backup.sql
```

### Server Management
```bash
# Khởi động MySQL
brew services start mysql

# Dừng MySQL
brew services stop mysql

# Khởi động PHP server
php -S localhost:8080

# Khởi động với port khác
php -S localhost:8000
```

## 🔒 Bảo mật

⚠️ **Lưu ý**: Đây là setup cho development local. Không sử dụng password và cấu hình này trong môi trường production.

### Thay đổi mật khẩu admin
```bash
wp user update admin --user_pass=new_secure_password
```

### Tạo user mới
```bash
wp user create newuser user@example.com --role=administrator --user_pass=secure_password
```

## 🎨 Customization

### Themes
- Default themes được ignore trong `.gitignore`
- Thêm custom themes vào `wp-content/themes/`
- Activate theme: `wp theme activate <theme-name>`

### Plugins
- Akismet và Hello Dolly được cài sẵn
- Cài plugin mới: `wp plugin install <plugin-name> --activate`

## 📝 Development Notes

- File `wp-config.php` chứa thông tin nhạy cảm và được ignore
- Uploads folder có thể được ignore tùy theo nhu cầu project
- Sử dụng WP-CLI để quản lý WordPress hiệu quả hơn

## 🤝 Contributing

1. Fork the project
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the GPL v2 or later - see WordPress license for details.

## 📞 Support

Nếu gặp vấn đề, hãy tạo issue trong repository này hoặc tham khảo:
- [WordPress Documentation](https://wordpress.org/support/)
- [WP-CLI Documentation](https://wp-cli.org/)
- [PHP Documentation](https://www.php.net/docs.php)
