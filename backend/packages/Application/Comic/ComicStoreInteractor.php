<?php

declare(strict_types=1);

namespace Packages\Application\Comic;

use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\Domain\Comic\ComicStatus;
use Packages\UseCase\Comic\ComicNotifierInterface;
use Packages\UseCase\Comic\Exception\ComicAlreadyExistsException;
use Packages\UseCase\Comic\Store\ComicStoreRequest;
use Packages\UseCase\Comic\Store\ComicStoreResponse;
use Packages\UseCase\Comic\Store\ComicStoreUseCaseInterface;

class ComicStoreInteractor implements ComicStoreUseCaseInterface
{
    public function __construct(
        private readonly ComicRepositoryInterface $comicRepository,
        private readonly ComicNotifierInterface $comicNotifier
    ) {}

    /**
     * @throws ComicAlreadyExistsException
     */
    public function handle(ComicStoreRequest $request): ComicStoreResponse
    {
        if ($this->doesComicExist($request)) {
            throw new ComicAlreadyExistsException('Comic already exists');
        }
        $comic = $this->createComic($request);
        $this->comicNotifier->notifyStore($comic);

        return new ComicStoreResponse($comic);
    }

    private function doesComicExist(ComicStoreRequest $request): bool
    {
        $comicKey = new ComicKey($request->key);
        $comic = $this->comicRepository->findByKey($comicKey);
        if ($comic === null) {
            return false;
        }

        return true;
    }

    private function createComic(ComicStoreRequest $request): Comic
    {
        $entity = new Comic(
            id: null,
            key: new ComicKey($request->key),
            name: new ComicName($request->name),
            status: ComicStatus::from($request->status)
        );
        $comic = $this->comicRepository->create($entity);

        return $comic;
    }
}
