<?php

namespace Tests\Feature\Actions;

use App\Actions\CreateNewsAction;
use App\Mail\SendNewsCreatedMail;
use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CreateNewsActionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
    }

    /** @test */
    public function an_email_is_dispatched_when_a_news_is_created()
    {
        $data = News::factory()->make();

        $news = resolve(CreateNewsAction::class)->create(
            $this->user(),
            $data->toArray()
        );

        Mail::assertQueued(SendNewsCreatedMail::class, function (SendNewsCreatedMail $mail) use ($news) {
            expect($mail->news->is($news))->toBeTrue;

            return true;
        });
    }


    /** @test */
    public function given_a_news_it_will_generate_a_new_news_in_the_system()
    {
        $user = $this->user();

        $preparedNews = News::factory()->make();

        expect(News::all())->toHaveCount(0);

        $createdNews = resolve(CreateNewsAction::class)->create($user, $preparedNews->toArray());

        expect(News::all())->toHaveCount(1);
        expect(News::first()->is($createdNews))->toBeTrue;

        expect($createdNews)
            ->title->toEqual($preparedNews->title)
            ->content->toEqual($preparedNews->content)
            ->user_id->toEqual($user->id);
    }

    
}
