<?php

namespace Tests\Feature\News;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_update_their_news()
    {
        $user = User::factory()->create(
            [
                'name' => 'Nurudeen',
                'email' => 'nurudeen@example.com',
            ]
        );

        $news = News::factory()->create(
            [
                'title' => 'Today\'s Whether Forecast',
                'content' => 'There is going to be a 20-50% chances of it raining today.',
                'user_id' => $user->id
            ]
        );

        $this->asUser($user)
            ->putJson(
                route('api.news.update', ['news' => $news->uuid]),
                [
                    'title' => 'Next week\'s whether forecase',
                    'content' => 'The temprature will drop next week and there is chances of seeing a snow.'
                ]
            )
            ->assertNoContent();

        expect(News::all())->toHaveCount(1);

    
        expect($news->refresh())
            ->title->toEqual('Next week\'s whether forecase')
            ->content->toEqual('The temprature will drop next week and there is chances of seeing a snow.')
            ->user->is($user)->toBeTrue;
    }

    /** @test */
    public function a_guest_cannot_access_the_endpoint()
    {
        $this->putJson(
            route('api.news.update', '80ku3i-9jeuwe89-923jdi9-3iie9'),
            []
        )->assertUnauthorized();
    }

    /**
     * @test
     *
     * @dataProvider successfulInputDataProvider
     */
    public function test__successful_inputs(...$input)
    {
        $news = News::factory()->create(
            [
                'title' => 'Today\'s Whether Forecast',
                'content' => 'There is going to be a 20-50% chances of it raining today.',
            ]
        );

        $this->asUser()
            ->putJson(
                route('api.news.update', ['news' => $news->uuid]),
                ...$input
            )
            ->assertValid()
            ->assertNoContent();
    }

    public function successfulInputDataProvider()
    {
        return [
            [
                'data' => 
                [
                    'title' => 'Loneii', 
                    'content' => 'It\'s happing live at the TV!'
                ],
            ],
        ];
    }
}
