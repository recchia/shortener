<?php

namespace App\Model;

use App\Contract\Clock;
use Exception;

class SystemClock implements Clock
{
    private string $timezone;

    public function __construct(string $timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @throws Exception
     */
    public function currentTime(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('now', new \DateTimeZone($this->timezone));
    }
}