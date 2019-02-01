<?php
/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Custom banner group controller
 */
class Mangoit_Custombanner_Adminhtml_CustombannergroupController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Initialize custom banner group action
     */
    protected function _initAction() 
    {
        $this->loadLayout()
                ->_setActiveMenu('custombanner/custombannergroup')
                ->_addBreadcrumb(Mage::helper('custombanner')->__('Custom Banner Group'), Mage::helper('custombanner')->__('Custom Banner Group'));
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('custombanner/custombannergroup')->load($id);
        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
        }

        Mage::register('custombannergroup_data', $model);
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
            $this->getLayout()->createBlock('custombanner/adminhtml_custombannergroup_grid')->toHtml()
        );
    }

    /**
     * Custom banner group edit action
     */
    public function editAction() 
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('custombanner/custombannergroup')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('custombannergroup_data', $model);
            $this->loadLayout();
            $this->_setActiveMenu('custombanner/items');
            $this->_addBreadcrumb(Mage::helper('custombanner')->__('Custom Banner'), Mage::helper('custombanner')->__('Custom Banner Group'));
            $this->_addBreadcrumb(Mage::helper('custombanner')->__('Custom Banner'), Mage::helper('custombanner')->__('Custom Banner Group'));
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('custombanner/adminhtml_custombannergroup_edit'))
                    ->_addLeft($this->getLayout()->createBlock('custombanner/adminhtml_custombannergroup_edit_tabs'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('custombanner')->__('Custom banner group does not exist'));
            $this->_redirect('*/*/');
        }
    }
    
    /**
     * Custom banner group new action
     */
    public function newAction() 
    {
        $this->_forward('edit');
    }

    /**
     * Custom banner group save action
     */
    public function saveAction() 
    {
        if ($data = $this->getRequest()->getPost()) {
            $banners = array();
            $availBannerIds = Mage::getModel('custombanner/custombanner')->getAllAvailBannerIds();
            parse_str($data['custombannergroup_custombanners'], $banners);
            foreach ($banners as $k => $v) {
                if (preg_match('/[^0-9]+/', $k) || preg_match('/[^0-9]+/', $v)) {
                    unset($banners[$k]);
                }
            }

            $bannerIds = array_intersect($availBannerIds, $banners);
            $data['banner_ids'] = implode(',', $bannerIds);
            $data['banner_effects'] = (($data['animation_type'] == 0) ? '' : $data['banner_effects']);
            $data['pre_custombanner_effects'] = (($data['animation_type'] == 0) ? $data['pre_custombanner_effects'] : '');
            $model = Mage::getModel('custombanner/custombannergroup');
            $model->setData($data)->setId($this->getRequest()->getParam('id'));
            try {
                if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                    $model->setCreatedTime(now())
                            ->setUpdateTime(now());
                } else {
                    $model->setUpdateTime(now());
                }

                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('custombanner')->__('Custom banner group was successfully saved'));
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

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('custombanner')->__('Unable to find custom banner group to save'));
        $this->_redirect('*/*/');
    }
    
    /**
     * Custom banner group delete action
     */
    public function deleteAction() 
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('custombanner/custombannergroup')->load($this->getRequest()->getParam('id'));
                $filePath = Mage::getBaseDir('media') . DS . 'custom' . DS . 'banners' . DS . 'resize' . DS . $model->getGroupCode();              
                $model->delete();
                $this->removeFile($filePath);

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('custombanner')->__('Custom banner group was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }

        $this->_redirect('*/*/');
    }
    
    /**
     * Delete custom banner group
     */
    public function massDeleteAction() 
    {
        $bannerIds = $this->getRequest()->getParam('custombanner');
        if (!is_array($bannerIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('custombanner')->__('Please select item(s)'));
        } else {
            try {
                foreach ($bannerIds as $bannerId) {
                    $custombanner = Mage::getModel('custombanner/custombannergroup')->load($bannerId);
                    $filePath = Mage::getBaseDir('media') . DS . 'custom' . DS . 'banners' . DS . 'resize' . DS . $custombanner->getGroupCode();
                    $custombanner->delete();
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
     * Change status of the custom banner group
     */
    public function massStatusAction() 
    {
        $bannerIds = $this->getRequest()->getParam('custombanner');
        if (!is_array($bannerIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($bannerIds as $bannerId) {
                    $custombanner = Mage::getSingleton('custombanner/custombannergroup')
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