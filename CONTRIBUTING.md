## Contributing

Contributions are very welcome. If you would like to add functionality, before starting your work,
please open an issue to discuss the feature you would like to work on.

All development tools can be executed via `make` commands.
All those commands ensure, you use the correct PHP version and the dependencies.
To achieve this, the commands use the [Symfony CLI](https://github.com/symfony-cli/symfony-cli), so please make sure you have it installed.

#### Coding standards

Check coding standards with [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer).

```
make cs
```

also fix common issues with [Rector](https://github.com/rector/rector)

```
make refactoring
```

#### Code Documentation

Document your code with [phpDocumentor](https://github.com/phpDocumentor/phpDocumentor) version 3.

#### Static Analysis

Analyze your code with [PHPStan](https://github.com/phpstan/phpstan).

```
make static-code-analysis
```

#### Test

Cover your code with tests and run [PHPUnit](https://github.com/sebastianbergmann/phpunit), which is already in `require-dev`

```
./vendor/bin/phpunit tests
```
