<?php

namespace Dystore\Api\Domain\Transactions\Models;

use Dystore\Api\Domain\Transactions\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\Transactions\Contracts\Transaction as TransactionContract;
use Lunar\Models\Transaction as LunarTransaction;

class Transaction extends LunarTransaction implements TransactionContract
{
    use InteractsWithLunarApi;
}
