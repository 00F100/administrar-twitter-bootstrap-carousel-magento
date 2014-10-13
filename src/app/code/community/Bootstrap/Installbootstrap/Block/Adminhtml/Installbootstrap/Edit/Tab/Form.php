<?php

class Bootstrap_Installbootstrap_Block_Adminhtml_Installbootstrap_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('installbootstrap_form', array('legend'=>Mage::helper('installbootstrap')->__('Configurações')));
     
       //  $fieldset->addField('store_id', 'select', array(
       //     'name' => 'store',
       //     'title' => Mage::helper('cms')->__('Store View'),
       //     'label' => Mage::helper('cms')->__('Store View'),
       //     'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
       // ));

        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_ids', 'multiselect', array(
                'name' => 'store_ids[]',
                'label' => $this->__('Lojas'),
                'required' => TRUE,
                'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(FALSE, TRUE),
            ));
        }
        $fieldset->addField('action', 'select', array(
            'name' => 'action',
            'title' => Mage::helper('cms')->__('Store View'),
            'label' => Mage::helper('cms')->__('Ação'),
            'values' => array(
                array('value' => 'install', 'label' => 'Instalar Twitter Bootstrap'),
                array('value' => 'uninstall', 'label' => 'Desinstalar Twitter Bootstrap'),
            ),
        ));

        if ( Mage::getSingleton('adminhtml/session')->getInstallbootstrapData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getInstallbootstrapData());
          Mage::getSingleton('adminhtml/session')->setInstallbootstrapData(null);
      } elseif ( Mage::registry('installbootstrap_data') ) {
          $form->setValues(Mage::registry('installbootstrap_data')->getData());
      }
      return parent::_prepareForm();
  }
}