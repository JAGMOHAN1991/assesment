#!/bin/bash

cd $(echo $PDCDIR | tr -d '\r')
cd bash

echo "Detecting operating system..."
unameOut="$(uname -s)"
case "${unameOut}" in
    Linux*)     machine=Linux;;
    Darwin*)    machine=Mac;;
    *)          machine="UNKNOWN:${unameOut}"
esac

if [ "$machine" = "Linux" ]; then
    echo "Operating System: $machine"
    bash os/linux.sh
elif [ "$machine" = "Mac" ]; then
    echo "Operating System: $machine"
    bash os/osx.sh
else
    echo "Unsupported operating system."
    echo "Exiting the setup process..."
    exit 1
fi

echo "Creating docker network: dev_network"
docker network create --driver bridge dev_network 2> /dev/null

# Updated /etc/hosts
echo "Updating /etc/hosts..."
ip_address="127.0.0.1"
while read project; do
  case "$project" in
  "assesment")
      host_name="api.assesment.local"
    ;;

  esac
  # find existing instances in the host file and save the line numbers
  matches_in_hosts="$(grep -n "$host_name" /etc/hosts | cut -f1 -d:)"
  host_entry="${ip_address}   ${host_name}"


  if [ -n "$matches_in_hosts" ]
  then
      echo "Host entry for [$host_name] already exists. Skipped."
  else
      echo "Adding new hosts entry: $host_name."
      echo "$host_entry" | sudo tee -a /etc/hosts > /dev/null
  fi
done < projects.txt

bash project.sh

echo "Note: Verify all your environment variables if something does not work."
