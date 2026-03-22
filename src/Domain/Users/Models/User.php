<?php

namespace Dystore\Api\Domain\Users\Models;

use Dystore\Api\Domain\Users\Concerns\InteractsWithDystoreApi;
use Dystore\Api\Domain\Users\Contracts\User as UserContract;
use Dystore\Api\Domain\Users\Factories\UserFactory;
use Dystore\Api\Domain\Users\Traits\CanReceiveAuthNotifications;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;
use Lunar\Base\LunarUser as LunarUserContract;
use Lunar\Base\Traits\HasModelExtending;
use Lunar\Base\Traits\LunarUser;
use Lunar\Models\Cart;
use Lunar\Models\Customer;
use Lunar\Models\Order;

class User extends Authenticatable implements LunarUserContract, UserContract
{
    use CanReceiveAuthNotifications;
    use HasFactory;
    use HasModelExtending;
    use InteractsWithDystoreApi;
    use LunarUser;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'password_set',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getTable(): string
    {
        return 'users';
    }

    /**
     * @return MorphOne<Media>
     */
    public function avatar(): MorphOne
    {
        return $this
            ->morphOne(Config::get('media-library.media_model'), 'model')
            ->where('collection_name', 'avatar');
    }

    /**
     * @return BelongsToMany<Customer>
     */
    public function customers(): BelongsToMany
    {
        $prefix = Config::get('lunar.database.table_prefix');

        return $this->belongsToMany(
            Customer::modelClass(),
            "{$prefix}customer_user",
        );
    }

    /**
     * @return HasMany<Cart>
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::modelClass());
    }

    public function latestCustomer(): ?Customer
    {
        return $this
            ->customers()
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * @return HasMany<Order>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::modelClass());
    }

    /**
     * Return a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            ...$this->casts,
            'email_verified_at' => 'datetime',
            'password_set' => 'boolean',
        ];
    }

    /**
     * Get full name attribute.
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->first_name && ! $this->last_name) {
                    return null;
                }

                return implode(' ', array_filter([$this->first_name, $this->last_name]));
            }
        );
    }
}
