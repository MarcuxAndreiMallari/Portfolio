# Runs the portfolio on Render (PHP + Apache)
FROM php:8.3-apache

# Silence a harmless Apache warning, and let the .htaccess files in data/ and includes/ work
# (they keep those folders private)
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
 && a2enmod rewrite \
 && sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copy the whole project into the web folder
COPY . /var/www/html/

# Render tells the app which port to use through the PORT variable, so Apache is switched to that port when it starts
CMD ["bash", "-c", "PORT=${PORT:-10000}; sed -i \"s/80/${PORT}/g\" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf && apache2-foreground"]
