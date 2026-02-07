<?php

declare(strict_types=1);

namespace Packages\Application\Comic;

use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\UseCase\Comic\Index\ComicIndexRequest;
use Packages\UseCase\Comic\Index\ComicIndexResponse;
use Packages\UseCase\Comic\Index\ComicIndexUseCaseInterface;
use Packages\UseCase\Comic\Index\ComicSearchQueryBuilderInterface;

class ComicIndexInteractor implements ComicIndexUseCaseInterface
{
    /**
     * @var int
     */
    private const PER_PAGE = 5;

    public function __construct(
        private readonly ComicRepositoryInterface $comicRepository,
        private readonly ComicSearchQueryBuilderInterface $comicSearchQueryBuilder
    ) {}

    public function handle(ComicIndexRequest $request): ComicIndexResponse
    {
        $this->comicSearchQueryBuilder->setKey($request->key)
            ->setName($request->name)
            ->setStatus($request->status);
        $query = $this->comicSearchQueryBuilder->build();
        $comics = $this->comicRepository->paginate($query, self::PER_PAGE);

        return new ComicIndexResponse($comics);
    }
}
