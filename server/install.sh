#!/bin/bash
docker run --rm --interactive --tty --volume ${PWD}/app:/app composer install --ignore-platform-reqs

# docker run --rm --interactive --tty --volume ${PWD}/app:/app composer require endroid/qr-code --ignore-platform-req=ext-gd
#docker run --rm --interactive --tty --volume ${PWD}/app:/app composer install