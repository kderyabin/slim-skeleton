# Slim Framework 3 application skeleton


This application skeleton is a new refreshing look on Slim project structure. It allows you to quickly setup a new project and start working on your business requirements. 

It comes with latest Slim 3 and it's PHP-View template renderer, logger, helper classes to facilitate your work with unit tests and sample classes to help you to start on. This skeleton is built on `kod/bootstrap-slim` package which makes your development process easier and your code more organized.

Adepts of MVC approach will find a ready to use MVC structure and classes. And if you are not a fun of MVC you can go with classical Slim functional programming. Simply remove MVC folder from your project. 

## Create new project

Run following commands from the directory in which you want to setup your new project. Do not forget to replace [you-app-name] with the desired directory name for your application. 

```bash
composer create-project kod/slim-skeleton [you-app-name]
cd [you-app-name]
# install dependencies
composer install
# start php server
composer run start --timeout=0
# Open the browser and go to http://localhost:8099/ to see the sample page
```

If the port :8099 is taken by another program update composer.json and set another value for the port in `start` command. 

### Server configuration

The document root of your project's virtual host must point to `src/public` directory.

### Logger

Default format is a json format. If the application is executed with php built-in server logger will write logs to stdout. If it's run on the server (apache/nginx) it will write to `var/debug.log`. Ensure this directory is writable by the server. For logger configuration see [logger settings](https://github.com/kderyabin/logger/blob/master/doc/configuration.md).

##  Composer Commands

|command|usage| description
|:---|:---|:---
|start|composer run start --timeout=0| start the php built-in server 
|phpcs|composer phpcs| run php code style check (uses PSR2 requirements)
|phpcs-fix|composer phpcs-fix|fix code style errors and warning
|phpunit|composer phpunit| run unit tests
|phpunit-cover|composer phpunit-cover| run unit tests with coverage report (available in ./coverage folder)
|test|composer test| run code style check and unit tests


Have fun!