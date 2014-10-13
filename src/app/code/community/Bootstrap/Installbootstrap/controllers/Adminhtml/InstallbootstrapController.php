<?php
class Bootstrap_Installbootstrap_Adminhtml_InstallbootstrapController extends Mage_Adminhtml_Controller_action {

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('installbootstrap/items')
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

        return $this;
    }

    public function indexAction() {
        $this->newAction();
    }

    public function editAction() {
        $this->loadLayout();
        $this->_setActiveMenu('installbootstrap/items');

        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->_addContent($this->getLayout()->createBlock('installbootstrap/adminhtml_installbootstrap_edit'))
                ->_addLeft($this->getLayout()->createBlock('installbootstrap/adminhtml_installbootstrap_edit_tabs'));

        $this->renderLayout();
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            $action = trim($data['action']);
			$stores = array();
            $stores = $data['store_ids'];
			if(!$stores ) { $stores = array(0=>0); }
			try {

                if ($action == 'install') {
                    //install configuration 
					if($stores[0]==0)  {
						$storeConfigs = Mage::helper('installbootstrap/data')->getAllStore();
					} else {
						$storeConfigs = $stores; 
					}
                    foreach ($storeConfigs as $store_id) {
                        Mage::getModel('installbootstrap/installbootstrap')->saveBootstrapConfig($store_id);
                    }
                    //install static block 
                    // Mage::getModel('installbootstrap/installbootstrap/')->saveStaticBlock($stores);
                    //install cms page
                    // Mage::getModel('installbootstrap/installbootstrap/')->saveCmsPage($stores);
                    
                    Mage::getModel('installbootstrap/installbootstrap')->saveCarousel();

                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('installbootstrap')->__('Twitter Bootstrap foi instalado com sucesso!'));
                } else if ($action == 'uninstall') {
                    //uninstall configuration 
					if($stores[0]==0)  {
						$storeConfigs = Mage::helper('installbootstrap/data')->getAllStore();
					} else {
						$storeConfigs = $stores; 
					}
					
                    foreach ($storeConfigs as $store_id) {
                        Mage::getModel('installbootstrap/installbootstrap')-> backupBootstrapConfig($store_id);
                    }
                    //uninstall static block
                    // $identityFromStatic = Mage::helper('installbootstrap')->getNodeDataFromStaticBlock();
                    // foreach ($identityFromStatic as $keyStatic) {
                    //     Mage::getModel('installbootstrap/installbootstrap/')->deleteStaticBlock($keyStatic, $stores);
                    // }

                    //uninstall cms page block
                    $identityFromCmsPage = Mage::helper('installbootstrap')->getNodeDataFromCmsPageBlock();
                    foreach ($identityFromCmsPage as $keyPage) {
                        Mage::getModel('installbootstrap/installbootstrap/')->deleteCmsPageBlock($keyPage,$stores);
                    }
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('installbootstrap')->__('Twitter Bootstrap was succesfully uninstalled'));
                }

                $this->_redirect('*/*/edit');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('installbootstrap')->__('Unable to find item to save'));
                $this->_redirect('*/*/edit');
            }
        }
    }

}