#!/usr/bin/env bash

docker build -t fshigueru/php7.1 php/7.1/.
docker build -t fshigueru/nginx nginx/.
docker build -t fshigueru/redis redis/.