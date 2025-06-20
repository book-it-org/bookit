#!/bin/bash

if [ ! -f "./vendor/bin/sail" ]; then
    echo "./vendor/bin/sail not found."
    exit 1
fi

chmod +x ./vendor/bin/sail
./vendor/bin/sail "$@"
