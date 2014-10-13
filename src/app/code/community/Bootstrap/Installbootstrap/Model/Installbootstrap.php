<?php
class Bootstrap_Installbootstrap_Model_Installbootstrap extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('installbootstrap/installbootstrap');
    }

    /*public function saveStaticBlock($store = NULL) {
        $staticData = Mage::helper('installbootstrap/data')->getStaticBlockData();
        foreach ($staticData as $block) {
            $block['stores'] = $store;
            if (!Mage::helper('installbootstrap/data')->haveBlockBefore($block['identifier'])) {
                Mage::getModel('cms/block')->setData($block)->save();
            } else {
                Mage::getModel('cms/block')->load($block['identifier'])->setStores($store)->save();
            }
        }
    }*/

    public function saveCmsPage($store = NULL) {
        $cmsPageData = Mage::helper('installbootstrap/data')->getCmsPageData();
        foreach ($cmsPageData as $block) {
            $block['stores'] = $store;
            if (!Mage::helper('installbootstrap/data')->haveBlockPageBefore($block['identifier'])) {
                Mage::getModel('cms/page')->setData($block)->save();
            } else {
                Mage::getModel('cms/page')->load($block['identifier'])->setStores($store)->save();
            }
        }
    }

    public function saveBootstrapConfig(int $store) {
        $scope = ($store ? 'stores' : 'default');
        Mage::getConfig()->saveConfig('design/theme/default', 'bootstrap', $scope, $store);
        Mage::getConfig()->saveConfig('web/default/cms_home_page', 'bootstrap_home', $scope, $store);
		Mage::getConfig()->saveConfig('design/theme/default', 'bootstrap', 'default', 0);
        Mage::getConfig()->saveConfig('web/default/cms_home_page', 'bootstrap_home', 'default', 0);
    }
    
    public function saveCarousel() {
        $carouselData = Mage::helper('installbootstrap/data')->getCarouselData();
        foreach($carouselData as $banner) {
            if($banner){
                unset($banner['content']);
                $existed = $this->existCarousel($banner['carousel_id'],'carousel');
                if(!$existed) {
                    $this->_insert('carousel', $banner);
                } 
            }
        }
    }
    
     public function backupBootstrapConfig(int $store) {
        $oldConfigData = Mage::helper('installbootstrap/data')->getOldConfigData(); 
        $scope = ($store ? 'stores' : 'default');
        Mage::getConfig()->saveConfig('design/theme/default', $oldConfigData[0][0], $scope, $store);
        Mage::getConfig()->saveConfig('web/default/cms_home_page', $oldConfigData[0][1], $scope, $store);
		Mage::getConfig()->saveConfig('design/theme/default', $oldConfigData[0][0], $scope, 0);
        Mage::getConfig()->saveConfig('web/default/cms_home_page', $oldConfigData[0][1], $scope, 0);
    }

    public function deleteCmsPageBlock($key = NULL, $stores = NULL) {
        $model = Mage::getModel('cms/page');
        $model->load($key);
        $storesOld = $model->getStoreId();
        $storeNew = array();
        foreach ($storesOld as $storeId) {
            if (!in_array($storeId, $stores)) {
                $storeNew[] = $storeId;
            }
        }

        if (in_array(0, $stores)) {
            $model->delete();
        } else {
            $model->setStores($storeNew)->save();
        }
    }

    public function deleteStaticBlock($key = NULL, $stores = NULL) {
        $model = Mage::getModel('cms/block');
        $model->load($key);
        $storesOld = $model->getStoreId();
        $storeNew = array();
        foreach ($storesOld as $storeId) {
            if (!in_array($storeId, $stores)) {
                $storeNew[] = $storeId;
            }
        }

        if (in_array(0, $stores)) {
            $model->delete();
        } else {
            $model->setStores($storeNew)->save();
        }
    }
    
     public function _insert($table = NULL, $fields = NULL) {
        
        try {
            $connection = Mage::getSingleton('core/resource')
                    ->getConnection('core_write');
            $connection->beginTransaction();
            $connection->insert($table, $fields);
            $connection->commit();
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function existCarousel($id, $table) {
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $query = "SELECT * FROM $table where carousel_id=".$id;
        $results = $read->fetchAll($query);
        if($results) 
            return $results;
        return array();
    }

}