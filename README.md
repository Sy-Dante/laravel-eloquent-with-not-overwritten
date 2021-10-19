<h1 align="center"> laravel-eloquent-with-not-overwritten </h1>

<p align="center"> Add a method to eloquent that does not overwrite the established relationship when relating with..</p>


## Installing

```shell
$ composer require sydante/laravel-eloquent-with-not-overwritten -vvv
```

## Usage

```php
$eloquentModel
    ->with(
        'progresses',
        function (HasMany $builder) {
            $builder->select(['id', 'eloquent_model_id', 'workflow_id', 'status', 'admin_id'])
                ->orderBy('id');
        }
    )
    // Do not overwrite defined eager loaded relations
    ->withNotOverwritten('progresses.admin:id,name')
    ->withNotOverwritten('progresses.workflow:id,name')
    ->withNotOverwritten('progresses.workflow.adminRole:id,name,slug');
```

## Purpose

See [laravel/framework#39210](https://github.com/laravel/framework/pull/39210)

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/sydante/laravel-eloquent-with-not-overwritten/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/sydante/laravel-eloquent-with-not-overwritten/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT