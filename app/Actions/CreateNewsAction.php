<?php

namespace App\Actions;

use App\Models\News;

class CreateNewsAction
{

    /**
     * Creates the news.
     * 
     * @param array $data
     * 
     * @return \App\Models\News
     */
    public function create(array $data)
    {
        $news = new News();

        $news->title = $data['title'];
        $news->content = $data['content'];
        // hard code the user id for now, untill we have an authentication system.
        // Ideally, this should come from an auth provider - e.g: sancum or jwt
        $news->user_id = 1; 
        
        $news->save();

        return $news;
    }
}