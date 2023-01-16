<?php

namespace Tests;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected User $user;

    /**
     * Mocks and acts like a user.
     * 
     * @param $user
     * 
     */
    protected function asUser($user = null)
    {
        $this->actingAs($this->user($user), 'web');

        return $this;
    }

    /**
     * Creates a user user factory.
     * 
     * @param $user
     * 
     */
    protected function user($user = null) : User
    {
        return $this->user ?? match (true) {
            $user instanceof User => $user,
            $user instanceof UserFactory => $user->create(),
            default => User::factory()->create($user ?? [])
        };
    }
}
