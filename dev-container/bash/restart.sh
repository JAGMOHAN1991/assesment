#!/bin/bash

cd $(echo $PDCDIR | tr -d '\r')
cd bash
bash stop.sh


command docker compose rm -f

cd $(echo $PDCDIR | tr -d '\r')
cd bash
bash start.sh