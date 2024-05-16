#!/bin/bash

# Command 1
sudo apt install apache2

# Command 2
sudo add-apt-repository ppa:ondrej/php

# Command 3
sudo apt-get install php7.4 php7.4-cli php7.4-common php7.4-fpm

# Command 4
sudo apt-get install libapache2-mod-php7.4

# Command 5
sudo apt-get install php7.4-mysqli

# Command 6
sudo systemctl restart apache2

# Command 7
sudo apt-get install mysql-server

# Command 8
sudo systemctl enable mysql

# MySQL Commands
sudo mysql -u root -e "CREATE USER 'happy_user'@'localhost' IDENTIFIED BY 'Happy_12346';"
sudo mysql -u root -e "FLUSH PRIVILEGES;"
sudo mysql -u root -e "GRANT ALL PRIVILEGES ON *.* TO 'happy_user'@'localhost';"
sudo mysql -u happy_user -p'Happy_12346' -e "CREATE DATABASE IF NOT EXISTS LinksDb;"
# sudo mysql -u root -e "CREATE USER 'vpn_user'@'localhost' IDENTIFIED BY 'Vpn_12346';"
# sudo mysql -u root -e "CREATE USER 'happy_user'@'localhost' IDENTIFIED BY 'Happy_12346';"
# sudo mysql -u root -e "FLUSH PRIVILEGES;"
# sudo mysql -u root -e "GRANT ALL PRIVILEGES ON *.* TO 'vpn_user'@'localhost';"
# sudo mysql -u root -e "GRANT ALL PRIVILEGES ON *.* TO 'happy_user'@'localhost';"
# sudo mysql -u happy_user -p'Happy_12346' -e "CREATE DATABASE IF NOT EXISTS HappyDb;"
# sudo mysql -u happy_user -p'Happy_12346' -e "SHOW DATABASES;"
# sudo mysql -u happy_user -p'Happy_12346' -D HappyDb < DefaultDb.sql
# sudo mysql -u happy_user -p'Happy_12346' -D HappyDb < DefaultDb.sql
sudo mysql -u root < DefaultDb.sql
