<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Show;

interface ComicShowUseCaseInterface
{
    public function handle(ComicShowRequest $request): ComicShowResponse;
}
