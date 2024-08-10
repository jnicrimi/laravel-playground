<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Store;

interface ComicStoreUseCaseInterface
{
    public function handle(ComicStoreRequest $request): ComicStoreResponse;
}
