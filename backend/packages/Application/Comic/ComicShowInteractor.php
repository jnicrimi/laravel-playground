<?php

declare(strict_types=1);

namespace Packages\Application\Comic;

use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;
use Packages\UseCase\Comic\Show\ComicShowRequest;
use Packages\UseCase\Comic\Show\ComicShowResponse;
use Packages\UseCase\Comic\Show\ComicShowUseCaseInterface;

class ComicShowInteractor implements ComicShowUseCaseInterface
{
    public function __construct(private readonly ComicRepositoryInterface $comicRepository) {}

    /**
     * @throws ComicNotFoundException
     */
    public function handle(ComicShowRequest $request): ComicShowResponse
    {
        $comicId = new ComicId($request->id);
        $comic = $this->comicRepository->find($comicId);
        if ($comic === null) {
            throw new ComicNotFoundException('Comic not found');
        }

        return new ComicShowResponse($comic);
    }
}
