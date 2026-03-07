# Estágio 1: PHP e Dependências de Sistema
FROM php:8.2-fpm-alpine

# Definir diretório de trabalho
WORKDIR /var/www

# Instalar dependências do sistema e extensões PHP necessárias para Laravel/Filament
RUN apk add --no-cache \
    bash \
    curl \
    libpng-dev \
    libzip-dev \
    zlib-dev \
    icu-dev \
    oniguruma-dev \
    $PHPIZE_DEPS

RUN docker-php-ext-install \
    gd \
    zip \
    intl \
    bcmath \
    pdo_mysql \
    opcache

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar arquivos do projeto
COPY . .

# Ajustar permissões para o Laravel (Storage e Cache)
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Instalar dependências do PHP (sem dev para produção)
RUN composer install --no-dev --optimize-autoloader

# Expor a porta do PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]