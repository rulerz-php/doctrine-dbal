# Doctrine DBAL compilation target for RulerZ [![Build Status](https://travis-ci.org/rulerz-php/doctrine-dbal.svg?branch=master)](https://travis-ci.org/rulerz-php/doctrine-dbal)

Doctrine DBAL compilation target for [RulerZ](https://github.com/K-Phoen/rulerz).

Usage
-----

[Doctrine DBAL](https://www.doctrine-project.org/projects/dbal.html) is one of the targets supported by RulerZ.

This cookbook will show you how to retrieve records using Doctrine DBAL and RulerZ.

Here is a summary of what you will have to do:

 * [configure Doctrine DBAL](#configure-doctrine-dbal);
 * [configure RulerZ](#configure-rulerz);
 * [filter your target](#filter-your-target).

### Configure Doctrine DBAL

This subject won't be directly treated here. You can either follow the [official
documentation](https://www.doctrine-project.org/projects/doctrine-dbal/en/2.8/index.html) or use a
bundle/module/whatever the framework you're using promotes.

### Configure RulerZ

Once Doctrine DBAL is installed and configured we can the RulerZ engine:

```php
$rulerz = new RulerZ(
    $compiler, [
        new \RulerZ\DoctrineDBAL\Target\DoctrineDBAL(), // this line is Doctrine DBAL-specific
        // other compilation targets...
    ]
);
```

The only Doctrine DBAL-related configuration is the `DoctrineDBAL` target being added to the list
of the known compilation targets.

### Filter your target

Now that both the DBAL and RulerZ are ready, you can use them to retrieve data.

The `DoctrineDBAL` instance that we previously injected into the RulerZ engine
only knows how to use `Doctrine\DBAL\Query\QueryBuilder` so the first step
is to create one and configure it:

```php
$connection = DriverManager::getConnection([/** connection parameters */]);
$queryBuilder = $connection->createQueryBuilder();

$queryBuilder
    ->select('pseudo', 'gender', 'points')
    ->from('players');
```

And as usual, we call RulerZ with our target (the `QueryBuilder` object) and our rule.
RulerZ will build the right executor for the given target and use it to filter
the data, or in our case to retrieve data from a database.

```php
$rule  = 'gender = :gender and points > :points';
$parameters = [
    'points' => 30,
    'gender' => 'M',
];

var_dump(
    iterator_to_array($rulerz->filter($queryBuilder, $rule, $parameters))
);
```

That's it!

License
-------

This library is under the [MIT](LICENSE) license.
