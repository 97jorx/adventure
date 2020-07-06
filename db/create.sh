#!/bin/sh

if [ "$1" = "travis" ]; then
    psql -U postgres -c "CREATE DATABASE adventure_test;"
    psql -U postgres -c "CREATE USER adventure PASSWORD 'adventure' SUPERUSER;"
else
    sudo -u postgres dropdb --if-exists adventure
    sudo -u postgres dropdb --if-exists adventure_test
    sudo -u postgres dropuser --if-exists adventure
    sudo -u postgres psql -c "CREATE USER adventure PASSWORD 'adventure' SUPERUSER;"
    sudo -u postgres createdb -O adventure adventure
    sudo -u postgres psql -d adventure -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    sudo -u postgres createdb -O adventure adventure_test
    sudo -u postgres psql -d adventure_test -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    LINE="localhost:5432:*:adventure:adventure"
    FILE=~/.pgpass
    if [ ! -f $FILE ]; then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE; then
        echo "$LINE" >> $FILE
    fi
fi
