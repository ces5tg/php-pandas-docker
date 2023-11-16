FROM php:7-apache

LABEL maintainer="Sawood Alam <@ibnesayeed>"

ENV API_ENDPOINT="http://localhost:7018/upload"

# Copia los archivos al directorio de trabajo del servidor web
COPY . /var/www/html/

EXPOSE 80

# Establecer permisos adecuados para el servidor web
RUN chown -R www-data:www-data /var/www/html/ \
    && chmod -R 755 /var/www/html/

# Establecer el límite de tamaño de carga
RUN echo "upload_max_filesize = 100M" > /usr/local/etc/php/conf.d/uploads.ini

# Establecer el límite de tamaño de POST
RUN echo "post_max_size = 100M" >> /usr/local/etc/php/conf.d/uploads.ini

# Ajustar el tiempo máximo de ejecución
RUN echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/uploads.ini