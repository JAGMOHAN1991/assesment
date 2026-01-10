#!/bin/bash

cd $(echo $PDCDIR | tr -d '\r')
echo "Starting the docker services..."

command docker compose up --build -d
