#!/bin/bash

cd $(echo $PDCDIR | tr -d '\r')
cd dev-container/bash


echo "**** Project Setup Started ****"

echo "Please select git connection [1 or 2]?"
select yn in "https" "ssh"; do
    case $yn in
        https ) CONN=https; break;;
        ssh ) CONN=ssh; break;;
    esac
done

if [ "$CONN" == "https" ]; then
    read -p "Please Enter Your Git Username: "  username
fi

SSH_PREFIX="git@github.com:JAGMOHAN1991"
HTTPS_PREFIX="https://${username}@github.com"

while read project; do

  echo "Checking $project setup..."
  #Generating the git url based on user selection
  if [ "$CONN" == "https" ]; then
      GIT_URL="$HTTPS_PREFIX/$project.git"
  else
    GIT_URL="$SSH_PREFIX/$project.git"
  fi

  # Moving Cursor To Projects Directory
  cd $(echo $PDCDIR | tr -d '\r')

  # Checking if project already cloned
  if [ -d "$project" ]; then
      echo "$project project already exist. Skipped."
  else
      pwd
      echo "Project $project not found. Cloning..."
      echo "git clone "$GIT_URL""
      command git clone "$GIT_URL" 2> /dev/null
      echo "Cloning complete. $project"
      cd "$project"

      # check if setup has projects
      ENVFILE="$(echo $PDCDIR | tr -d '\r')/example.env"

      if [ -f "$ENVFILE" ]; then
          echo "Copying $ENVFILE => .env"
          command cp "$ENVFILE" .env
      else
        echo "Copying .env.example => .env"
        command cp .env.example .env
      fi


      echo "Setting the permissions and create Directory..."
      command mkdir storage/framework
      command mkdir storage/framework/cache
      command mkdir storage/framework/sessions
      command mkdir storage/framework/views
      command chmod -R 775 storage
      command chmod -R 775 bootstrap
  fi
done < projects.txt


echo "**** Project Setup Done ****"


