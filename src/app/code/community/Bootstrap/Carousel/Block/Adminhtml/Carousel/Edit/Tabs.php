<?php
/**
*/ 
class Bootstrap_Carousel_Block_Adminhtml_Carousel_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('carousel_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('carousel')->__('Informações'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('carousel')->__('Informações'),
          'title'     => Mage::helper('carousel')->__('Informações'),
          'content'   => $this->getLayout()->createBlock('carousel/adminhtml_carousel_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}