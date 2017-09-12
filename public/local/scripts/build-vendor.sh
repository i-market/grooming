#!/usr/bin/env sh

cp node_modules/jquery.maskedinput/src/jquery.maskedinput.js ${npm_package_config_dist}/js/vendor/jquery.maskedinput.js &&
# overwrites `mockup` fancybox
cp node_modules/fancybox/dist/jquery.fancybox.js ${npm_package_config_dist}/js/vendor/jquery.fancybox3.js &&
cp node_modules/fancybox/dist/jquery.fancybox.css ${npm_package_config_dist}/css/lib/jquery.fancybox3.css
