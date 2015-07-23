Configuring Composer
====================

After the project template is installed it's a good idea to adjust default `composer.json` that can be found in the root
directory:

```json
{
    "name": "deesoft/yii2-app-single",
    "description": "Yii 2 Single Project Template",
    "keywords": ["yii2", "framework", "advanced", "project template"],
    "type": "project",
    "license": "BSD-3-Clause",
    "support": {
        "issues": "https://github.com/deesoft/yii2-app-single/issues?state=open",
        "source": "https://github.com/deesoft/yii2-app-single"
    },
    "minimum-stability": "dev",
    "require": {
        "php": ">=5.4.0",
        "yiisoft/yii2": ">=2.0.4",
        "yiisoft/yii2-bootstrap": "~2.0",
        "yiisoft/yii2-swiftmailer": "~2.0",
        "deesoft/yii2-console": "~1.0",
        "mdmsoft/yii2-admin": "~2.0",
        "deesoft/yii2-adminlte": "~1.0"
    },
    "require-dev": {
        "yiisoft/yii2-codeception": "~2.0",
        "yiisoft/yii2-debug": "~2.0",
        "deesoft/yii2-gii": "~1.0",
        "yiisoft/yii2-faker": "~2.0"
    },
    "config": {
        "process-timeout": 1800
    },
    "extra": {
        "asset-installer-paths": {
            "npm-asset-library": "vendor/npm",
            "bower-asset-library": "vendor/bower"
        }
    }
}
```

First we're updating basic information. Change `name`, `description`, `keywords`, `homepage` and `support` to match
your project.

Now the interesting part. You can add more packages your application needs to the `require` section.
All these packages are coming from [packagist.org](https://packagist.org/) so feel free to browse the website for useful code.

After your `composer.json` is changed you can run `composer update --prefer-dist`, wait till packages are downloaded and
installed and then just use them. Autoloading of classes will be handled automatically.
