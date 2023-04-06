<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\PopulatorService;
use Illuminate\Http\Client\Response;
use App\Repositories\{ComicRepository, AuthorRepository, AuthorComicRepository};
use App\Contracts\PopulatorInterface;
use App\Contracts\ApiInterface;
use App\Models\{Author, Comic, AuthorComic};

class PopulatorServiceTest extends TestCase
{
    public function test_populate()
    {
        $apiResponse = [
            'code' => 200,
            'status' => 'Ok',
            'data' => [
                'results' => [
                    [
                        'id' => 13970,
                        'firstName' => 'Emilio',
                        'middleName' => '',
                        'lastName' => 'Aguinaldo',
                        'suffix' => '',
                        'fullName' => 'Emilio Aguinaldo',
                        'modified' => '2019-12-11T17:10:07-0500',
                        'thumbnail' => [
                            'path' => 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available',
                            'extension' => 'jpg'
                        ]
                    ]
                ]
            ]
        ];

        $responseMock = $this->getMockBuilder(Response::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['json'])
            ->getMock();

        $responseMock->expects($this->once())
            ->method('json')
            ->willReturn([$apiResponse]);

        $apiService = $this->getApiServiceMock();
        $apiService->expects($this->once())
            ->method('getCreators')
            ->willReturn($responseMock);

        $authorRepository = $this->getAuthorRepositoryMock();
        $authorRepository->expects($this->any())
            ->method('findWhereFirst')
            ->willReturn(null);

        $author = new Author;
        $author->id = 123;
        $author->external_id = 13970;
        $author->first_name = 'F name';
        $author->last_name = 'Test';
        $author->thumbnail_url = 'testurl';

        $authorRepository->method('create')
            ->willReturnOnConsecutiveCalls($author);

        $comicApiResponse = [
            'code' => 200,
            'status' => 'Ok',
            'data' => [
                'results' => [
                    [
                        'id' => 255,
                        'title' => 'Comic title',
                        'series' => ['name' => 'Friends Season 1'],
                        'description' => 'Friends The one with ICe Cream',
                        'page_count' => 100,
                        'thumbnail' => [
                            'path' => 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available',
                            'extension' => 'jpg'
                        ]
                    ]
                ]
            ]
        ];

        $comicResponseMock = $this->getMockBuilder(Response::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['json'])
            ->getMock();

        $comicResponseMock
            ->method('json')
            ->willReturnOnConsecutiveCalls([$comicApiResponse]);

        $apiService->method('getCreatorComics')
            ->willReturnOnConsecutiveCalls($comicResponseMock);

        $comic = new Comic;
        $comic->id = 456;
        $comic->external_id = 255;
        $comicRepository = $this->getComicRepositoryMock();
        $comicRepository->method('create')
            ->willReturnOnConsecutiveCalls($comic);
    
        $populator = $this->getInstance([
            'apiService' => $apiService,
            'authorRepository' => $authorRepository,
            'comicRepository' => $comicRepository
        ]);

        $populator->populate();
    }

    private function getInstance(array $defaulst = [])
    {
        $apiService = array_key_exists('apiService', $defaulst)
            ? $defaulst['apiService']
            : $this->getApiServiceMock();

        $comicRepository = array_key_exists('comicRepository', $defaulst)
            ? $defaulst['comicRepository']
            : $this->getComicRepositoryMock();
        
        $authorRepository = array_key_exists('authorRepository', $defaulst)
            ? $defaulst['authorRepository']
            : $this->getAuthorRepositoryMock();

        $authorComicRepository = array_key_exists('authorComicRepository', $defaulst)
            ? $defaulst['authorComicRepository']
            : $this->getAuthorComicRepositoryMock();

        return new PopulatorService(
            $apiService,
            $comicRepository,
            $authorRepository,
            $authorComicRepository
        );
    }

    private function getApiServiceMock()
    {
        return $this->getMockBuilder(ApiInterface::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['buildUrl'])
            ->addMethods(['getCreators', 'getCreatorComics'])
            ->getMock();
    }

    private function getComicRepositoryMock()
    {
        return $this->getMockBuilder(ComicRepository::class)
            ->onlyMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function getAuthorRepositoryMock()
    {
        return $this->getMockBuilder(AuthorRepository::class)
            ->onlyMethods(['findWhereFirst', 'create'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function getAuthorComicRepositoryMock()
    {
        return $this->getMockBuilder(AuthorComicRepository::class)
            ->onlyMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();
    }
}
