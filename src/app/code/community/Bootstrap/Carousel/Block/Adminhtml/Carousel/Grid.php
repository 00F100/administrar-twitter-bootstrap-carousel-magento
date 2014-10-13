<?php
/**
*/ 
class Bootstrap_Carousel_Block_Adminhtml_Carousel_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('carouselGrid');
      $this->setDefaultSort('carousel_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('carousel/carousel')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      // $this->addColumn('carousel_id', array(
      //     'header'    => Mage::helper('carousel')->__('ID'),
      //     'align'     =>'right',
      //     'width'     => '50px',
      //     'index'     => 'carousel_id',
      // ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('carousel')->__('Titulo'),
          'align'     =>'left',
          'index'     => 'title',
      ));

      $categorias = Mage::getSingleton('carousel/categoria')->getOptionArray();
      $this->addColumn('categoria_id', array(
          'header'    => Mage::helper('carousel')->__('Categoria'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'categoria_id',
          'type'      => 'options',
          'options'   => $categorias,
      ));
	  
	  // $this->addColumn('link', array(
   //        'header'    => Mage::helper('carousel')->__('Link'),
   //        'align'     =>'left',
   //        'index'     => 'link',
   //    ));

	  
   //    $this->addColumn('description', array(
			// 'header'    => Mage::helper('carousel')->__('Descrição'),
			// 'width'     => '500px',
			// 'index'     => 'description',
   //    ));
   // echo get_class($this); exit;
	  $this->addColumn('image', array(
          'header'    => Mage::helper('carousel')->__('Imagem'),
          'align'     =>'left',
          'index'     => 'image',
          // 'renderer'  => Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Interface,
          // 'format'    => html_entity_decode('%s'),
      ));
	  
	  // $this->addColumn('store_id', array(
   //        'header'    => Mage::helper('carousel')->__('Loja ID'),
   //        'align'     =>'left',
   //        'index'     => 'store_id',
   //    ));
	  
	  $this->addColumn('order', array(
          'header'    => Mage::helper('carousel')->__('Ordem'),
          'align'     =>'left',
          'index'     => 'order',
      ));
	  
    $status = Mage::getSingleton('carousel/status')->getOptionArray();
      $this->addColumn('status', array(
          'header'    => Mage::helper('carousel')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => $status,
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('carousel')->__('Ações'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('carousel')->__('Editar'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		echo '<script type="text/javascript">$jq(document).ready(function(){ $jq("td.a-left").each(function(){var f1 = $jq(this);var t2=f1.html();t2=t2.replace(/&lt;img/g, "<img");t2=t2.replace(/&gt;/g, ">");t2 = t2.replace("yoururl/","'.Mage::getBaseUrl('media').'"); f1.html(t2);})});</script>';
		
		$this->addExportType('*/*/exportCsv', Mage::helper('carousel')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('carousel')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('carousel_id');
        $this->getMassactionBlock()->setFormFieldName('carousel');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('carousel')->__('Apagar'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('carousel')->__('Você tem certeza?')
        ));

        $statuses = Mage::getSingleton('carousel/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('carousel')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('carousel')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));

        $categorias = Mage::getSingleton('carousel/categoria')->getOptionArray();

        array_unshift($categorias, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('categoria_id', array(
             'label'=> Mage::helper('carousel')->__('Alterar categoria'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'categoria_id',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('carousel')->__('Categoria'),
                         'values' => $categorias
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}