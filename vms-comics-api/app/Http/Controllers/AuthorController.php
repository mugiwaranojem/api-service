<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repositories\AuthorRepository;
use App\Http\Resources\AuthorResource;

class AuthorController extends BaseController
{
    private AuthorRepository $authorRepository;

    public function __construct(
        AuthorRepository $authorRepository
    ) {
        $this->authorRepository = $authorRepository;
    }

    public function index(Request $request)
    {
        $results = AuthorResource::collection($this->authorRepository->all());
        return response()->json($results);
    }

    public function authorComics(Request $request, int $id)
    {
        $results = $this->authorRepository->getAuthorComics($id);
        return response()->json($results);
    }
}
