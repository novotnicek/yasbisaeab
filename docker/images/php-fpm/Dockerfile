FROM php:8.2-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y \
        curl \
        git \
        libfreetype6-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libonig-dev \
        libpng-dev \
        libxml2-dev \
        libzip-dev \
        unzip \
        vim

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install bcmath exif gd intl mbstring opcache pdo_mysql zip xml

## install composer
## 2855762e882810a64816eded274321c56d9b274a - Apr 29, 2022
RUN curl -o- https://raw.githubusercontent.com/composer/getcomposer.org/2855762e882810a64816eded274321c56d9b274a/web/installer | php -- --quiet
RUN mv composer.phar /usr/local/bin/composer

## Node.js
## set version and directories environment variables
ENV NODE_VERSION=18.18.2
ENV NVM_DIR=/root/.nvm
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"
## install node.js and npm
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
## install yarn and gulp
RUN npm install --global yarn
RUN yarn install
