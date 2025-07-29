<?php

namespace Icetalker\FilamentTableRepeater\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Icetalker\FilamentTableRepeater\FilamentTableRepeater
 */
class FilamentTableRepeater extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filament-table-repeater';
    }
}
