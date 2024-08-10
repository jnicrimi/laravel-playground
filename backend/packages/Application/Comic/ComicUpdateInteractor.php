<?php

declare(strict_types=1);

namespace Packages\Application\Comic;

use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\Domain\Comic\ComicStatus;
use Packages\Infrastructure\Notifier\ComicNotifier;
use Packages\UseCase\Comic\Exception\ComicAlreadyExistsException;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;
use Packages\UseCase\Comic\Update\ComicUpdateRequest;
use Packages\UseCase\Comic\Update\ComicUpdateResponse;
use Packages\UseCase\Comic\Update\ComicUpdateUseCaseInterface;

class ComicUpdateInteractor implements ComicUpdateUseCaseInterface
{
    public function __construct(
        private readonly ComicRepositoryInterface $comicRepository,
        private readonly ComicNotifier $comicNotifier
    ) {}

    /**
     * @throws ComicNotFoundException
     * @throws ComicAlreadyExistsException
     */
    public function handle(ComicUpdateRequest $request): ComicUpdateResponse
    {
        $comicId = new ComicId($request->id);
        $entity = $this->comicRepository->find($comicId);
        if ($entity === null) {
            throw new ComicNotFoundException('Comic not found');
        }
        if ($this->isDuplicateKey($entity, $request) === true) {
            throw new ComicAlreadyExistsException('Duplicate key');
        }
        $comic = $this->updateComic($entity, $request);
        $this->comicNotifier->notifyUpdate($comic);

        return new ComicUpdateResponse($comic);
    }

    private function isDuplicateKey(Comic $entity, ComicUpdateRequest $request): bool
    {
        $comicKey = new ComicKey($request->key);
        $ignoreComicId = $entity->getId();
        $comicEntity = $this->comicRepository->findByKey($comicKey, $ignoreComicId);
        if ($comicEntity === null) {
            return false;
        }

        return true;
    }

    private function updateComic(Comic $entity, ComicUpdateRequest $request): Comic
    {
        $entity->changeKey(new ComicKey($request->key));
        $entity->changeName(new ComicName($request->name));
        $entity->changeStatus(ComicStatus::from($request->status));
        $comic = $this->comicRepository->update($entity);

        return $comic;
    }
}
