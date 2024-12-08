<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Трейт UserTrait
 *
 * Предоставляет связь с моделью пользователя.
 *
 * @package App\Traits
 */
trait UserTrait
{
    /**
     * Связь "принадлежит" с моделью User.
     *
     * Этот метод определяет связь текущей модели с пользователем,
     * где текущая модель ссылается на пользователя через внешний ключ.
     *
     * @return BelongsTo Объект отношения "принадлежит".
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
