<?php

namespace App\Actions;

use App\Models\News;
use App\Models\User;

class CreateNewsAction
{

    /**
     * Creates the news.
     * 
     * @param \App\Models\User $user
     * @param array $data
     * 
     * @return \App\Models\News
     */
    public function create(User $user, array $data)
    {
        $news = new News();

        $news->title = $data['title'];
        $news->content = $data['content'];
        $news->user_id = $user->id;
        
        $news->save();

        return $news;
    }
}