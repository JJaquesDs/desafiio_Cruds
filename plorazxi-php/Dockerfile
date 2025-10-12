FROM php:8.2-fpm

WORKDIR /usr/local/app


# Instala dependências necessárias
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo pdo_mysql

COPY . .

RUN composer install

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "src/main.php"]