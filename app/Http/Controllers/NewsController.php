<?php

namespace App\Http\Controllers;

use App\Actions\CreateNewsAction;
use App\Actions\DeleteNewsAction;
use App\Actions\UpdateNewsAction;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Http\Resources\NewsCollection;
use App\Http\Resources\NewsResource;
use App\Repositories\NewsRepository;

class NewsController extends Controller
{
    /**
     * Constructor
     * 
     * @param NewsRepository $newsRepository
     * 
     */
    public function __construct(
        public readonly NewsRepository $newsRepository,
    ) {
    }

    /**
     * Returns all news.
     * 
     */
    public function index()
    {
        return (new NewsCollection($this->newsRepository->findAll()))
                ->response()
                ->setStatusCode(200);
    }

    /**
     * Create a new news
     * 
     * @param App\Http\Requests\StoreNewsRequest $request
     */
    public function store(StoreNewsRequest $request)
    {
        $action = app(CreateNewsAction::class);

        $data = $action->create($request->user(), $request->all());

        return (new NewsResource($data))->response()->setStatusCode(201);
    }

    /**
     * Updates a news
     * 
     * @param App\Http\Requests\UpdateNewsRequest $request
     * @param string $newsId
     * 
     * @todo - validate news exist before updating.
     * @todo - validate user has permission to update the news.
     * @todo - probably add a NewsPolicy?
     */
    public function update(UpdateNewsRequest $request, $newsId)
    {
        $news = $this->newsRepository->findById($newsId);

        $action = app(UpdateNewsAction::class);

        $data = $action->update($request->user(), $news, $request->all());

        return (new NewsResource($data))->response()->setStatusCode(204);
    }

    /**
     * Fetches a single news
     * 
     * @param string $newsId
     * @todo - validate user has permission to view the news.
     * @todo - probably add a NewsPolicy?
     */
    public function show($newsId)
    {
        $news = $this->newsRepository->findById($newsId);

        return (new NewsResource($news))->response()->setStatusCode(200);
    }

    /**
     * Deletes a news
     * 
     * @param string $newsId
     * @todo - validate user has permission to delete the news.
     * @todo - probably add a NewsPolicy?
     */
    public function delete($newsId)
    {
        $news = $this->newsRepository->findById($newsId);

        $action = app(DeleteNewsAction::class);

        $action->delete($news);

        return response()->json(['data' => [], 'status' => 'Resource deleted successfully'], 204);
    }
}
