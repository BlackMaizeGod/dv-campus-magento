#!/bin/bash

read -r -p "Enter db version: " db_version

case $db_version in
  57)
    port=3357
    ;;
  56)
    port=3356
    ;;
  *)
    exit
    ;;
esac

read -r -p "Enter db name: " db_name

printf 'Select action: \n  [1] - pack \n  [2] - unpack \n'
read -r -p '-> ' case

case $case in
  1|pack)
    read -r -p "Enter user name: " user
    read -r -p "Enter user password: " password

    if [ "$user" = '' ] & [ "$password" = '' ]
    then
      password=$db_name
      user=$db_name
    fi

    mysqldump -u"$user" -p"$password" -h 127.0.0.1 --port=$port "$db_name" | gzip > var/db.sql.gz
    ;;
  2|unpack)
    dir="$PWD/$DIRECTORY"
    cd "$dir/var" || exit
    gunzip db.sql.gz
    mysql_query_string="use $db_name; source db.sql;"
    mysql -uroot -proot -h127.0.0.1 --port="$port" --show-warnings  -D "$db_name" -e "$mysql_query_string"
    rm db.sql
    ;;
  *)
    exit
    ;;
esac