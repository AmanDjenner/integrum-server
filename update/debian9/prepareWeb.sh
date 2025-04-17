rm -rf /opt/integrum-server/html/app/storage/cache/*
rm -rf /opt/integrum-server/html/app/storage/views/*
rm -rf /opt/integrum-server/html/app/storage/sessions/*
usermod -a -G www-data wildfly
chown -R wildfly:wildfly /opt/integrum-server
chown -R www-data:www-data /opt/integrum-server/html  
chmod -R g+w /opt/integrum-server/html
chmod -R g+w /opt/integrum-server/html
