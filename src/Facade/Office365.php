<?php

namespace SpaanProductions\Office365\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \SpaanProductions\Office365\Office365
 */
class Office365 extends Facade
{
	protected static function getFacadeAccessor()
	{
		return \SpaanProductions\Office365\Office365::class;
	}
}
