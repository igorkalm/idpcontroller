<?php

namespace Igorkalm\IDPcontroller;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Igorkalm\IDPcontroller\Skeleton\SkeletonClass
 */
class IDPcontrollerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'idpcontroller';
    }
}
