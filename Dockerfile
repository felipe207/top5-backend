# Usar a imagem oficial do PHP com Apache como base
FROM php:8.2-apache

# Definir o diretório de trabalho dentro do contêiner
WORKDIR /var/www/html

# Instalar extensões PHP necessárias
RUN docker-php-ext-install pdo pdo_mysql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar o arquivo composer.json e composer.lock para o diretório de trabalho
COPY composer.* ./

# Instalar as dependências do projeto
RUN composer install

# Copiar todos os arquivos do projeto para o diretório de trabalho
COPY . .

# Definir permissões para o diretório de armazenamento
RUN chown -R www-data:www-data storage
RUN chown -R www-data:www-data bootstrap/cache

# Expor a porta em que o aplicativo será servido
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]
