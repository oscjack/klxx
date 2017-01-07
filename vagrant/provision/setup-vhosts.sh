#!/usr/bin/env bash
SITE_NAME=$1
SITE_ROOT=$2

BLOCK="
<VirtualHost *:80>
    ServerName ${SITE_NAME}
    ServerAlias www.${SITE_NAME}

    ServerAdmin webmaster@localhost
    DocumentRoot ${SITE_ROOT}

    ErrorLog /var/log/apache2/${SITE_NAME}.error.log
    CustomLog /var/log/apache2/${SITE_NAME}.access.log combined

    <Directory "${SITE_ROOT}">
         Options Indexes FollowSymLinks MultiViews
         AllowOverride All
         Order deny,allow
         Allow from all
         Require all granted
    </Directory>
</VirtualHost>
"

echo "$BLOCK" > "/etc/apache2/sites-available/${SITE_NAME}.conf"

ln -fs "/etc/apache2/sites-available/${SITE_NAME}.conf" "/etc/apache2/sites-enabled/${SITE_NAME}.conf"

sudo service apache2 restart
