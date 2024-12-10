<?php

namespace Dystore\Api\Domain\Storefront\Entities;

use Generator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Lunar\Base\StorefrontSessionInterface;
use Lunar\Managers\StorefrontSessionManager;

class StorefrontStorage
{
    /**
     * @var StorefrontSessionManager
     * */
    private StorefrontSessionInterface $storefrontSession;

    private Collection $storefronts;

    public function __construct()
    {
        $this->storefrontSession = App::make(StorefrontSessionInterface::class);

        $this->storefronts = Collection::make([
            $this->storefrontSession->getSessionKey() => new Storefront(
                $this->storefrontSession->getSessionKey(),
                $this->storefrontSession,
            ),
        ]);
    }

    public function find(string $slug): ?Storefront
    {
        return $this->storefronts->get($slug);
    }

    public function cursor(): Generator
    {
        foreach ($this->storefronts as $key => $storefront) {
            yield $key => $storefront;
        }
    }

    public function all(): array
    {
        return iterator_to_array($this->cursor());
    }

    public function remove(Storefront $storefront): void
    {
        $storefront->storefrontSession->forget();
    }
}
