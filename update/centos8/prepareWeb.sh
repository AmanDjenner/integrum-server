rm -rf /opt/integrum-server/html/app/storage/cache/*
rm -rf /opt/integrum-server/html/app/storage/views/*
rm -rf /opt/integrum-server/html/app/storage/sessions/*
usermod -a -G apache wildfly
chown -R wildfly:wildfly /opt/integrum-server
chown -R apache:apache /opt/integrum-server/html  
chmod -R g+w /opt/integrum-server/html  
semanage fcontext -a -t httpd_sys_rw_content_t '/opt/integrum-server/html/app/storage(/.*)?'  
restorecon -FRv /opt/integrum-server/html  
setsebool -P httpd_can_network_connect on   
