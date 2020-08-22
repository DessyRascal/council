<?php

namespace App\Factory;

use Faker\Factory;

class DefaultFactoryValues
{
    // secret
    private static $password = '$argon2id$v=19$m=65536,t=4,p=1$4cxp9GzUcRZca2ZQahOd/A$hY2UovhLF4OWXjWQQhD3XJJ7PkMTceRoL4YkRp4b3vs';

    public static function getDefaultReplyValues($prefix = null, $overrides = [])
    {
        $faker = Factory::create();

        $merged = array_merge(
            [
                'body' => $faker->paragraph(3, true)
            ],
            $overrides
        );

        if ($prefix) {
            return self::addPrefix($merged, $prefix);
        }

        return $merged;
    }

    public static function getDefaultThreadValues($prefix = null, $overrides = [])
    {
        $faker = Factory::create();

        $merged = array_merge(
            [
                'title' => $faker->words(3, true),
                'body' => $faker->paragraph(3, true),
            ],
            $overrides
        );

        if ($prefix) {
            return self::addPrefix($merged, $prefix);
        }

        return $merged;
    }

    public static function getDefaultUserValues($prefix = null, $overrides = [])
    {
        $faker = Factory::create();

        $merged = array_merge(
            [
                'email' => $faker->email,
                'password' => self::$password,
                'roles' => ['ROLE_USER'],
            ],
            $overrides
        );

        if ($prefix) {
            return self::addPrefix($merged, $prefix);
        }

        return $merged;
    }

    private static function addPrefix($array, $prefix)
    {
        $pre = $prefix . '[';
        $post = ']';

        return array_combine(
            array_map(
                function ($k) use ($pre, $post) {
                    return $pre . $k . $post;
                },
                array_keys($array)
            ),
            $array
        );
    }
}
