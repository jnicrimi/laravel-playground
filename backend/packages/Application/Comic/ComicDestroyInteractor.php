<?php

declare(strict_types=1);

namespace Packages\Application\Comic;

use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\UseCase\Comic\ComicNotifierInterface;
use Packages\UseCase\Comic\Destroy\ComicDestroyRequest;
use Packages\UseCase\Comic\Destroy\ComicDestroyResponse;
use Packages\UseCase\Comic\Destroy\ComicDestroyUseCaseInterface;
use Packages\UseCase\Comic\Exception\ComicCannotBeDeletedException;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;

class ComicDestroyInteractor implements ComicDestroyUseCaseInterface
{
    public function __construct(
        private readonly ComicRepositoryInterface $comicRepository,
        private readonly ComicNotifierInterface $comicNotifier
    ) {}

    /**
     * @throws ComicNotFoundException
     * @throws ComicCannotBeDeletedException
     */
    public function handle(ComicDestroyRequest $request): ComicDestroyResponse
    {
        $comicId = new ComicId($request->id);
        $comic = $this->comicRepository->find($comicId);
        if ($comic === null) {
            throw new ComicNotFoundException('Comic not found');
        }
        if (! $comic->canDelete()) {
            throw new ComicCannotBeDeletedException('Comic cannot be deleted');
        }
        $this->comicRepository->delete($comic);
        $this->comicNotifier->notifyDestroy($comic);

        return new ComicDestroyResponse($comic);
    }
}
