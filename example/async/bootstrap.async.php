<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Facade;

// Code in this file is NOT REQUIRED
// and is used only for demonstration convenience.
require_once __DIR__ . '/../bootstrap.php'; // <-- except this line - it is required 🙂

register_shutdown_function(
    static function (): void {
        $driver = Facade::getDriver();

        // Create echo function
        $echo =
            $driver->wrap(
                static function (?string $message = null): void {
                    echo $message . PHP_EOL;
                }
            );

        $loop = Facade::getLoop();

        $echo();
        $echo(sprintf('Using loop: "%s"', get_debug_type($loop)));
        $echo();
    }
);
