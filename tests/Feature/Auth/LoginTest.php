<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_login_with_email_and_password()
    {
        $user = $this->createUser()->first();
        $email = $user->email;
        $response = $this->postJson(route('user.login'), [
            'email' => $email,
            'password' => 'testtest',
        ])->assertOk();
        $temp = $response->json();
        $this->assertArrayHasKey('access_token', $response->json());
        $this->assertArrayHasKey('status_code', $response->json());
        $this->assertEquals($temp['status_code'], 200);
    }

    // public function test_if_user_email_is_not_available_then_it_return_error()
    // {
    //     $response = $this->postJson(route('user.login'), [
    //         'email' => 'JerryJerry@Jerry.com',
    //         'password' => 'password',
    //     ])
    //     ->assertOk();
    //     $temp = $response->json();
    //     $this->assertArrayHasKey('status_code', $response->json());
    //     $this->assertArrayHasKey('message', $response->json());
    //     $this->assertEquals($temp['status_code'], 500);
    //     $this->assertEquals($temp['message'], 'Unauthorized');
    // }

    // public function test_it_raise_error_if_password_is_incorrect()
    // {
    //     $user = $this->createUser()->first();

    //     $response = $this->postJson(route('user.login'), [
    //         'email' => $user->email,
    //         'password' => 'random',
    //     ])->assertOk();
    //     $temp = $response->json();
    //     $this->assertArrayHasKey('status_code', $response->json());
    //     $this->assertArrayHasKey('message', $response->json());
    //     $this->assertArrayHasKey('message', $response->json());
    //     $this->assertEquals($temp['status_code'], 500);
    //     $this->assertEquals($temp['message'], 'Unauthorized');
    // }
}
