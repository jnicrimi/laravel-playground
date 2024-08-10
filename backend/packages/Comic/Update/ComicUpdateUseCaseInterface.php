<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Update;

interface ComicUpdateUseCaseInterface
{
    public function handle(ComicUpdateRequest $request): ComicUpdateResponse;
}
