<?php
/**
*/ 
class Bootstrap_Carousel_Block_Adminhtml_Carousel_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('carousel_form', array('legend'=>Mage::helper('carousel')->__('Informações')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('carousel')->__('Titulo'),
          'required'  => false,
          'name'      => 'title',
      ));

      $categorias = Mage::getSingleton('carousel/categoria')->getOptionArray();
      array_unshift($categorias, array('label'=>'', 'value'=>''));

      $fieldset->addField('categoria_id', 'select', array(
          'label'     => Mage::helper('carousel')->__('Categoria'),
          'name'      => 'categoria_id',
          'required'  => true,
          'values'    => $categorias,
      ));
	  
	  $fieldset->addField('link', 'text', array(
          'label'     => Mage::helper('carousel')->__('Link'),
          'required'  => false,
          'name'      => 'link',
      ));

      $fieldset->addField('image', 'file', array(
          'label'     => Mage::helper('carousel')->__('Imagem'),
          'required'  => false,
          'name'      => 'image',
	  ));
	  
	  $fieldset->addField('order', 'text', array(
          'label'     => Mage::helper('carousel')->__('Ordem'),
          'required'  => false,
          'name'      => 'order',
      ));


        $fieldset->addField('store_id', 'select', array(
            'name'      => 'store_id',
            'label'     => Mage::helper('carousel')->__('Loja'),
            'required'  => true,
            'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
        ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('carousel')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('carousel')->__('Ativo'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('carousel')->__('Inativo'),
              ),
          ),
      ));
     
      $fieldset->addField('description', 'editor', array(
          'name'      => 'description',
          'label'     => Mage::helper('carousel')->__('Descrição'),
          'title'     => Mage::helper('carousel')->__('Descrição'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => false,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getCarouselData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getCarouselData());
          Mage::getSingleton('adminhtml/session')->setCarouselData(null);
      } elseif ( Mage::registry('carousel_data') ) {
          $form->setValues(Mage::registry('carousel_data')->getData());
      }
      return parent::_prepareForm();
  }
}