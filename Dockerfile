FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev libxml2-dev libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd mbstring \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 777 photoAgent photoStagiaire Documents DocumentsStagiaire fichierEnf_Agent rapport rapport_xlsx

ENV PORT=8080

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT} -t /var/www/html"]
