<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\Palette\CustomCharPalette;
use AlecRabbit\Spinner\Extras\Palette\CustomStylePalette;
use Faker\Factory as FakerFactory;

require_once __DIR__ . '/../bootstrap.async.php';

$spinner = Facade::createSpinner();

$errorState =
    static function (?string $message = null) use ($spinner) {
        static $error = null;

        if ($error instanceof IWidgetComposite) {
            $spinner->remove($error->getContext());
            $error = null;
            return;
        }

        if ($message === null) {
            return;
        }

        $stylePalette =
            new CustomStylePalette(
                frames: new \ArrayObject([
                    new StyleFrame("\e[41;1m  %s  \e[0m", 4),
                    new StyleFrame("\e[1m  %s  \e[0m", 4),
                ]),
                options: new PaletteOptions(interval: 200),
            );

        $charPalette =
            new CustomCharPalette(
                new \ArrayObject([
                    new CharFrame('>>> Error <<<', 13),
                ]),
            );

        $widgetFactory = Facade::getWidgetFactory();

        /** @var IWidgetComposite $error */
        $error =
            $widgetFactory
                ->usingSettings(
                    new WidgetSettings(
                        stylePalette: $stylePalette,
                        charPalette: $charPalette,
                    ),
                )
                ->create()
        ;

        /** @var IWidgetComposite $errorMessage */
        $errorMessage =
            $widgetFactory
                ->usingSettings(
                    new WidgetSettings(
                        charPalette: new CustomCharPalette(
                            new \ArrayObject([
                                new CharFrame($message, \AlecRabbit\WCWidth\wcswidth($message)),
                            ]),
                        ),
                    ),
                )
                ->create()
        ;

        $error->add($errorMessage->getContext());

        $spinner->add($error->getContext());
    };

$loop = Facade::getLoop();

$loop->delay(
    7, // delay before error
    static function () use ($errorState, $loop): void {
        $errorState(
            sprintf(
                '%s: %s',
                (new DateTimeImmutable())->format(DATE_ATOM),
                FakerFactory::create()->sentence() // random error message
            )
        );
        $loop->delay(
            10, // delay before reset
            static function () use ($errorState) {
                $errorState(null);
            }
        );
    }
);

$loop->delay(
    40, // delay before exit
    static function () use ($loop): void {
        Facade::getDriver()->finalize();
        $loop->stop();
    }
);
