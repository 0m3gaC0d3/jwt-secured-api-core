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

namespace OmegaCode\JwtSecuredApiCore\Generator;

use Psr\Http\Message\ServerRequestInterface;

class RequestIDGenerator implements RequestIDGeneratorInterface
{
    public const PREFIX = 'request.';

    public static function generate(ServerRequestInterface $request): string
    {
        $serializedClaims = serialize(self::getIDClaims($request));
        $identifier = static::PREFIX . md5(self::removeSpacesAndLowerCaseClaim($serializedClaims));

        return $identifier;
    }

    private static function getIDClaims(ServerRequestInterface $request): array
    {
        if ($request->getMethod() === 'GET') {
            return ['target' => $request->getRequestTarget()];
        }

        return [
            'target' => $request->getRequestTarget(),
            'payload' => $request->getParsedBody(),
        ];
    }

    private static function removeSpacesAndLowerCaseClaim(string $serializedClaim): string
    {
        return str_replace(["\t", "\n", ' '], '', strtolower($serializedClaim));
    }
}
