<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repositories\ComicRepository;

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
        $results = $this->comicRepository->all();
        return response()->json($results);
    }

    public function authorComics(Request $request, int $id)
    {
        $results = $this->authorRepository->getAuthorComics($id);
        return response()->json($results);
    }
}
