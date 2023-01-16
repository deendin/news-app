<?php

namespace Tests\Feature\News;

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_see_a_single_news()
    {
        $news = News::factory()->create();

        $data = $this->asUser()
            ->getJson(route('api.news.show', $news->uuid))
            ->json('data');

        expect($data)
            ->id->toEqual($news->uuid)
            ->title->toEqual($news->title)
            ->content->toEqual($news->content);
    }

    /** @test */
    public function a_correct_response_is_returned_if_the_news_cannot_be_found()
    {
        $this->asUser()
            ->getJson(route('api.news.show', 'sk'))
            ->assertNotFound();
    }

    /** @test */
    public function a_guest_cannot_see_a_news()
    {
        $news = News::factory()->create();

        $this->getJson(route('api.news.show', $news->id))
            ->assertUnauthorized();
    }

}