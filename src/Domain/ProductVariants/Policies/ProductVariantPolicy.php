<?php

namespace Dystore\Api\Domain\ProductVariants\Policies;

use Dystore\Api\Domain\Auth\Concerns\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Lunar\Models\Contracts\ProductVariant as ProductVariantContract;

class ProductVariantPolicy
{
    use HandlesAuthorization;

    public function viewAny(?Authenticatable $user): bool
    {
        return true;
    }

    public function view(?Authenticatable $user, ProductVariantContract $variant): bool
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

    public function update(?Authenticatable $user, ProductVariantContract $variant): bool
    {
        if ($this->isFilamentAdmin($user)) {
            return true;
        }

        return false;
    }

    public function delete(?Authenticatable $user, ProductVariantContract $variant): bool
    {
        if ($this->isFilamentAdmin($user)) {
            return true;
        }

        return false;
    }

    public function viewDefaultUrl(?Authenticatable $user, ProductVariantContract $variant): bool
    {
        return true;
    }

    public function viewImages(?Authenticatable $user, ProductVariantContract $variant): bool
    {
        return true;
    }

    public function viewOtherProductVariants(?Authenticatable $user, ProductVariantContract $variant): bool
    {
        return true;
    }

    public function viewPrices(?Authenticatable $user, ProductVariantContract $variant): bool
    {
        return true;
    }

    public function viewLowestPrice(?Authenticatable $user, ProductVariantContract $variant): bool
    {
        return true;
    }

    public function viewHighestPrice(?Authenticatable $user, ProductVariantContract $variant): bool
    {
        return true;
    }

    public function viewProduct(?Authenticatable $user, ProductVariantContract $variant): bool
    {
        return true;
    }

    public function viewProductOptionValues(?Authenticatable $user, ProductVariantContract $variant): bool
    {
        return true;
    }

    public function viewThumbnail(?Authenticatable $user, ProductVariantContract $variant): bool
    {
        return true;
    }

    public function viewUrls(?Authenticatable $user, ProductVariantContract $variant): bool
    {
        return true;
    }

    public function viewReviews(?Authenticatable $user, ProductVariantContract $variant): bool
    {
        return true;
    }
}
