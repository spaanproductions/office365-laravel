<?php

namespace SpaanProductions\Office365\Facade;

use Illuminate\Support\Facades\Facade;

class Office365 extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \SpaanProductions\Office365\Office365::class;
    }
}
