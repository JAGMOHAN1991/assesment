#!/bin/bash

cd $(echo $PDCDIR | tr -d '\r')
cd dev-container/bash


echo "**** Test Execution Start ****"

command docker exec -it -w /var/www/assesment assesment_server php artisan test --testsuite=Unit





