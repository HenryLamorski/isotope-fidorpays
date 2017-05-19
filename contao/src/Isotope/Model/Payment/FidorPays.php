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

class FidorPays extends Postsale
{
    private $arrPaymentStatus = array();
    
    /**
     * Get the order object in a postsale request
     * @return  IsotopeProductCollection
     */
    public function getPostsaleOrder()
    {
        $arrData     = $this->getPaymentStatus(true);
        file_put_contents("/var/www/contao.log",print_r($arrData,true));
        $checkout_id = $arrData['id'];
        
		//		\Environment::get('base') . Checkout::generateUrlForStep('complete', $objOrder);
		// https://h1.softinterbit.de/public/blechdepot-de/system/modules/isotope/postsale.php?mod=pay&modId=4&id=45557359820A3084CC87ADE3BAED6CAF.sbg-vm-tx01&resourcePath=%2Fv1%2Fcheckouts%2F45557359820A3084CC87ADE3BAED6CAF.sbg-vm-tx01%2Fpayment
        return Order::findOneBy('fidorpays_checkout_id', $checkout_id);
    }
    
    public function getPaymentStatus($blnRefresh=false)
    {
        if(false === $blnRefresh && $this->arrPaymentStatus) {
            return $this->arrPaymentStatus;
        }

        if($this->debug) {
            $url = 'https://test.oppwa.com/v1/checkouts/' . \Input::get('id') . '/payment'; 
        }

        $url .= "?authentication.userId=" . $this->fidorpays_userId;
        $url .= "&authentication.password=" . $this->fidorpays_password;
        $url .= "&authentication.entityId=" . $this->fidorpays_entityId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData,true);
    }

    public function processPostsale(IsotopeProductCollection $objOrder)
    {
        $arrData     = $this->getPaymentStatus();
        

    }

    public function getCheckoutId($objOrder)
    {
           
        if($this->debug) {
            $url = 'https://test.oppwa.com/v1/checkouts'; 
        }
        
        $data = "authentication.userId=" . $this->fidorpays_userId .
		"&authentication.password=" . $this->fidorpays_password .
		"&authentication.entityId=" . $this->fidorpays_entityId .
		"&amount=" . number_format($objOrder->getTotal(),2) .
		"&currency=" . $objOrder->getCurrency() .
		"&paymentType=DB";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        
        curl_close($ch);
        
        $responseData = json_decode($responseData, true);
        $this->saveCheckoutIdToOrder($responseData['id'],$objOrder);
        return $responseData['id'];
    }

    public function saveCheckoutIdToOrder($checkoutId,$objOrder)
    {
        $objOrder->fidorpays_checkout_id = $checkoutId;
        $objOrder->save();
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
        $objTemplate->widgetUrl     = 'https://test.oppwa.com/v1/paymentWidgets.js?checkoutId='.$this->getCheckoutId($objOrder);
        $objTemplate->currency      = $objOrder->getCurrency();
        $objTemplate->fidor_cards   = implode(" ",deserialize($this->fidorpays_cards));
        $objTemplate->return	    = \Environment::get('base') . 'system/modules/isotope/postsale.php?mod=pay&modId=' . $this->id;

        return $objTemplate->parse();
    }


}
