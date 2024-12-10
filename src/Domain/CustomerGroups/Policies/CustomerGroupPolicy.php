<?php

namespace Dystore\Api\Domain\CustomerGroups\Policies;

use Dystore\Api\Domain\Auth\Concerns\HandlesAuthorization;
use Dystore\Api\Domain\Users\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Lunar\Models\Contracts\CustomerGroup as CustomerGroupContract;

class CustomerGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?Authenticatable $user): bool
    {
        if ($this->isFilamentAdmin($user)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?Authenticatable $user, CustomerGroupContract $customer): bool
    {
        if ($this->isFilamentAdmin($user)) {
            return true;
        }

        return true;
    }

    /**
     * Determine if the given user can create posts.
     */
    public function create(?Authenticatable $user): bool
    {
        if ($this->isFilamentAdmin($user)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?Authenticatable $user, CustomerGroupContract $customer): bool
    {
        if ($this->isFilamentAdmin($user)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?Authenticatable $user, CustomerGroupContract $customer): bool
    {
        if ($this->isFilamentAdmin($user)) {
            return true;
        }

        return false;
    }
}
