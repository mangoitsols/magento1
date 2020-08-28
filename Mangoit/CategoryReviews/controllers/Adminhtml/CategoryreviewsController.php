<?php

/**
 * @category   Mangoit
 * @package    Mangoit_CategoryReviews
 * Custom CategoryReviews Controller
 */

class Mangoit_CategoryReviews_Adminhtml_CategoryreviewsController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('catalog/categoryreviews');
        $this->_addContent($this->getLayout()->createBlock('categoryreviews/adminhtml_categoryreviews'));
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->editAction();
    }

    public function editAction()
    {
        $id = (int)$this->getRequest()->getParam('id');
        $model = Mage::getModel('categoryreviews/categoryreviews')->load($id);

        if ($id && !$model->getId()) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('categoryreviews')->__('Record does not exist'));
            $this->_redirect('adminhtml/categoryreviews/');
            return;
        }

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
            $model->setId($id);
        }
        Mage::register('categoryreviews', $model);

        $this->loadLayout();

        $this->_setActiveMenu('catalog/categoryreviews');
        $this->_title($this->__('Edit'));
        $this->_addContent($this->getLayout()->createBlock('categoryreviews/adminhtml_categoryreviews_edit'));

        $this->renderLayout();
    }

    public function saveAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('categoryreviews/categoryreviews');
        $postData = $this->getRequest()->getPost();
        if ($postData) {
            try {
                if ((bool)$postData['review_image']['delete'] == 1) {
                    if ($postData['review_image']['value'] != '')
                        $this->removeFile($postData['review_image']['value']);
                    $postData['review_image'] = '';
                } else {
                    if (isset($_FILES)) {
                        if ($_FILES['review_image']['name']) {
                            unset($postData['review_image']);
                            $ext = pathinfo($_FILES['review_image']['name'], PATHINFO_EXTENSION);
                            $path = Mage::getBaseDir('media') . DS . 'categoryreviews'.DS;
                            $uploader = new Varien_File_Uploader('review_image');
                            $uploader->setAllowedExtensions(array('jpg','png','gif'));
                            $uploader->setAllowRenameFiles(false);
                            $uploader->setFilesDispersion(false);
                            $destFile = $path."review_image_".str_replace(" ","_",time()).".".$ext;
                            $filename = $uploader->getNewFileName($destFile);
                            $uploader->save($path, $filename);
                            $postData['review_image'] = $filename;
                        } else {
                            if ((bool)$postData['review_image']['delete'] == 1) {
                                if ($postData['review_image']['value'] != '')
                                    $this->removeFile($postData['review_image']['value']);
                                $postData['review_image'] = '';
                            } elseif ($postData['review_image']['value'] != '') {
                                $postData['review_image'] = $postData['review_image']['value'];
                            }
                        }
                        if ($id) {
                            $model->load($id);
                            if ($model->getData('review_image')) {
                                $model->setUpdatedAt(now());
                                $model->addData($postData);
                            }
                        } else {
                            $model->setCreatedAt(now());
                            $model->setUpdatedAt(now());
                            $model->setData($postData);
                        }
                    }
                }
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($postData);
                $this->_redirect('adminhtml/categoryreviews/edit', array('id' => $id));
                return;
            }
            try {
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Category Reviews has been successfully saved.'));
                if ($this->getRequest()->getParam('continue') || !$id) {
                    $this->_redirect('adminhtml/categoryreviews/edit', array('id' => $model->getId()));
                } else {
                    $this->_redirect('adminhtml/categoryreviews');
                }
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($postData);
                $this->_redirect('adminhtml/categoryreviews/edit', array('id' => $id));
            }
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('categoryreviews')->__('Unable to find a record to save')
        );
        $this->_redirect('adminhtml/categoryreviews');
    }

    public function deleteAction()
    {
        $id = (int)$this->getRequest()->getParam('id');
        $model = Mage::getModel('categoryreviews/categoryreviews')->load($id);
        $imageFileName = $model->getReviewImage();
        $this->removeFile($imageFileName);

        if ($id && !$model->getId()) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Record does not exist'));
            $this->_redirect('adminhtml/categoryreviews');
            return;
        }

        try {
            $model->delete();
            Mage::getSingleton('adminhtml/session')->addSuccess(
                $this->__('Category Review has been successfully deleted')
            );
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $this->_redirect('adminhtml/categoryreviews');
    }

    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('categoryreviews');
        if (!is_array($ids)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('categoryreviews')->__('Please select records'));
            $this->_redirect('adminhtml/categoryreviews');
            return;
        }

        try {
            foreach ($ids as $id) {
                $model = Mage::getModel('categoryreviews/categoryreviews')->load($id);
                $imageFileName = $model->getReviewImage();
                $this->removeFile($imageFileName);
                $model->delete();
            }
            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('adminhtml')->__(
                    'Total of %d record(s) were successfully deleted', count($ids)
                )
            );
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $this->_redirect('adminhtml/categoryreviews');
    }

  

    protected function _setActiveMenu($menuPath)
    {
        $this->getLayout()->getBlock('menu')->setActive($menuPath);
        $this->_title($this->__('Catalog'))->_title($this->__('Category Reviews'));
        return $this;
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('catalog/categoryreviews');
    }

    public function removeFile($file) 
    {
        $directory = Mage::getBaseDir('media') . DS .'categoryreviews' ;
        $io = new Varien_Io_File();
        $io->rm($directory.DS.$file);
    }

    /**
    * Get tree data by ajax
    * 
    */
    public function ajaxtreeAction()
    {
        $catTreeList = [];
        $paramID = $this->getRequest()->getParam('catid');
        $paramSelected = $this->getRequest()->getParam('selected');
        $selectedCatId = $this->getRequest()->getParam('selectedcatid');
        
        if (is_numeric($paramID) && $paramID > 0) {
            //get sub categories, and print them as 
            $catTreeList = $this->getSubCategories($paramID, $paramSelected, $selectedCatId);
        }
        echo json_encode($catTreeList);
    }

    
}