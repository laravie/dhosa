Hot Swapping for Laravel Eloquent
==============

[![Build Status](https://travis-ci.org/laravie/dhosa.svg?branch=master)](https://travis-ci.org/laravie/dhosa)
[![Latest Stable Version](https://poser.pugx.org/laravie/dhosa/v/stable)](https://packagist.org/packages/laravie/dhosa)
[![Total Downloads](https://poser.pugx.org/laravie/dhosa/downloads)](https://packagist.org/packages/laravie/dhosa)
[![Latest Unstable Version](https://poser.pugx.org/laravie/dhosa/v/unstable)](https://packagist.org/packages/laravie/dhosa)
[![License](https://poser.pugx.org/laravie/dhosa/license)](https://packagist.org/packages/laravie/dhosa)

Dhosa allows developers to implement hot-swapping capabilities on Eloquent models. This will helps package developer to create a base model and app developer can extends upon the base model while making sure that all the relationship uses the proper model.

## Installation

To install through composer, run the following command from terminal:

    composer require "laravie/dhosa"

## Usages

### Registering Hot-Swap

```php
use Laravie\Dhosa\HotSwap;

HotSwap::register('Orchestra\Model\User');
```

### Overriding Hot-Swap

In the `App\Providers\AppServiceProvider` we can now override the resolution of `User` to `App\User` by adding:

```php
use Laravie\Dhosa\HotSwap;

HotSwap::override('User', 'App\User');
```

### Defining relationship

You can define relationship by using the following code:

```php
use Orchestra\Model\User;

/* ... */

public function user() 
{
    return $this->belongsTo(User::hsFinder());
}
```

### Making queries

```php
use Orchestra\Model\User;

$user = User::hs(); // return instance of App\User

$user = User::hs()->query(); // return a query builder for App\User

$user = User::hsOn('api'); // return a query builder for App\User using `api` db connection.

$user = User::hsOnWriteConnection(); // return a query builder for App\User using write PDO connection.
```

### Helpers methods

```php
use Orchestra\Model\Role;
use Orchestra\Model\User;

$user = User::hsFaker(); // return a faker for App\User

User::hsAliasName(); // return "User"

User::hsFinder(); // return "App\User"

Role::hsFinder(); // return "Orchestra\Model\Role"
```
