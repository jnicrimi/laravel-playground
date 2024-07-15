<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

use Illuminate\Support\Facades\Lang;
use Packages\Domain\EnumArrayable;
use Packages\Domain\EnumMatchable;

enum ComicStatus: string
{
    use EnumArrayable;
    use EnumMatchable;

    case PUBLISHED = 'published';
    case DRAFT = 'draft';
    case CLOSED = 'closed';

    public function description(): string
    {
        return match ($this) {
            self::PUBLISHED => Lang::get('comic/status.description.published'),
            self::DRAFT => Lang::get('comic/status.description.draft'),
            self::CLOSED => Lang::get('comic/status.description.closed'),
        };
    }
}
