FROM wordpress:latest

WORKDIR /var/www/html

COPY www/wp-content/ ./wp-content/
COPY www/wp-admin/  ./wp-admin/
COPY www/wp-includes/ ./wp-includes

RUN chmod -R 755 ./wp-content/