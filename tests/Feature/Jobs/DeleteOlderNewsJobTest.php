<?php

namespace Tests\Feature\Jobs;

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteOlderNewsJobTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_deletes_older_news()
    {
        // Prepare and create 5 news that are older than 14 days
        // News::factory(5, ['created_at' => now()->addDays(-14)])->create();
        News::factory(5)->olderNews()->create();
        
        // Delete all news older than 14 days
        \App\Jobs\DeleteOlderNews::dispatch(14);

        /**
         * Finally, make assertion that we don't have any news older than 14 days
         * since we have dispatched a job that is responsible for deleting those news 
         * older than 14days.
         * 
         */
        expect(News::olderRecords(14))->toBeEmpty();
    }
}