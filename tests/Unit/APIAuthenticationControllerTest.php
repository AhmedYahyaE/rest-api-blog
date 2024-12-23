<?php
// HTTP Tests: https://laravel.com/docs/11.x/http-tests
// Created a .env.testing file to use a separate SQLite "in-memory" database for testing (switched to using the main .env file (using the main database) and the DatabaseTransactions trait to rollback changes in the database after each test to not affect data in the main database)
// Run php artisan migrate --env=testing to migrate the SQLite defined in .env.testing file for testing

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase; // We have to import this class as instructed in Laravel 11 documentation: https://laravel.com/docs/11.x/http-tests
// use Illuminate\Foundation\Testing\RefreshDatabase; // This trait automatically refreshes (empty data) and then migrates database automatically with every "php artisan test" (this trait is recommended to use if you're using a .env.testing file, not .env, meaning you're using a separate SQLite (configure it to be in-memory database) for testing)    // Resetting the Database After Each Test: https://laravel.com/docs/11.x/database-testing#resetting-the-database-after-each-test
use Illuminate\Foundation\Testing\DatabaseTransactions; // This trait automatically rollbacks database after each test (to not affect data in our existing database) (this trait is recommended to use if you're using .env file, not .env.testing, meaning you're using your main database)    // Resetting the Database After Each Test: https://laravel.com/docs/11.x/database-testing#resetting-the-database-after-each-test

class APIAuthenticationControllerTest extends TestCase
{
    // use RefreshDatabase; // This trait automatically refreshes (empty data) and then migrates database automatically with every "php artisan test" (this trait is recommended to use if you're using a .env.testing file, not .env, meaning you're using a separate SQLite (configure it to be in-memory database) for testing)    // Resetting the Database After Each Test: https://laravel.com/docs/11.x/database-testing#resetting-the-database-after-each-test
    use DatabaseTransactions; // This trait automatically rollbacks database after each test (to not affect data in our existing database) (this trait is recommended to use if you're using .env file, not .env.testing, meaning you're using your main database)    // Resetting the Database After Each Test: https://laravel.com/docs/11.x/database-testing#resetting-the-database-after-each-test

    /**
     * A basic unit test example.
     */
    // public function test_example(): void
    // {
    //     $this->assertTrue(true);
    // }



    public function test_user_can_register() {
        $postDataToRegisterAPI = [
            'name'     => 'Test UserTest',
            'email'    => 'my.test@Test.com', // Make sure to use an email which doesn't already exist in the main database
            'password' => '123456'
        ];

        $registerAPIResponse = $this->post('/api/v1/auth/register', $postDataToRegisterAPI); // Make a POST request to this route with the user data to register

        $registerAPIResponse->assertStatus(201); // Assert that the Register API response status is 201 (i.e., Created)
    }

}
