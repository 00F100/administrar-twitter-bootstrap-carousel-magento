<?php

class Bootstrap_Installbootstrap_Block_Adminhtml_Installbootstrap_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->removeButton('back');
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'installbootstrap';
        $this->_controller = 'adminhtml_installbootstrap';
        
        $this->_updateButton('reset', 'label', Mage::helper('installbootstrap')->__('Desfazer'));
        $this->_updateButton('save', 'label', Mage::helper('installbootstrap')->__('Salvar'));
        $this->_updateButton('delete', 'label', Mage::helper('installbootstrap')->__('Apagar'));
		
    
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('installbootstrap_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'installbootstrap_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'installbootstrap_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('installbootstrap_data') && Mage::registry('installbootstrap_data')->getId() ) {
            return Mage::helper('installbootstrap')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('installbootstrap_data')->getTitle()));
        } else {
            return Mage::helper('installbootstrap')->__('');
        }
    }
}