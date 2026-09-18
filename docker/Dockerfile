# Imaginea pentru site: PHP 7.4 + Apache, aceeasi combinatie ca pe serverul Hostico.
# Pornim de la o imagine oficiala si adaugam extensiile cerute de OpenCart 3.
FROM php:7.4-apache

# Bibliotecile de sistem necesare pentru compilarea extensiilor PHP.
# Acquire::Retries = reincearca descarcarile care esueaza din cauza retelei.
# Debian 11 a trecut in arhiva, iar depozitul de securitate nu mai serveste
# pachetele vechi. Pentru un mediu LOCAL folosim doar depozitul principal.
RUN sed -i '/security/d' /etc/apt/sources.list \
    && echo 'Acquire::Retries "8"; Acquire::http::Timeout "30";' > /etc/apt/apt.conf.d/99retries \
    && apt-get update \
    && apt-get install -y --no-install-recommends --fix-missing \
        libfreetype6-dev libjpeg62-turbo-dev libpng-dev libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# Extensiile PHP pe care le cere OpenCart
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        gd mysqli pdo_mysql zip opcache

# mod_rewrite = adresele prietenoase (/invertoare in loc de index.php?route=...)
RUN a2enmod rewrite headers expires

# Apache sa permita regulile din .htaccess
RUN printf '<Directory /var/www/html/>\n\tAllowOverride All\n\tRequire all granted\n</Directory>\n' \
    > /etc/apache2/conf-available/oc-override.conf \
    && a2enconf oc-override

WORKDIR /var/www/html
