<?php
namespace Isotope\Hooks;

class FidorPaysHooks
{
    public function setModuleId($objPostSaleController)
    {
        $objPostSaleController->setModuleId((int) \Input::get('modId'));
        return;
    }
}
