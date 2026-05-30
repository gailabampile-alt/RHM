FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libxml2-dev \
    libonig-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd xml mbstring

RUN a2enmod rewrite

RUN echo '<Directory /var/www/html>\n\
    AllowOverride All\n\
    Options -Indexes +FollowSymLinks\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-enabled/app.conf

WORKDIR /var/www/html

COPY . .

RUN mkdir -p photoAgent photoStagiaire Documents DocumentsStagiaire fichierEnf_Agent rapport rapport_xlsx \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 photoAgent photoStagiaire Documents DocumentsStagiaire fichierEnf_Agent rapport rapport_xlsx

EXPOSE 80
