<?php
/**
*/ 
class Bootstrap_Carousel_Block_Adminhtml_Carousel extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_carousel';
    $this->_blockGroup = 'carousel';
    $this->_headerText = Mage::helper('carousel')->__('Carousel - Gerenciar Banners');
    $this->_addButtonLabel = Mage::helper('carousel')->__('Adicionar');
    parent::__construct();
  }
}