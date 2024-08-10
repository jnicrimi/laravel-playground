<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Destroy;

interface ComicDestroyUseCaseInterface
{
    public function handle(ComicDestroyRequest $request): ComicDestroyResponse;
}
