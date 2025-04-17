/opt/integrum-server/bin/integrum.sh stop
UPDATE_DIR=`pwd`
cd /opt
BACKUPDATE=$(date +%Y%m%d-%H%M)
tar -cvzf integrum-backup-$BACKUPDATE.tar.gz integrum-server/
cd /opt/integrum-server
find . -name "*.jar" -type f -delete
find . -name "*.js" -type f -delete
rm -rf log/*.log
rm -rf log/*.log.*
rm -rf bin/*.pid
rm -rf bin/*.status
rm -rf html/app/storage/views/*
rm -rf html/app/storage/logs/*
cd /opt
tar --overwrite -xzf $1
yes | cp -R /opt/integrum-server/ee/* /opt/wildfly/standalone/deployments
sleep 5
ls -l /opt/wildfly/standalone/deployments/*.ear.*
cd $UPDATE_DIR
./prepareWeb.sh
/opt/integrum-server/bin/integrum.sh start

