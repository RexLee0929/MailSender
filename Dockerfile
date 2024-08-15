FROM php:8.1-alpine

RUN apk --no-cache add \
    libpng libpng-dev \
    libjpeg-turbo libjpeg-turbo-dev \
    libxpm libxpm-dev \
    freetype freetype-dev \
    zlib zlib-dev \
    bash \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

WORKDIR /home/MailSender

COPY . /home/MailSender/

EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80"]
