FROM php:7.4.23-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
# change document root directory
ENV APACHE_DOCUMENT_ROOT /var/www/html

RUN sed -ri -e 's!disable_functions =!disable_functions = putenv!g' /usr/local/etc/php/php.ini

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf


# autorise .htaccess files
# changes None for all.
RUN sed -i '/<Directory ${APACHE_DOCUMENT_ROOT}>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf 
RUN a2enmod rewrite

# installing xdebug
RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=develop" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_port=9000" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_upon_error=yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini


