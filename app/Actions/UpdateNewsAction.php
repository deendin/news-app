<?php

namespace App\Actions;

use App\Models\News;

class UpdateNewsAction
{
    /**
     * Updates the news.
     * 
     * @param \App\Models\News $news
     * @param array $data
     */
    public function update(News $news, array $data) : News
    {
        if ( isset($data['title']) ) {

            $news->forceFill([
                'title' => $data['title']
            ]);

        }

        if ( isset($data['content']) ) {

            $news->forceFill([
                'content' => $data['content']
            ]);

        }

        $news->save();

        return $news;
    }
}