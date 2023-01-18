<?php

namespace Tests\Feature\News;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_delete_a_news_from_their_existing_news()
    {
        $user = User::factory()->withNews()->create();

        $this->asUser($user)
            ->deleteJson(route('api.news.destroy', $user->news->first()->uuid))
            ->assertNoContent();

        // after successful deletion, lets check if the user still has any news.
        // they shouldn't have any single news since we've deleted the created news.
        expect($user->news()->count())->toBe(0);
    }

    /** @test */
    public function a_guest_cannot_delete_a_news()
    {
        $this->deleteJson(route('api.news.destroy', 1))
            ->assertUnauthorized();
    }

}
