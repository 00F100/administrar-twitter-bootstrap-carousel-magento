<?php
/**
*/ 
class Bootstrap_Carousel_Adminhtml_CarouselController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('carousel/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Carousel - Gerenciar Banners'), Mage::helper('adminhtml')->__('Carousel - Gerenciar Banners'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('carousel/carousel')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('carousel_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('carousel/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('carousel/adminhtml_carousel_edit'))
				->_addLeft($this->getLayout()->createBlock('carousel/adminhtml_carousel_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('carousel')->__('Este banner não existe!'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != null) {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('image');
					
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
							
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS . 'twitter-bootstrap' . DS . 'carousel' . DS ;
					$uploader->save($path, $_FILES['image']['name'] );
					
				} catch (Exception $e) {
		      
		        }
	        
		        //this way the name is saved in DB
		        $basepath = Mage::getBaseDir('media') . DS . 'twitter-bootstrap' . DS . 'carousel' . DS ;
				// $basepath='yoururl/magentothem/banner7/';
		        //$basepath=str_replace("index.php/","",$basepath);
				$_filename = str_replace(" ","_",$_FILES['image']['name']);
	  			$data['image'] = '<img src="'.$basepath.$_filename.'" height="80px" alt="" />';
			}
	  			
	  			
			$model = Mage::getModel('carousel/carousel');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('carousel')->__('Salvo com sucesso!'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('carousel')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('carousel/carousel');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Apagado com sucesso!'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $carouselIds = $this->getRequest()->getParam('carousel');
        if(!is_array($carouselIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Selecione um banner(s)'));
        } else {
            try {
                foreach ($carouselIds as $carouselId) {
                    $carousel = Mage::getModel('carousel/carousel')->load($carouselId);
                    $carousel->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total de %d banners(s) apagado(s)', count($carouselIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $carouselIds = $this->getRequest()->getParam('carousel');
        if(!is_array($carouselIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Selecione um banner(s)'));
        } else {
            try {
                foreach ($carouselIds as $carouselId) {
                    $carousel = Mage::getSingleton('carousel/carousel')
                        ->load($carouselId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total de %d banner(s) atualizado(s)', count($carouselIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'carousel.csv';
        $content    = $this->getLayout()->createBlock('carousel/adminhtml_carousel_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'carousel.xml';
        $content    = $this->getLayout()->createBlock('carousel/adminhtml_carousel_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}