#!/bin/bash
sed -ri -r 's!/var/www/html/$!'"$WEB_DOCUMENT_ROOT"'!g' /etc/apache2/sites-available/000-default.conf
sed -ri -r 's!USER:=www-data!USER:=tonidev!g' /etc/apache2/envvars
chown $APACHE_RUN_USER /var/www/html -R
exec /usr/local/bin/apache2-foreground "$@"