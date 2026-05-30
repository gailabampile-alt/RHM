FROM php:8.2-apache

ARG CACHEBUST=3

RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        libzip-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libxml2-dev \
        libonig-dev \
    ; \
    docker-php-ext-configure gd --with-freetype --with-jpeg; \
    docker-php-ext-install -j"$(nproc)" pdo pdo_mysql zip gd mbstring; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

RUN printf '<Directory /var/www/html>\n\
    AllowOverride All\n\
    Options -Indexes +FollowSymLinks\n\
    Require all granted\n\
</Directory>\n' > /etc/apache2/conf-enabled/app.conf

WORKDIR /var/www/html

COPY . .

RUN mkdir -p photoAgent photoStagiaire Documents DocumentsStagiaire fichierEnf_Agent rapport rapport_xlsx \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 photoAgent photoStagiaire Documents DocumentsStagiaire fichierEnf_Agent rapport rapport_xlsx

EXPOSE 80
