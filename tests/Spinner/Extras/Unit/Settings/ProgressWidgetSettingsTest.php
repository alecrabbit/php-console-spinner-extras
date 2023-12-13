<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Extras\Unit\Settings;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Extras\Settings\Contract\IProgressWidgetSettings;
use AlecRabbit\Spinner\Extras\Settings\ProgressWidgetSettings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ProgressWidgetSettingsTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(ProgressWidgetSettings::class, $settings);
    }

    private function getTesteeInstance(
        IWidgetSettings $first = null,
        IWidgetSettings ...$other,
    ): IProgressWidgetSettings {
        return new ProgressWidgetSettings(
            $first ?? $this->getWidgetSettingsMock(),
            ...$other,
        );
    }

    private function getWidgetSettingsMock(): MockObject&IWidgetSettings
    {
        return $this->createMock(IWidgetSettings::class);
    }

    #[Test]
    public function canGetIdentifier(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertSame(IProgressWidgetSettings::class, $settings->getIdentifier());
    }

    #[Test]
    public function canGetLeadingSpacer(): void
    {
        $frame = $this->getLeadingSpacerMock();

        $first = $this->getWidgetSettingsMock();
        $first
            ->expects(self::once())
            ->method('getLeadingSpacer')
            ->willReturn($frame)
        ;

        $settings = $this->getTesteeInstance(
            $first,
        );

        self::assertSame($frame, $settings->getLeadingSpacer());
    }

    private function getLeadingSpacerMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    #[Test]
    public function canGetTrailingSpacer(): void
    {
        $frame = $this->getTrailingSpacerMock();

        $first = $this->getWidgetSettingsMock();
        $first
            ->expects(self::once())
            ->method('getTrailingSpacer')
            ->willReturn($frame)
        ;

        $settings = $this->getTesteeInstance(
            $first,
        );

        self::assertSame($frame, $settings->getTrailingSpacer());
    }

    private function getTrailingSpacerMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    #[Test]
    public function canGetNullStylePalette(): void
    {
        $first = $this->getWidgetSettingsMock();
        $first
            ->expects(self::once())
            ->method('getStylePalette')
            ->willReturn(null)
        ;

        $settings = $this->getTesteeInstance(
            $first,
        );

        self::assertNull($settings->getStylePalette());
    }

    #[Test]
    public function canGetNullCharPalette(): void
    {
        $first = $this->getWidgetSettingsMock();
        $first
            ->expects(self::once())
            ->method('getCharPalette')
            ->willReturn(null)
        ;

        $settings = $this->getTesteeInstance(
            $first,
        );

        self::assertNull($settings->getCharPalette());
    }

    #[Test]
    public function canGetStylePalette(): void
    {
        $palette = $this->getStylePaletteMock();
        $first = $this->getWidgetSettingsMock();
        $first
            ->expects(self::once())
            ->method('getStylePalette')
            ->willReturn($palette)
        ;

        $settings = $this->getTesteeInstance(
            $first,
        );

        self::assertSame($palette, $settings->getStylePalette());
    }

    private function getStylePaletteMock(): MockObject&IStylePalette
    {
        return $this->createMock(IStylePalette::class);
    }

    #[Test]
    public function canGetCharPalette(): void
    {
        $palette = $this->getCharPaletteMock();
        $first = $this->getWidgetSettingsMock();
        $first
            ->expects(self::once())
            ->method('getCharPalette')
            ->willReturn($palette)
        ;

        $settings = $this->getTesteeInstance(
            $first,
        );

        self::assertSame($palette, $settings->getCharPalette());
    }

    private function getCharPaletteMock(): MockObject&ICharPalette
    {
        return $this->createMock(ICharPalette::class);
    }

    #[Test]
    public function canGetAll(): void
    {
        $first = $this->getWidgetSettingsMock();
        $second = $this->getWidgetSettingsMock();
        $third = $this->getWidgetSettingsMock();
        $settings = $this->getTesteeInstance(
            $first,
            $second,
            $third
        );
        $all = $settings->getAll();
        self::assertInstanceOf(\Generator::class, $all);
        self::assertSame($first, $all->current());
        $all->next();
        self::assertSame($second, $all->current());
        $all->next();
        self::assertSame($third, $all->current());
        $all->next();
        self::assertFalse($all->valid());
    }

    #[Test]
    public function canGetOther(): void
    {
        $first = $this->getWidgetSettingsMock();
        $second = $this->getWidgetSettingsMock();
        $third = $this->getWidgetSettingsMock();
        $settings = $this->getTesteeInstance(
            $first,
            $second,
            $third
        );
        $other = $settings->getOther();
        self::assertInstanceOf(\Generator::class, $other);
        self::assertSame($second, $other->current());
        $other->next();
        self::assertSame($third, $other->current());
        $other->next();
        self::assertFalse($other->valid());
    }
}
