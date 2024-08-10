<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Index;

interface ComicIndexUseCaseInterface
{
    public function handle(ComicIndexRequest $request): ComicIndexResponse;
}
