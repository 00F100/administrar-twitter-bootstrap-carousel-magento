<?php
/**
*/ 
class Bootstrap_Carousel_Block_Carousel extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getCarousel()     
     { 
        if (!$this->hasData('carousel')) {
            $this->setData('carousel', Mage::registry('carousel'));
        }
        return $this->getData('carousel');
        
    }
	public function getDataCarousel($categoria_id = false)
    {
    	$resource = Mage::getSingleton('core/resource');
		$read= $resource->getConnection('core_read');
		$slideTable = $resource->getTableName('carousel');	
		$select = $read->select()
		   ->from($slideTable,array('carousel_id','title','link','description','image','order', 'store_id','status','categoria_id'))
		   ->where('status=?',1);

        if($categoria_id){
           $select->where('categoria_id=?',$categoria_id);
        }

		$slide = $read->fetchAll($select);	
		if ( $this->getConfig('animation') == 'animation1' ) {
			$array2 = $this->sorting_array($slide,'giam');
		} else {
			$array2 = $this->sorting_array($slide,'tang');
		}
		return 	$array2;		
    }
	function sorting_array ($array, $mode='tang'){ 
        if($mode=='tang'){ 
            $length = count($array); 
            for ($i = 0; $i < $length-1; $i++){ 
                $k = $i; 
                for ($j = $i+1; $j < $length; $j++) 
                    if ($array[$j]['order'] < $array[$k]['order'])  
                        $k = $j; 
                $t = $array[$k]; 
                $array[$k] = $array[$i]; 
                $array[$i] = $t; 
            } 
        } 
        if($mode=='giam'){ 
            $length = count($array); 
            for ($i = 0; $i < $length-1; $i++){ 
                $k = $i; 
                for ($j = $i+1; $j < $length; $j++) 
                    if ($array[$j]['order'] > $array[$k]['order'])  
                        $k = $j; 
                $t = $array[$k]; 
                $array[$k] = $array[$i]; 
                $array[$i] = $t; 
            } 
        } 
        return $array; 
    }
	public function getConfig($att) 
	{
		$config = Mage::getStoreConfig('carousel');
		if (isset($config['carousel_config']) ) {
			$value = $config['carousel_config'][$att];
			return $value;
		} else {
			throw new Exception($att.' value not set');
		}
	}
}