<?php
/**
 * Fidor-Payments: all in one Payment Solutions
 *
 * Copyright (c) 2017 Henry Lamorski
 *
 * @package FidorPays
 * @author  Henry Lamorski <henry.lamorski@mailbox.org>
 */


namespace Isotope\Model\Payment;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Haste\Http\Response\Response;
use Isotope\Interfaces\IsotopeProductCollection;
use Isotope\Interfaces\IsotopePurchasableCollection;
use Isotope\Model\Product;
use Isotope\Model\ProductCollection\Order;
use Isotope\Module\Checkout;
use Isotope\Template;

class FidorPays extends Payment
{
    
    public function getCheckoutId($objOrder)
    {
            
        if($this->debug) {
            $url = 'https://test.oppwa.com/v1/checkouts'; 
        }
        
        $data = "authentication.userId=" . $this->fidorpays_userId .
		"&authentication.password=" . $this->fidorpays_password .
		"&authentication.entityId=" . $this->fidorpays_entityId .
		"&amount=" . $objOrder->getTotal() .
		"&currency=" . $objOrder->getCurrency() .
		"&paymentType=DB";
        
        $request = new \Request();
        $request->send($url, $data, 'post');
    
        file_put_contents("/var/www/contao.log","data send: ".print_r($data,true),FILE_APPEND);
             
        if ($request->hasError()) {
            throw new \RuntimeException($request->error);
        }
        
        $json = $request->response;
        $arrData =  json_decode($json, true);
        
        file_put_contents("/var/www/contao.log","result: ".print_r($arrData,true),FILE_APPEND);
        
        return $arrData['id'];
    }
    

    /**
     * Return the paymentform.
     *
     * @param IsotopeProductCollection $objOrder  The order being places
     * @param \Module                  $objModule The checkout module instance
     *
     * @return string
     */
    public function checkoutForm(IsotopeProductCollection $objOrder, \Module $objModule)
    {
        if (!$objOrder instanceof IsotopePurchasableCollection) {
            \System::log('Product collection ID "' . $objOrder->getId() . '" is not purchasable', __METHOD__, TL_ERROR);
            return false;
        }

             /** @var Template|\stdClass $objTemplate */
        $objTemplate = new Template('iso_payment_fidorpays');

        $objTemplate->id            = $this->id;
        $objTemplate->checkoutId    = $this->getCheckoutId($objOrder);
        $objTemplate->widgetUrl     = 'https://test.oppwa.com/v1/paymentWidgets.js';
        $objTemplate->currency      = $objOrder->getCurrency();
        $objTemplate->fidor_cards   = implode(" ",deserialize($this->fidorpays_cards));
        $objTemplate->return        = \Environment::get('base') . Checkout::generateUrlForStep('complete', $objOrder);
        $objTemplate->cancel_return = \Environment::get('base') . Checkout::generateUrlForStep('failed');
        $objTemplate->notify_url    = \Environment::get('base') . 'system/modules/isotope/postsale.php?mod=pay&id=' . $this->id;

        return $objTemplate->parse();
    }


}
