<?php
/**
*/ 
class Bootstrap_Carousel_Model_Categoria extends Varien_Object
{
    static public function getOptionArray()
    {
        return array(
            'banner1'    => Mage::helper('carousel')->__('Banner 1'),
            'banner2'    => Mage::helper('carousel')->__('Banner 2'),
            'banner3'    => Mage::helper('carousel')->__('Banner 3'),
            'banner4'    => Mage::helper('carousel')->__('Banner 4'),
            'banner5'    => Mage::helper('carousel')->__('Banner 5'),
            'banner6'    => Mage::helper('carousel')->__('Banner 6'),
            'banner7'    => Mage::helper('carousel')->__('Banner 7'),
            'banner8'    => Mage::helper('carousel')->__('Banner 8'),
            'banner9'    => Mage::helper('carousel')->__('Banner 9'),
            'banner10'   => Mage::helper('carousel')->__('Banner 10'),
        );
    }
}