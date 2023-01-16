<?php

namespace App\Contracts\Repositories;

use App\Models\News;

interface NewsRepositoryInterface
{
    /**
     * Finds all of the news.
     * 
     */
    public function findAll();

    /**
     * Find a specific news
     * 
     * @param string $uuid
     * 
     * @return News
     */
    public function findById(string $uuid) : News;

}