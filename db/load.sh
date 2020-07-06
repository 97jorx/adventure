#!/bin/sh

BASE_DIR=$(dirname "$(readlink -f "$0")")
if [ "$1" != "test" ]; then
    psql -h localhost -U adventure -d adventure < $BASE_DIR/adventure.sql
fi
psql -h localhost -U adventure -d adventure_test < $BASE_DIR/adventure.sql
