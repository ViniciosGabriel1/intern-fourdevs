# --- Estágio 1: Node.js (Build dos Assets) ---
FROM node:20-alpine AS assets
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# --- Estágio 2: PHP e Dependências ---
FROM php:8.2-fpm-alpine

WORKDIR /var/www

# Instalar dependências de sistema para Filament
RUN apk add --no-cache \
    bash curl libpng-dev libzip-dev zlib-dev \
    icu-dev oniguruma-dev nginx $PHPIZE_DEPS

# Instalar extensões PHP essenciais
RUN docker-php-ext-install gd zip intl bcmath pdo_mysql opcache

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar o código da aplicação
COPY . .

# Copiar os assets compilados do estágio anterior
COPY --from=assets /app/public/build ./public/build

# Ajustar permissões para o Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Instalar dependências do Composer (Produção)
RUN composer install --no-dev --optimize-autoloader

# Expor a porta que o Easypanel vai gerenciar
EXPOSE 80

# Script para rodar PHP-FPM e Nginx (O Easypanel cuida do Proxy)
CMD php-fpm -D && nginx -g "daemon off;"