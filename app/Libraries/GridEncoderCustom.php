<?php
/**
 * @file
 * JqGrid Render Facade.
 *
 * All LaravelJqGrid code is copyright by the original authors and released under the MIT License.
 * See LICENSE.
 */

//namespace Mgallegos\LaravelJqgrid\Facades;
namespace App\Libraries;
use Illuminate\Support\Facades\Facade;

class GridEncoderCustom extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'App\Libraries\RequestedDataInterfaceCustom'; }

}
