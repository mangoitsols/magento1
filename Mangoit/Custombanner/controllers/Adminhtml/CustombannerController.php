<?php
/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
  * Custom banner controller
 */
class Mangoit_Custombanner_Adminhtml_CustombannerController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Initialize custom banner action
     */
    protected function _initAction() 
    {
        $this->loadLayout()
            ->_setActiveMenu('custombanner/custombanner')
            ->_addBreadcrumb(Mage::helper('custombanner')->__('Custom Banner'), Mage::helper('custombanner')->__('Custom Banner'));

        return $this;
    }

    public function indexAction() 
    {
        $this->_initAction()
             ->renderLayout();
    }
    
    /**
     * Function to filter/sorting custom banner group grid with ajax
     */
    public function bannergridAction() 
    {
        $this->_initAction();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('custombanner/adminhtml_custombanner_grid')->toHtml()
        );
    }
    
    /**
     * Custom banner edit action
     */
    public function editAction() 
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('custombanner/custombanner')->load($id);
        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('banner_data', $model);
            $this->loadLayout();
            $this->_setActiveMenu('custombanner/items');
            $this->_addBreadcrumb(Mage::helper('custombanner')->__('Custom Banner'), Mage::helper('custombanner')->__('Custom banner'));
            $this->_addBreadcrumb(Mage::helper('custombanner')->__('Custom Banner'), Mage::helper('custombanner')->__('Custom banner'));
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('custombanner/adminhtml_custombanner_edit'))
                ->_addLeft($this->getLayout()->createBlock('custombanner/adminhtml_custombanner_edit_tabs'));
            $version = substr(Mage::getVersion(), 0, 3);
            if (($version=='1.4' || $version=='1.5') && Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
                $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
            }

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('custombanner')->__('Custom banner does not exist'));
            $this->_redirect('*/*/');
        }
    }

    /**
     * Custom banner new action
     */
    public function newAction() 
    {
        $this->_forward('edit');
    }

    /**
     * Custom banner save action
     */
    public function saveAction() 
    {
        $imagedata = array();
        if (!empty($_FILES['filename']['name'])) {
            try {
                $ext = substr($_FILES['filename']['name'], strrpos($_FILES['filename']['name'], '.') + 1);
                $fname = 'File-' . Mage::getModel('core/date')->timestamp() . '.' . $ext;
                $uploader = new Varien_File_Uploader('filename');
                $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png')); // or pdf or anything
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);
                $path = Mage::getBaseDir('media').DS.'custom'.DS.'banners';
                $uploader->save($path, $fname);
                $imagedata['filename'] = 'custom/banners/'.$fname;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }

        if ($data = $this->getRequest()->getPost()) {
            if (!empty($imagedata['filename'])) {
                $data['filename'] = $imagedata['filename'];
            } else {
                if (isset($data['filename']['delete']) && $data['filename']['delete'] == 1) {
                    if ($data['filename']['value'] != '') {
                        $_helper = Mage::helper('custombanner');
                        $this->removeFile(Mage::getBaseDir('media').DS.$_helper->updateDirSepereator($data['filename']['value']));
                    }

                    $data['filename'] = '';
                } else {
                    unset($data['filename']);
                }
            }

            $model = Mage::getModel('custombanner/custombanner');
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
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('custombanner')->__('Custom banner was successfully saved'));
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

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('custombanner')->__('Unable to find banner to save'));
        $this->_redirect('*/*/');
    }

    /**
     * Custom banner delete action
     */
    public function deleteAction() 
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('custombanner/custombanner')->load($this->getRequest()->getParam('id'));
                $_helper = Mage::helper('custombanner');
                $filePath = Mage::getBaseDir('media').DS.$_helper->updateDirSepereator($model->getFilename());
                $model->delete();
                $this->removeFile($filePath);

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('custombanner')->__('Banner was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }

        $this->_redirect('*/*/');
    }

    /**
     * Delete custom banner
     */
    public function massDeleteAction() 
    {
        $bannerIds = $this->getRequest()->getParam('custombanner');
        if (!is_array($bannerIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('custombanner')->__('Please select item(s)'));
        } else {
            try {
                foreach ($bannerIds as $bannerId) {
                    $model = Mage::getModel('custombanner/custombanner')->load($bannerId);
                    $_helper = Mage::helper('custombanner');
                    $filePath = Mage::getBaseDir('media').DS.$_helper->updateDirSepereator($model->getFilename());
                    $model->delete();
                    $this->removeFile($filePath);
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('custombanner')->__(
                        'Total of %d record(s) were successfully deleted', count($bannerIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }

    /**
     * Change status of the custom banner
     */
    public function massStatusAction() 
    {
        $bannerIds = $this->getRequest()->getParam('custombanner');
        if (!is_array($bannerIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($bannerIds as $bannerId) {
                    $custombanner = Mage::getSingleton('custombanner/custombanner')
                                    ->load($bannerId)
                                    ->setStatus($this->getRequest()->getParam('status'))
                                    ->setIsMassupdate(true)
                                    ->save();
                }

                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($bannerIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }

    /**
     * Delete custom banner image
     */
    protected function removeFile($file) 
    {
        try {
            $io = new Varien_Io_File();
            $result = $io->rmdir($file, true);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('custombanner');
    }
}