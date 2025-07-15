<?php

namespace VerifyID\Laravel;

use Illuminate\Support\Facades\Facade;

class VerifyIDFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \VerifyID\VerifyID::class;
    }
}
