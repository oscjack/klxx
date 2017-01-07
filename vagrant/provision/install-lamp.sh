#!/usr/bin/env bash

#installing lamp
echo ">>> Installing Lamp..."
sudo apt-get install -y \
    apache2 php libapache2-mod-php php-mcrypt php-curl php-soap \
    pv imagemagick php-gd php-imagick php-json php-mbstring php-xml

sudo a2enmod rewrite && sudo service apache2 restart

# install mysql and give password to installer
PASSWORD="root"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password $PASSWORD"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password $PASSWORD"
sudo apt-get -y install mysql-server
sudo apt-get -y install php-mysql

sudo apt-get install nodejs
sudo apt-get install npm

# MySQL Timezone Table
mysql_tzinfo_to_sql /usr/share/zoneinfo | mysql -u ${PASSWORD} -p ${PASSWORD} mysql

echo ">>> Installed Lamp..."
