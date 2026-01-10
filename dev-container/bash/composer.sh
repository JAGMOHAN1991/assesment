#!/bin/bash

cd $(echo $PDCDIR | tr -d '\r')
cd dev-container/bash


echo "**** Composer install Start ****"

echo "Please select project [1]?"
select abcdef in "assesment"; do
    case $abcdef in
        assesment  ) CONN=assesment ; break;;
    esac
done

if [ "$CONN" == "assesment" ]; then
    command docker exec -it assesment_server composer install -d assesment
fi





