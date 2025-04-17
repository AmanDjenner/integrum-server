#!/bin/bash

function wildflyCheck() {
param=$1
output=`/opt/wildfly/bin/jboss-cli.sh -c --command=":read-attribute(name=server-state)"`
if [ $? -eq 1 ]; then
sleep  $((($param+1)*5))s
param=$(( param + 1))
if [ $param -lt 5 ]; then
wildflyCheck $param
else
echo $output
exit 1;
fi
fi
}

if [ -z $3 ];then
  strDbConn='localhost:3306';
else
  strDbConn=$3;
fi

if [ -z $4 ];then
  dbConnMin=5;
  dbConnInit=5;
  dbConnMax=25;
  dbConnStats=true;
else
  dbConnMin=`echo $4 | awk -F':' '{print $1}'`
  dbConnInit=`echo $4 | awk -F':' '{print $2}'`
  dbConnMax=`echo $4 | awk -F':' '{print $3}'`
  dbConnStats=`echo $4 | awk -F':' '{print $4}'`
fi


echo "connect
reload
quit" > /tmp/reload-ds.tmp
echo "connect
data-source remove --name=SatelEssentialDS" > /tmp/essential-upd1-ds.tmp
echo "connect
data-source add --name=SatelEssentialDS --driver-name=mysql --connection-url=jdbc:mysql://$strDbConn/essential?autoReconnect=true&zeroDateTimeBehavior=convertToNull&useUnicode=true&characterEncoding=UTF-8&allowPublicKeyRetrieval=true&useSSL=false&serverTimezone=`timedatectl | grep "Time zone" | awk -e '{print $3}'` --jndi-name=java:jboss/datasources/SatelEssentialDS --user-name=mapsatel --password=$1 --use-ccm=false --min-pool-size=5 --max-pool-size=50 --blocking-timeout-wait-millis=2000 --check-valid-connection-sql=\"select 1\" --background-validation=true --background-validation-millis=10000
quit" > /tmp/essential-upd2-ds.tmp
echo "connect
data-source test-connection-in-pool --name=SatelEssentialDS
quit" > /tmp/essential-upd3-ds.tmp
echo "connect
data-source remove --name=SatelIntegrumDS
quit" > /tmp/integrum-upd1-ds.tmp
echo "connect
data-source add --name=SatelIntegrumDS --driver-name=mysql --connection-url=jdbc:mysql://$strDbConn/integrum?autoReconnect=true&zeroDateTimeBehavior=convertToNull&useUnicode=true&characterEncoding=UTF-8&allowPublicKeyRetrieval=true&useSSL=false&serverTimezone=`timedatectl | grep "Time zone" | awk -e '{print $3}'` --jndi-name=java:jboss/datasources/SatelIntegrumDS --user-name=integrum --password=$2 --use-ccm=false --min-pool-size=$dbConnMin --max-pool-size=$dbConnMax --initial-pool-size=$dbConnInit --blocking-timeout-wait-millis=2000 --check-valid-connection-sql=\"select 1\" --background-validation=true --background-validation-millis=10000 --statistics-enabled=\"$dbConnStats\"
quit" > /tmp/integrum-upd2-ds.tmp
echo "connect
data-source test-connection-in-pool --name=SatelIntegrumDS
quit" > /tmp/integrum-upd3-ds.tmp

wildflyCheck 0
output=`/opt/wildfly/bin/jboss-cli.sh  --file=/tmp/essential-upd1-ds.tmp`
output=`/opt/wildfly/bin/jboss-cli.sh  --file=/tmp/integrum-upd1-ds.tmp`
/opt/wildfly/bin/jboss-cli.sh  --file=/tmp/reload-ds.tmp
wildflyCheck 0
/opt/wildfly/bin/jboss-cli.sh  --file=/tmp/essential-upd2-ds.tmp
/opt/wildfly/bin/jboss-cli.sh  --file=/tmp/integrum-upd2-ds.tmp
/opt/wildfly/bin/jboss-cli.sh  --file=/tmp/reload-ds.tmp
wildflyCheck 0
/opt/wildfly/bin/jboss-cli.sh  --file=/tmp/essential-upd3-ds.tmp
/opt/wildfly/bin/jboss-cli.sh  --file=/tmp/integrum-upd3-ds.tmp


if [ $? -eq 0 ]; then
rm -f /tmp/reload-ds.tmp
rm -f /tmp/essential-upd1-ds.tmp
rm -f /tmp/essential-upd2-ds.tmp
rm -f /tmp/essential-upd3-ds.tmp
rm -f /tmp/integrum-upd1-ds.tmp
rm -f /tmp/integrum-upd2-ds.tmp
rm -f /tmp/integrum-upd3-ds.tmp
fi
