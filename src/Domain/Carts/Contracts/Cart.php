<?php

namespace Dystore\Api\Domain\Carts\Contracts;

use Lunar\Models\Contracts\Cart as LunarCart;

interface Cart extends CurrentSessionCart, LunarCart {}
