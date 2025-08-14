<?php

namespace Dystore\Api\Base\Enums;

use Filament\Support\Contracts\HasLabel;

enum PurchasableStatus: string implements HasLabel
{
    case ALWAYS = 'always';
    case IN_STOCK = 'in_stock';
    case BACKORDER = 'in_stock_or_on_backorder';

    public function getLabel(): string
    {
        return match ($this) {
            self::ALWAYS => __('dystore::enums.purchasable_status.always'),
            self::IN_STOCK => __('dystore::enums.purchasable_status.in_stock'),
            self::BACKORDER => __('dystore::enums.purchasable_status.in_stock_or_on_backorder'),
        };
    }
}
