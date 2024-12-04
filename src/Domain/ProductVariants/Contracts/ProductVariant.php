<?php

namespace Dystore\Api\Domain\ProductVariants\Contracts;

use Dystore\Api\Base\Contracts\HasAvailability;
use Lunar\Models\Contracts\ProductVariant as LunarProductVariant;
use Spatie\MediaLibrary\HasMedia;

interface ProductVariant extends HasAvailability, HasMedia, LunarProductVariant {}
