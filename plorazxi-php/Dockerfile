FROM php:8.1.33-zts-trixie

WORKDIR /usr/local/app

COPY . .
EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "src/main.php"]