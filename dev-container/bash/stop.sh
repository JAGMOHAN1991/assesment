#!/bin/bash

cd $(echo $PDCDIR | tr -d '\r')
echo "Stoping the backend docker containers..."
command docker compose down

