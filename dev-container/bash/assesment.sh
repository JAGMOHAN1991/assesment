#!/bin/bash

cd $(echo $PDCDIR | tr -d '\r')
cd bash

echo "building dockerfile"


case $1 in
"start")
  bash start.sh
  ;;
"restart")
  bash restart.sh
  ;;
"stop")
  bash stop.sh
  ;;
"clean")
  bash stop.sh
  command docker system prune -a -f
  docker network create --driver bridge dev_network 2> /dev/null
  ;;
"setup")
  bash setup.sh
  ;;
"test")
  bash test.sh
  ;;
*)
  echo "Invalid command: assesment $1"
  ;;
esac
echo "Cheers!"
