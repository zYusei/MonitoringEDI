# Utiliser l'image PHP officielle
FROM php:7.4-apache

# Copier les fichiers de votre application dans le conteneur
COPY . /var/www/html

# Exposer le port Apache
EXPOSE 80
