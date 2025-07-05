# 1) Gambar dasar PHP 7.4 + Apache
FROM php:7.4-apache

# 2) Aktifkan ekstensi MySQL yg dibutuhkan CodeIgniter
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 3) Salin semua file project ke /var/www/html (folder public Apache)
COPY . /var/www/html

# 4) (Opsional) ubah owner agar Apache bisa tulis cache/log
RUN chown -R www-data:www-data /var/www/html

# 5) Jalankan Apache
EXPOSE 80
CMD ["apache2-foreground"]
