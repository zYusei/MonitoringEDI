FROM php:7.4-apache

# Installation des dépendances PHP nécessaires
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copier les fichiers de l'application dans le répertoire de travail du conteneur
COPY . /var/www/html

# Copier le fichier SQL dans le conteneur
COPY sql/edimessage.sql /docker-entrypoint-initdb.d/edimessage.sql

# Exposer le port 80 pour accéder à l'application via le navigateur
EXPOSE 80