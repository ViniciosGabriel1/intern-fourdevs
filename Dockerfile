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

# 1. Instalar dependências de sistema
RUN apk add --no-cache \
    bash curl libpng-dev libzip-dev zlib-dev \
    icu-dev oniguruma-dev nginx $PHPIZE_DEPS

# 2. Instalar extensões PHP
RUN docker-php-ext-install gd zip intl bcmath pdo_mysql opcache

# 3. Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Copiar código e assets do build anterior
COPY . .
COPY --from=assets /app/public/build ./public/build

# 5. Copiar a config do Nginx (para o local correto no Alpine)
COPY nginx.conf /etc/nginx/http.d/default.conf

# 6. Instalar dependências do Composer
RUN composer install --no-dev --optimize-autoloader

# 7. AJUSTE DE PERMISSÕES (Único e final)
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 80

# Comando para iniciar ambos os serviços
CMD php-fpm -D && nginx -g "daemon off;"