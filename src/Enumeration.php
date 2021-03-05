<?php

declare(strict_types=1);

namespace DeSmart\Laravel\Enumeration;

use DeSmart\Laravel\Enumeration\Casts\Enumeration as EnumerationCast;
use Illuminate\Contracts\Database\Eloquent\Castable;

class Enumeration extends \DeSmart\Enum\Enumeration implements Castable
{
    public static function castUsing(array $arguments): EnumerationCast
    {
        return new EnumerationCast(static::class);
    }

    public function serialize(): void
    {
        // There is a potential bug that forces serialize method here and in caster class.
    }
}