<?php

/**
 * MIT License
 *
 * Copyright (c) 2021 Wolf Utz<wpu@hotmail.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

declare(strict_types=1);

namespace OmegaCode\JwtSecuredApiCore\Utility;

class StringUtility
{
    public static function snakeCaseToCamelCase(string $subject): string
    {
        $subject = str_replace(' ', '', ucwords(str_replace('_', ' ', $subject)));
        $subject[0] = strtolower($subject[0]);

        return $subject;
    }

    public static function camelCaseToSnakeCase(string $subject): string
    {
        if (preg_match('/[A-Z]/', $subject) === 0) {
            return $subject;
        }

        return strtolower((string) preg_replace_callback('/([a-z])([A-Z])/', function ($matches) {
            return ((string) $matches[1] ?? '') . '_' . strtolower((string) ($matches[2] ?? ''));
        }, $subject));
    }

    /**
     * @param mixed $from
     * @param mixed $to
     */
    public static function strReplaceFirst($from, $to, string $content): string
    {
        $from = '/' . preg_quote($from, '/') . '/';

        return (string) preg_replace($from, $to, $content, 1);
    }
}
