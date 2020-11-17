# laravel-validatable
Validate eloquent model before save save

### Install

Require package with Composer:
```
composer require ....
```

### Usage example

Define validation rules and messages on the model itself.

```php
<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Ognjen\Laravel\Validatable;

class User extends Model {
    use Validatable;

    const VALIDATION_MESSAGES = ['age.numeric'=> 'Custom numeric message'];
    protected $fillable = ['name', 'email', 'age'];
    
    protected function getValidationMessages()
    {
        return self::VALIDATION_MESSAGES;
    }

    protected function getValidationRules()
    {
        return [
            'name' => 'required',
            'email'=> 'required|email|unique:users,email',
            'age'=> 'required|numeric'
        ];
    }
}
```

```php
$user = User::create([
    'name' =>'name',
    'email'=>'name@example.com',
    'age' => 66
]);

if ($user->hasValidationErrors())
{
    $user->getValidationErrors();
}  
```

```php
$user = new User();
$user->name = 'name';
$user->email = 'name@example.com';
$user->age = 'not a numeric';

if ($user->save() === false)
{
    $user->getValidationErrors();
}     
```

