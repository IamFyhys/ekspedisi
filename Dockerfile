FROM php:8.2-apache

# Menginstal dependensi sistem
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    nodejs \
    npm

# Menghapus cache apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Menginstal ekstensi PHP yang dibutuhkan Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Menginstal Composer (Manajer dependensi PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Menetapkan folder kerja (Working Directory)
WORKDIR /var/www/html

# Menyalin seluruh kode proyek ke dalam container
COPY . .

# Menginstal library PHP (Composer) & Node (NPM)
# Abaikan error jika composer install dijalankan di lingkungan produksi
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN npm install
RUN npm run build

# Memberikan hak akses yang benar untuk folder storage & bootstrap/cache Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Mengaktifkan modul mod_rewrite Apache untuk routing Laravel
RUN a2enmod rewrite

# Mengubah DocumentRoot default Apache agar mengarah ke folder public/ Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Mengekspos port 80 untuk web traffic
EXPOSE 80
