<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class GlobalHelpers
{
    /**
     * @param  string  $case  The case transformation method from \Illuminate\Support\Str.
     */
    public static function recursiveChangeCaseKeys(array $array, string $case)
    {
        throw_unless(method_exists(Str::class, $case), new \InvalidArgumentException("Invalid case method: $case"));

        $result = [];
        foreach ($array as $key => $value) {
            $parsedKey = $key;
            if ($case === 'snake') {
                /**
                 * in case if key is `sp_mandatory_Italian_course` (see capital letter right after underscore)
                 * it will be transformed to `sp_mandatory__italian_course` which is incorrect.
                 * So we need to replace `_` with ` `
                 * and then transform to snake case
                 */
                $parsedKey = (string) $key;
                $parsedKey = Str::replace('_', ' ', $parsedKey);
            }
            $newKey = Str::$case($parsedKey);
            if (is_array($value)) {
                $result[$newKey] = self::recursiveChangeCaseKeys($value, $case);
            } else {
                $result[$newKey] = $value;
            }
        }

        return $result;
    }
}
