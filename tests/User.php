<?php
namespace Tests;

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
            'email'=> 'required|email|unique:users,email',
            'age'=> 'required|numeric'
        ];
    }
}