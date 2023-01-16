<?php

namespace Tests\Feature\News;

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsStoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * This test seems to be a stubborn one.
     * 
     * If it accidentally fails, run php artisan optimize or 
     * 
     * php artisan optimize:clear.
     * 
     */

    /** @test */
    public function an_authenticated_user_can_create_a_new_news()
    {
        $user = $this->user(['email' => 'nurudeen@gmail.com']);

        $data = [
            'title' => 'Breaking News',
            'content' => 'This is a sample news content',
        ];

        $this->asUser($user)
            ->postJson(route('api.news.store'), $data)
            ->assertCreated();
        
        expect(News::all())->toHaveCount(1);

        expect(News::find(1))
            ->user->is($user)->toBeTrue
            ->content->toEqual($data['content'])
            ->title->toEqual($data['title']);
    }

    /**
     * @dataProvider invalidTitleDataProvider
     *
     * @test
     */
    public function the_title_must_be_valid($title)
    {
        $this->asUser()
            ->postJson(route('api.news.store'), ['title' => $title])
            ->assertJsonValidationErrors('title');

        expect(News::all())->toHaveCount(0);
    }

    public function invalidTitleDataProvider()
    {
        return [
            'null values' => [null],
            'empty values' => [''],
            'float values' => [3.0],
        ];
    }

    /**
     * @dataProvider invalidContentDataProvider
     *
     * @test
     */
    public function the_content_must_be_valid($content)
    {
        $this->asUser()
            ->postJson(route('api.news.store'), ['content' => $content])
            ->assertJsonValidationErrors('content');

        expect(News::all())->toHaveCount(0);
    }

    public function invalidContentDataProvider()
    {
        return [
            'null values' => [null],
            'empty values' => [''],
            'float values' => [4.4],
        ];
    }
}
