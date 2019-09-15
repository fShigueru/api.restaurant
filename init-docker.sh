#!/usr/bin/env bash

cd api.restaurant
touch .env
echo "PROJECT_NAME=api.restaurant" >> .env
echo "MYSQL_ROOT_PASSWORD=root" >> .env
echo "MYSQL_DATABASE=hackapi" >> .env
echo "MYSQL_USER=hackapi" >> .env
echo "MYSQL_PASSWORD=hackapi" >> .env
echo "DB_HOST=mysql" >> .env

docker network create hackathon

make up

cd src

export fileid=1sHcJdYAASvBO3P4h4pvBOegusQIgv7RK
export filename=.env

wget -O $filename 'https://docs.google.com/uc?export=download&id='$fileid

cd ..

make composer_install

make migrate
