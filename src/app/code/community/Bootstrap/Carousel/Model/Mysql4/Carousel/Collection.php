<?php
/**
*/ 
class Bootstrap_Carousel_Model_Mysql4_Carousel_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('carousel/carousel');
    }
}