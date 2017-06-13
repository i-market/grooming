#!/usr/bin/env sh

# overwrites `mockup` fancybox
cp node_modules/fancybox/dist/jquery.fancybox.js ${npm_package_config_dist}/js/vendor &&
cp node_modules/fancybox/dist/jquery.fancybox.css ${npm_package_config_dist}/css/lib
