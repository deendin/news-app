<?php

namespace App\Repositories;

use App\Contracts\Repositories\NewsRepositoryInterface as Contract;
use App\Models\News;

class NewsRepository implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return News::with('user')->latest()->get();
    }

    /**
     * {@inheritdoc}
     */
    public function findById(string $uuid) : News
    {
        $news = News::where('uuid', $uuid)->first();

        abort_unless($news, 404);

        return $news;
    }
}