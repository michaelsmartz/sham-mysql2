<?php


namespace App\Enums;

use BenSampo\Enum\Enum;

final class EventType extends Enum
{
    //event types
    const Leave      = 0;
    const Interview  = 1;

    //events for manager only
    const manager_only = 1;

}
