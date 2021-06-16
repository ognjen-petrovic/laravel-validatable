<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class SimpleTest extends TestCase
{

    public function setUp(): void
    {
      parent::setUp();
      Schema::create('users', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('name');
          $table->string('email');
          $table->integer('age');
          $table->timestamps();
      });
    }

    public function test_it_fails()
    {
        $user = new User();
        $user->name = 'name';
        $user->email = 'invalid email';
        $user->age = 66;
        $user->save();
        $errors = $user->getValidationErrors()->toArray();

        $this->assertTrue($user->hasValidationErrors());
        $this->assertArrayHasKey('email', $errors);
    }

    public function test_it_fails_with_custom_message()
    {
        $user = new User();
        $user->name = 'name';
        $user->email = 'name@example.com';
        $user->age = 'not a numeric';
        $user->save();
        $errors = $user->getValidationErrors()->toArray();

        $this->assertTrue($user->hasValidationErrors());
        $this->assertEquals(
            User::VALIDATION_MESSAGES['age.numeric'], 
            $errors['age'][0]);
    }

    public function test_it_pass_without_erros()
    {
        $user = User::create([
            'name' =>'name',
            'email'=>'name@example.com',
            'age' => 66
        ]);

        $this->assertFalse($user->hasValidationErrors());
    }

    public function test_hasValidationErrors_method() {
        $user = new User;
        $user->hasValidationErrors();
        $this->assertTrue(true);
    }
}