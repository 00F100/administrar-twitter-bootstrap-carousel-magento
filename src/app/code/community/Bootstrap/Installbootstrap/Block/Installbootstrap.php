<?php
class Bootstrap_Installbootstrap_Block_Installbootstrap extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getInstallbootstrap()     
     { 
        if (!$this->hasData('installbootstrap')) {
            $this->setData('installbootstrap', Mage::registry('installbootstrap'));
        }
        return $this->getData('installbootstrap');
        
    }
}