#!/usr/bin/env bash

username="habr"
password="habr"
database="mydatabase"

cd COMMON
mysql --user ${username} --password=${password} -D${database} < dc.sql
if [ $? -eq "1" ]; then
    exit $?
fi

echo ''
echo '>>> TABLES'
echo ''
cd TABLE
FILES=*
for f in ${FILES}
do
  scriptName=`expr "$f" : '\([a-z_]*\)'`
  var=$(mysql --user ${username} --password=${password} -D${database} <<< "select count(*) from information_schema.tables as t where t.TABLE_NAME='${scriptName}'" -s)
  if [ ${var} -ne '1' ]; then
    echo "Processing $f file..."
    mysql --user ${username} --password=${password} -D${database} < ${f}
    mysql --user ${username} --password=${password} -D${database}<<<"INSERT INTO dc (code, type, result) values ('${f}', 'CREATE TABLE', "$?")"
    if [ $? -ne 0 ]; then
        exit $?
    fi
  else
    echo '--- Skip '${f}' ---'
  fi
done

echo ''
echo '>>> FOREIGN KEYS'
echo ''
cd ../F_KEY
FILES=*
for f in ${FILES}
do
  scriptName=`expr "$f" : '\([a-z_A-Z]*\)'`
  var=$(mysql --user ${username} --password=${password} -D${database} <<< "select count(*) from information_schema.table_constraints as t where t.constraint_name='${scriptName}'" -s)
  if [ ${var} -ne '1' ]; then
    echo "Processing $f file..."
    mysql --user ${username} --password=${password} -D${database} < ${f}
    mysql --user ${username} --password=${password} -D${database}<<<"INSERT INTO dc (code, type, result) values ('${f}', 'CREATE FK', "$?")"
    if [ $? -ne 0 ]; then
        exit $?
    fi
  else
    echo '--- Skip '${f}' ---'
  fi
done
echo ''


echo ''
echo '>>> LOAD DATA SCRIPTS'
echo ''
cd ../DATA
FILES=*
for f in ${FILES}
do
  scriptName=`expr "$f" : '\([a-z0-9]*\)'`
  var=$(mysql --user ${username} --password=${password} -D${database} <<< "select count(*) from ${database}.dc as t where t.code='${f}' and result='0'" -s)
  if [ ${var} -ne '1' ]; then
    echo "Processing $f file..."
    mysql --user ${username} --password=${password} -D${database} < ${f}
    mysql --user ${username} --password=${password} -D${database}<<<"INSERT INTO dc (code, type, result) values ('${f}', 'LOAD DATA', "$?")"
    if [ $? -ne 0 ]; then
        exit $?
    fi
  else
    echo '--- Skip '${f}' ---'
  fi
done
echo ''

echo ''
echo '>>> LOAD TRIGGERS'
echo ''
cd ../TRIGGER
FILES=*
for f in ${FILES}
do
  scriptName=`expr "$f" : '\([a-z_0-9]*\)'`
  var=$(mysql --user ${username} --password=${password} -D${database} <<< "select count(*) from information_schema.triggers as t where t.trigger_name='${f}'" -s)
  if [ ${var} -ne '1' ]; then
    echo "Processing $f file..."
    mysql --user ${username} --password=${password} -D${database} < ${f}
    mysql --user ${username} --password=${password} -D${database}<<<"INSERT INTO dc (code, type, result) values ('${f}', 'LOAD TRIGGER', "$?")"
    if [ $? -ne 0 ]; then
        exit $?
    fi
  else
    echo '--- Skip '${f}' ---'
  fi
done
echo ''


exit $?