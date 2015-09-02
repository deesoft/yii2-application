Creating links from rest to app
=======================================

Often it's required to create links from the rest application to the app application. Since the app application may
contain its own URL manager rules you need to duplicate that for the rest application by naming it differently:

```php
return [
    'components' => [
        'urlManager' => [
            // here is your normal rest url manager config
        ],
        'urlManagerFrontend' => [
            // here is your app URL manager config
        ],

    ],
];
```

After it is done, you can get an URL pointing to app like the following:

```php
echo Yii::$app->urlManagerFrontend->createUrl(...);
```
