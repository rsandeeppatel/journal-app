<?php

namespace App\Interfaces;

/**
 * @property bool $timestamps
 */
interface BaseModelInterface
{
    /**
     * Convert the model's attributes to an json with key in camelCase.
     *
     * @return array
     */
    public  function jsonSerialize(): mixed;
}