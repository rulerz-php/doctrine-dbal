#!/bin/sh

rm -f ./examples/rulerz.db && sqlite3 ./examples/rulerz.db < ./examples/schema.sql