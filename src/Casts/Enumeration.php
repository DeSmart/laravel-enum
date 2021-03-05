<?php

declare(strict_types=1);

namespace DeSmart\Laravel\Enumeration\Casts;

use DeSmart\Laravel\Enumeration\Enumeration as EnumerationObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Database\Eloquent\SerializesCastableAttributes;
use Illuminate\Database\Eloquent\Model;

class Enumeration implements CastsAttributes, SerializesCastableAttributes
{
    private string $enumClass;

    public function __construct(string $enumClass)
    {
        $this->enumClass = $enumClass;
    }

    /**
     * @param Model $model
     * @param string $key
     * @param string|null $value
     * @param array $attributes
     * @return EnumerationObject|null
     */
    public function get($model, string $key, $value, array $attributes): ?EnumerationObject
    {
        if (is_null($value)) {
            return null;
        }

        return forward_static_call([$this->enumClass, $value]);
    }

    /**
     * @param Model $model
     * @param string $key
     * @param EnumerationObject|string|null $value
     * @param array $attributes
     * @return int|string|null
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if (is_null($value)) {
            return null;
        }

        if (! $value instanceof EnumerationObject) {
            $value = forward_static_call([$this->enumClass, $value]);
        }

        return $value->getValue();
    }

    /**
     * @param Model $model
     * @param string $key
     * @param EnumerationObject $value
     * @param array $attributes
     * @return mixed
     */
    public function serialize($model, string $key, $value, array $attributes)
    {
        return $value->jsonSerialize();
    }
}