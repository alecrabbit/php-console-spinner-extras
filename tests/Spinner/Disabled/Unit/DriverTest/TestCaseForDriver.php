<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Spinner\Disabled\Unit\DriverTest;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Extras\Driver\Driver;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class TestCaseForDriver extends TestCase
{
    public function getTesteeInstance(
        ?ITimer $timer = null,
        ?IDriverOutput $output = null,
        ?IInterval $initialInterval = null,
        ?IDriverSettings $driverSettings = null,
        ?IObserver $observer = null,
    ): IDriver {
        return
            new Driver(
                output: $output ?? $this->getDriverOutputMock(),
                timer: $timer ?? $this->getTimerMock(),
                initialInterval: $initialInterval ?? $this->getIntervalMock(),
                driverSettings: $driverSettings ?? $this->getDriverSettingsMock(),
                observer: $observer,
            );
    }

    protected function getDriverOutputMock(): MockObject&IDriverOutput
    {
        return $this->createMock(IDriverOutput::class);
    }


    protected function getDriverSettingsMock(): MockObject&IDriverSettings
    {
        return $this->createMock(IDriverSettings::class);
    }
}
