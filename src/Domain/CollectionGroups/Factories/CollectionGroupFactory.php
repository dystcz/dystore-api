<?php

namespace Dystore\Api\Domain\CollectionGroups\Factories;

use Lunar\Database\Factories\CollectionGroupFactory as LunarCollectionGroupFactory;

class CollectionGroupFactory extends LunarCollectionGroupFactory
{
    public function definition(): array
    {
        return [
            ...parent::definition(),
        ];
    }
}
