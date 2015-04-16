Yii2 Application Template
===========

REQUIREMENTS
------------

The minimum requirement by this application template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install the application using the following command:

~~~
# git clone https://github.com/deesoft/yii2-application.git application
# cd application
# php composer.phar global require "fxp/composer-asset-plugin:1.0.0"
# php composer.phar update
~~~


GETTING STARTED
---------------

After you install the application, you have to conduct the following steps to initialize
the installed application. You only need to do these once for all.

1. Run command `init` to initialize the application with a specific environment.
2. Create a new database and adjust the `components['db']` configuration in `app/config/common-local.php` accordingly.
3. Apply migrations with console command `yii migrate`. This will create tables needed for the application to work.

To login into the application, you need to first sign up, with any of your email address, username and password.
Then, you can login into the application with same email address and password at any time.
