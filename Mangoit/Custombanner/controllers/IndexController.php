<?php

/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Custom banner controller
 */
class Mangoit_Custombanner_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction() 
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}
