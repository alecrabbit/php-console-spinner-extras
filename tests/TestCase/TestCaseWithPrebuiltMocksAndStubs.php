<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Extras\Contract\IAnsiColorParser;
use AlecRabbit\Spinner\Extras\Contract\IStyleToAnsiStringConverter;
use AlecRabbit\Spinner\Extras\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyleOptionsParser;
use AlecRabbit\Spinner\Extras\Factory\Contract\IAnsiColorParserFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\ICharFrameFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleToAnsiStringConverterFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

abstract class TestCaseWithPrebuiltMocksAndStubs extends TestCase
{

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    protected function getObserverMock(): MockObject&IObserver
    {
        return $this->createMock(IObserver::class);
    }

    protected function getCharFrameFactoryMock(): MockObject&ICharFrameFactory
    {
        return $this->createMock(ICharFrameFactory::class);
    }


    protected function getDriverSettingsMock(): MockObject&IDriverSettings
    {
        return $this->createMock(IDriverSettings::class);
    }


    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    protected function getWidthMeasurerMock(): MockObject&IWidthMeasurer
    {
        return $this->createMock(IWidthMeasurer::class);
    }

    protected function getSpinnerMock(): MockObject&ISpinner
    {
        return $this->createMock(ISpinner::class);
    }

    protected function getSpinnerStub(): Stub&ISpinner
    {
        return $this->createStub(ISpinner::class);
    }

    protected function getDriverOutputMock(): MockObject&IDriverOutput
    {
        return $this->createMock(IDriverOutput::class);
    }


    protected function getStyleMock(): MockObject&IStyle
    {
        return $this->createMock(IStyle::class);
    }


    protected function getStyleToAnsiStringConverterMock(): MockObject&IStyleToAnsiStringConverter
    {
        return $this->createMock(IStyleToAnsiStringConverter::class);
    }

    protected function getAnsiColorParserMock(): MockObject&IAnsiColorParser
    {
        return $this->createMock(IAnsiColorParser::class);
    }

    protected function getStyleOptionsParserMock(): MockObject&IStyleOptionsParser
    {
        return $this->createMock(IStyleOptionsParser::class);
    }

    protected function getAnsiColorParserFactoryMock(): MockObject&IAnsiColorParserFactory
    {
        return $this->createMock(IAnsiColorParserFactory::class);
    }


    protected function getStyleToAnsiStringConverterFactoryMock(): MockObject&IStyleToAnsiStringConverterFactory
    {
        return $this->createMock(IStyleToAnsiStringConverterFactory::class);
    }

}
