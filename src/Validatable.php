<?php

namespace Ognjen\Laravel;

use Illuminate\Support\MessageBag;

trait Validatable{

    protected MessageBag $validationErrors;

    protected static function bootValidatable()
    {
        static::saving(function($model)
        {
            return $model->validate();
        });
    }

    public function validate(): bool
    {   
        $messages = method_exists($this, 'getValidationMessages') ? $this->getValidationMessages() : [];
        $rules = method_exists($this, 'getValidationRules') ? $this->getValidationRules() : [];
        $validator = \App::make('validator');
        $attributes = $this->attributes;
        if (isset(static::$addidtionalValidationAttributes))
        {
            $attributes = array_merge($attributes, static::$addidtionalValidationAttributes);
        }

        $v = $validator->make($attributes, $rules, $messages);
        if ($v->passes())
        {
            $this->setValidationErrors(new MessageBag);
            return true;
        }

        $this->setValidationErrors($v->messages());

        return false;
    }

    protected function setValidationErrors(MessageBag $errors)
    {
        $this->validationErrors = $errors;
    }

    public function getValidationErrors(): MessageBag
    {
        return $this->validationErrors;
    }

    public function hasValidationErrors(): bool
    {
        return $this->validationErrors->isNotEmpty();
    }
}