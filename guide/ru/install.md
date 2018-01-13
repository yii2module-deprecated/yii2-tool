Установка
===

Устанавливаем зависимость:

```
composer require yii2module/yii2-tool
```

Объявляем консольный модуль:

```php
return [
	'modules' => [
		// ...
		'tool' => 'yii2module\tool\console\Module',
		// ...
	],
];
```

Объявляем домен:

```php
return [
	'components' => [
		// ...
		'tool' => [
            'class' => Domain::class,
            'path' => 'yii2module\tool\domain',
            'repositories' => [
                'password',
            ],
            'services' => [
                'password',
            ],
        ],
		// ...
	],
];
```
