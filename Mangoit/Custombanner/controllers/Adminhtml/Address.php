<?php

/**
 * @category    Mangoit
 * @package     Mangoit_Suppliers
 * Model to split shipping
 */

class Mangoit_Suppliers_Model_Quote_Address extends Mage_Sales_Model_Quote_Address
{
    public $shipCombinations;
    /**
     * @var Sprout_MultipleShipOrigin_Model_Multipleshiporigin_Quote
     */
    protected $_multipleShipQuote = null;
    public $itemId;
    public $shippingPrice;
    public $itemss = array();
    
    /**
     * @note: mimic behavior of Mage_Sales_Model_Quote_Address->collectShippingRates()
     */
    public function setQuote(Mage_Sales_Model_Quote $quote)
    {
        $this->_quote = $quote;
        $this->setQuoteId($quote->getId());
        return $this;
    }
    /**
     * Retrieve quote object
     *
     * @return Mage_Sales_Model_Quote
     */
    public function getQuote()
    {
        /**
         *  if the calling object actively set the quote to use, then use it.
         */
        if (isset($this->_quote)) {
            return $this->_quote;
        }

        $request = Mage::app()->getRequest();
        $moduleName = strtolower(trim($request->getModuleName()));
        $controllerName = strtolower(trim($request->getControllerName()));
        if ($moduleName == "checkout") {
            //2. get quote data of in session (frontend)
            $checkout = Mage::getSingleton('checkout/session');
            return $checkout->getQuote();
        } else if ($moduleName == "admin" && $controllerName == "sales_order_create") {
            //3. in admin, at create order.
            $session = Mage::getSingleton('adminhtml/session_quote');
            return $session->getQuote();
        }

        return false;
    }
    
    protected function collectShippingRatesForOneShipCombination(&$shipCombination, &$shippingPrices)
    {
        $this->setCollectShippingRates(false);
        $this->removeAllShippingRates();   
        $request = Mage::getModel('shipping/rate_request');
        $request->setAllItems($shipCombination->items);
        $quote=Mage::getModel('checkout/session')->getQuote();
        $shippingMethod = $quote->getShippingAddress();
        $costAmount=$shippingMethod['shipping_amount'];
        $items = Mage::getSingleton('checkout/session')->getQuote()->getAllItems();
        $weight = 0;
        foreach ($items as $item) {
            $weight += ($item->getWeight() * $item->getQty()) ;
        }

        foreach ($shipCombination->items as $item) {
            $itemId = $item->getItemId();
            $rowWeight = $item->getRowWeight();
        }

        /* skip this step for normal product (without assigned ship origin) */
        if ($shipCombination->shipCarrier != Mangoit_Suppliers_Model_Suppliers_Quote::SHIP_CARRIER_ALL) {
            $request
                ->setOrigCountry($shipCombination->countryCode)
                ->setOrigRegionCode($shipCombination->regionCode)
                ->setOrigPostcode($shipCombination->zip);
        }

        $request->setDestCountryId($this->getCountryId());
        $request->setDestRegionId($this->getRegionId());
        $request->setDestRegionCode($this->getRegionCode());
        /**
         * need to call getStreet with -1
         * to get data in string instead of array
         */
        $request->setDestStreet($this->getStreet(-1));
        $request->setDestCity($this->getCity());
        $request->setDestPostcode($this->getPostcode());
        $request->setPackageValue($shipCombination->subTotal);
        $request->setPackageValueWithDiscount($shipCombination->subTotal);
        $request->setPackageWeight($shipCombination->weight);
        $request->setPackageQty($shipCombination->itemQty);
        /**
         * @note : in Mage_Sales_Model_Quote_Address_Total_Shipping->collect():
         * freeMethodWeight = weight.
         */
        $request->setFreeMethodWeight($shipCombination->freeMethodWeight);
        $request->setStoreId($this->getQuote()->getStore()->getId());
        $request->setWebsiteId($this->getQuote()->getStore()->getWebsiteId());
        $request->setFreeShipping($this->getFreeShipping());     
        /**
         * Currencies need to convert in free shipping
         */
        $request->setBaseCurrency($this->getQuote()->getStore()->getBaseCurrency());
        $request->setPackageCurrency($this->getQuote()->getStore()->getCurrentCurrency());
        $request->setShipCarrierForShipCombination($shipCombination->shipCarrier);
        $result = Mage::getModel('shipping/shipping')
            ->collectShippingRates($request)
            ->getResult();   
        if ($result) {
            $shippingRates = $result->getAllRates();
            foreach ($shippingRates as $shippingRate) {
                $rate = Mage::getModel('sales/quote_address_rate')
                    ->importShippingRate($shippingRate); 
                $shippingPrice = $rate->price;
            } 
        }

        if ($shipCombination->shipCarrier != 'flatrate') {
            $shippingPrices[$itemId] = number_format(($rowWeight * $costAmount)/$weight, 2, '.', '');
        } else {
            $shippingPrices[$itemId] = $shippingPrice;
        }

        return $this;        
    }
    /**
     * @note: mimic the logic from 
     * Mage_Checkout_Block_Onepage_Shipping_Method_Available::getShippingRates()
     */
    public function collectShippingRatesForMultipleShipCombinations()
    {
        $this->shipCombinations = $this->getMultipleShipOriginQuote()->buildShipCombinations();
        $shippingPrices = array();
        foreach ($this->shipCombinations as &$shipCombination) {
            $this->collectShippingRatesForOneShipCombination($shipCombination, $shippingPrices); 
        }

        return $shippingPrices;
    }  
    /**
     * Get multiple ship data of current checkout
     */
    public function getMultipleShipOriginQuote()
    {
        if (!isset($this->_multipleShipQuote)) {
            $this->_multipleShipQuote = Mage::getModel("suppliers/suppliers_quote");
        }

        $this->_multipleShipQuote->setQuote($this->getQuote());                
        return $this->_multipleShipQuote;
    }    
}
