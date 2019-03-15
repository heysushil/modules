//Remove coment lines when you want to use this.
// For exeding the php.ini file limit without changing the core file. This one is the best option to do this. Just you need to add this file on your root directory or if you have already .htaccess fiel then just copy past this code to make changes. Also don't forget to restart once your local server for changes.
Alos if you want to change other limit of php.ini file you just add them here.
after changes if you want to check the changes just run the php code
<?php phpinfo(); ?> it will show you the php cofigrations all details. So you find your changes.

php_value upload_max_filesize 100000M
php_value post_max_size 99500M
php_value memory_limit -1
php_value max_execution_time 300
