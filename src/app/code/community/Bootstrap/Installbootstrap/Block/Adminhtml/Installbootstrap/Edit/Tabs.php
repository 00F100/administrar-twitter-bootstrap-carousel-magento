<?php

class Bootstrap_Installbootstrap_Block_Adminhtml_Installbootstrap_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('installbootstrap_tabs');
      $this->setDestElementId('edit_form');
      //$this->setTitle(Mage::helper('installbootstrap')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('installbootstrap')->__('Configurações Twitter Bootstrap'),
          'title'     => Mage::helper('installbootstrap')->__('Configurações Twitter Bootstrap'),
          'content'   => $this->getLayout()->createBlock('installbootstrap/adminhtml_installbootstrap_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}