<?php

namespace Dystore\Api\Base\Concerns;

use Carbon\Carbon;
use Dystore\Api\Base\Enums\PublishedStatus;
use Illuminate\Database\Eloquent\Model;

trait Publishable
{
    public static function bootPublishable(): void
    {
        static::creating(function (Model $model) {
            if ($model->status === PublishedStatus::PUBLISHED && ! $model->published_at) {
                $model->published_at = Carbon::now();

                return;
            }
        });

        static::updating(function (Model $model) {
            if ($model->status === PublishedStatus::PUBLISHED && ! $model->published_at) {
                $model->published_at = Carbon::now();

                return;
            }
        });
    }

    public function initializePublishable(): void
    {
        /** @var Model $this */
        $this->mergeCasts([
            'status' => PublishedStatus::class,
            'published_at' => 'datetime',
        ]);
    }

    public function isPublished(): bool
    {
        /** @var Model $this */
        return $this->status === PublishedStatus::PUBLISHED && $this->published_at <= Carbon::now();
    }
}
