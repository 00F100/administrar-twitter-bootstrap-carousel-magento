<?php
/**
*/ 
class Bootstrap_Carousel_Model_Mysql4_Carousel extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('carousel/carousel', 'carousel_id');
    }
}