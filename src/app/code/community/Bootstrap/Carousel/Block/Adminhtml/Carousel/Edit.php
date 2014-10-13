<?php
/**
*/ 
class Bootstrap_Carousel_Block_Adminhtml_Carousel_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'carousel';
        $this->_controller = 'adminhtml_carousel';
        
        $this->_updateButton('save', 'label', Mage::helper('carousel')->__('Salvar'));
        $this->_updateButton('delete', 'label', Mage::helper('carousel')->__('Apagar'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Salvar e continuar'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('carousel_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'carousel_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'carousel_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('carousel_data') && Mage::registry('carousel_data')->getId() ) {
            return Mage::helper('carousel')->__("Editar '%s'", $this->htmlEscape(Mage::registry('carousel_data')->getTitle()));
        } else {
            return Mage::helper('carousel')->__('Adicionar');
        }
    }
}