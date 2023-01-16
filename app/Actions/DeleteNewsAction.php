<?php

namespace App\Actions;

use App\Models\News;

class DeleteNewsAction
{

    /**
     * Deletes the news.
     * 
     */
    public function delete(News $news)
    {
        return $news->delete();
    }
}