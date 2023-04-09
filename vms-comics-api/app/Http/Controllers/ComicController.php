<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repositories\ComicRepository;
use App\Http\Resources\ComicResource;

class ComicController extends BaseController
{
    private ComicRepository $comicRepository;

    public function __construct(
      ComicRepository $comicRepository
    ) {
        $this->comicRepository = $comicRepository;
    }

    public function index(Request $request)
    {
        $results = ComicResource::collection($this->comicRepository->all());
        return response()->json($results);
    }

    public function authorComics(Request $request, int $id)
    {
        $results = ComicResource::collection($this->authorRepository->getAuthorComics($id));
        return response()->json($results);
    }
}
