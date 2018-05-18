#!/usr/bin/env bash
#composer install
rsync -azv -e "ssh" --rsync-path="rsync" --exclude '.git' --exclude 'var/log' --exclude 'app/cache' --exclude '.idea' --exclude 'node_modules' --exclude 'app/config/parameters.yml' . gpfxc7ujjzdb@43.255.154.50:/home/gpfxc7ujjzdb/public_html/bm