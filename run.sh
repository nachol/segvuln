#!/bin/bash
cd /app && git pull
chgrp -R www-data .
chown -R www-data:www-data .
chmod -R g+w /app/var/cache /app/var/log /app/var/app.db
source /etc/apache2/envvars
tail -F /var/log/apache2/* &
exec apache2 -D FOREGROUND