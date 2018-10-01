FROM ubuntu:18.04
COPY . /app
COPY .env /app
WORKDIR /app
VOLUME "/tmp/segvuln":"/app/var"
RUN DEBIAN_FRONTEND=noninteractive apt-get update \
	&& DEBIAN_FRONTEND=noninteractive apt-get install -y php apache2 libapache2-mod-php7.2 \
	php-mysql php-intl git git-core curl php-curl php-xml composer zip unzip php-zip php-sqlite3 php-ldap nano
RUN	php /app/composer install --no-scripts \
	&& php /app/composer update \
	&& php /app/bin/console doctrine:database:create \
	&& php /app/bin/console doctrine:schema:update --force \
	&& rm -rf /var/www/* \
	&& a2enmod rewrite \
	&& echo "ServerName localhost" >> /etc/apache2/apache2.conf \
	&& cp ./vhost.conf /etc/apache2/sites-available/000-default.conf

# Add main start script for when image launches
ADD run.sh /run.sh
RUN chmod 0755 /run.sh
EXPOSE 80
CMD ["/run.sh"]