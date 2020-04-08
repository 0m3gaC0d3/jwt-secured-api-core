<?php

/**
 * MIT License
 *
 * Copyright (c) 2020 Wolf Utz<wpu@hotmail.de>
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

namespace OmegaCode\JwtSecuredApiCore\Factory\Route;

use Exception;
use OmegaCode\JwtSecuredApiCore\Route\Configuration;
use Psr\Container\ContainerInterface;

class ConfigurationFactory
{
    public static function build(ContainerInterface $container, array $configuration): Configuration
    {
        $service = trim((string) $configuration['action']);
        if (!$container->has($service)) {
            throw new Exception("Could not find controller service with id: $service");
        }
        $name = trim((string) $configuration['name']);
        $action = $container->get($service);
        $route = trim((string) $configuration['route']);
        $methods = (array) $configuration['methods'];
        $middlewares = (array) ($configuration['middlewares'] ?? []);

        return new Configuration($name, $action, $route, $methods, $middlewares);
    }
}