<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic;

use Packages\Domain\Comic\Comic;

interface ComicNotifierInterface
{
    public function notifyStore(Comic $comic): void;

    public function notifyUpdate(Comic $comic): void;

    public function notifyDestroy(Comic $comic): void;
}
