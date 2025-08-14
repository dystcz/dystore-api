<?php

namespace Dystore\Api\Base\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PublishedStatus: string implements HasColor, HasIcon, HasLabel
{
    case PUBLISHED = 'published';
    case DRAFT = 'draft';
    case HIDDEN = 'hidden';

    public function getLabel(): string
    {
        return match ($this) {
            self::PUBLISHED => __('dystore::enums.published_status.published'),
            self::DRAFT => __('dystore::enums.published_status.draft'),
            self::HIDDEN => __('dystore::enums.published_status.hidden'),
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PUBLISHED => 'success',
            self::DRAFT => 'warning',
            self::HIDDEN => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::PUBLISHED => 'heroicon-o-check-circle',
            self::DRAFT => 'heroicon-o-pencil',
            self::HIDDEN => 'heroicon-o-eye-slash',
        };
    }
}
