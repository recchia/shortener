<?php

namespace App\Contract;

interface Clock
{
    public function currentTime(): \DateTimeImmutable;

}