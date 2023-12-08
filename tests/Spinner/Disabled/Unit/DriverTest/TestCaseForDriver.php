<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Spinner\Disabled\Unit\DriverTest;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Extras\Driver;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;

class TestCaseForDriver extends TestCaseWithPrebuiltMocksAndStubs
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
}