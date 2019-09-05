#!/usr/bin/env bash

docker build -t fshigueru/php7.1 php/7.1/.
docker build -t fshigueru/nginx nginx/.
docker build -t fshigueru/redis redis/.
#docker build -t fshigueru/php7.2 php/7.2/.
#docker build -t fshigueru/blackfire php/7.2/blackfile/.
#docker build -t fshigueru/xdebug php/7.2/xdebug/.