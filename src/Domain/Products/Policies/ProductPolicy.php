<?php

namespace Dystore\Api\Domain\Products\Policies;

use Dystore\Api\Domain\Auth\Concerns\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Lunar\Models\Contracts\Product as ProductContract;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(?Authenticatable $user): bool
    {
        return true;
    }

    public function view(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }

    public function create(?Authenticatable $user): bool
    {
        if ($this->isFilamentAdmin($user)) {
            return true;
        }

        return false;
    }

    public function update(?Authenticatable $user, ProductContract $product): bool
    {
        if ($this->isFilamentAdmin($user)) {
            return true;
        }

        return false;
    }

    public function delete(?Authenticatable $user, ProductContract $product): bool
    {
        if ($this->isFilamentAdmin($user)) {
            return true;
        }

        return false;
    }

    public function viewProductAssociations(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }

    public function viewBrand(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }

    public function viewCheapestProductVariant(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }

    public function viewMostExpensiveProductVariant(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }

    public function viewCollections(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }

    public function viewDefaultUrl(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }

    public function viewChannels(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }

    public function viewImages(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }

    public function viewInverseProductAssociations(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }

    public function viewPrices(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }

    public function viewLowestPrice(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }

    public function viewHighestPrice(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }

    public function viewTags(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }

    public function viewThumbnail(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }

    public function viewUrls(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }

    public function viewProductVariants(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }

    public function viewProductOptions(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }

    public function viewProductOptionValues(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }

    public function viewReviews(?Authenticatable $user, ProductContract $product): bool
    {
        return true;
    }
}
