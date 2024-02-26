<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\CustomCharPalette;
use AlecRabbit\Spinner\Core\Palette\CustomStylePalette;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Core\StyleSequenceFrame;
use AlecRabbit\Spinner\Extras\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Facade;
use Faker\Factory as FakerFactory;

use function AlecRabbit\WCWidth\wcswidth;

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
                new ArrayObject([
                    new StyleSequenceFrame("\e[41;1;5m  %s  \e[0m", 4),
                ]),
            );

        $charPalette =
            new CustomCharPalette(
                new ArrayObject([
                    new CharSequenceFrame('Error', 5),
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
                            new ArrayObject([
                                new CharSequenceFrame($message, wcswidth($message)),
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

$loop->repeat(
    1,
    static function () use ($errorState, $loop): void {
        if (random_int(0, 1000) > 950) {
            $message = FakerFactory::create()->sentence(); // random error message
            $errorState(
                sprintf(
                    '%s: %s',
                    (new DateTimeImmutable())->format(DATE_ATOM),
                    $message
                )
            );
            $loop->delay(
                10, // delay before reset
                static function () use ($errorState) {
                    $errorState(null);
                }
            );
        }
    }
);
