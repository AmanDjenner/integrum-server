#!/bin/bash

echo `date` > /opt/integrum-server/log/event-archiver.log

if [ "X${INTEGRUM_PASS}" = "X" ] ; then 
  INTEGRUM_PASS=QA3RP4IFe\"/sjwDT+Y*5yF36=!3
fi
if [ "X${INTEGRUM_DBHOST}" = "X" ] ; then 
  INTEGRUM_DBHOST=127.0.0.1
fi
cd /opt/integrum-server/sql

mysql -uintegrum -h$INTEGRUM_DBHOST -p$INTEGRUM_PASS integrum -e'source /opt/integrum-server/scripts/events-archiver/mysql-integrum-event-archive-s0.sql'
curl -X POST http://localhost:28080/integrumservices/events/archive/2
mysql -uintegrum -h$INTEGRUM_DBHOST -p$INTEGRUM_PASS integrum -e'source /opt/integrum-server/scripts/events-archiver/mysql-integrum-event-archive-s1.sql'
curl -X POST http://localhost:28080/integrumservices/events/archive/1

mysql -uintegrum -h$INTEGRUM_DBHOST -p$INTEGRUM_PASS integrum -e'source /opt/integrum-server/scripts/events-archiver/mysql-integrum-event-archive-s2.sql'
curl -X POST http://localhost:28080/integrumservices/events/archive/0
