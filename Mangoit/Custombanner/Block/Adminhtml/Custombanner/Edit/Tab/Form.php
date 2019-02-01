<?php
/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Banner add/edit form
 */
class Mangoit_Custombanner_Block_Adminhtml_Custombanner_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * Prepare banner edit form
     */
    protected function _prepareForm() 
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('banner_form', array('legend' => Mage::helper('custombanner')->__('Banner Information')));
        $version = substr(Mage::getVersion(), 0, 3);
        $fieldset->addField(
            'title', 'text', array(
            'label' => Mage::helper('custombanner')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
            )
        );
        $link = $fieldset->addField(
            'link', 'text', array(
            'label' => Mage::helper('custombanner')->__('Web URL'),
            'name' => 'link',
            'class' => 'validate-link-url',
            'onchange' =>'validateLink(this)'
            )
        );   
        $message = '(Web URL like and on click of the banner user will be redirected to above mentioned URL.)'; 
        $fieldset->addField(
            'weburl', 'note', array(
            'text'  => Mage::helper('custombanner')->__($message),
            )
        );
        $pattern = "/^(http|https|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])";
        $pattern .= "|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|";
        $pattern .= "[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|";
        $pattern .= "1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])";
        $pattern .= "|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|";
        $pattern .= "[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-";
        $pattern .= "\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])";
        $pattern .= "|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~";
        $pattern .= "|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900";
        $pattern .= "-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-";
        $pattern .= "\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|";
        $pattern .= ":|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])";
        $pattern .= "|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-";
        $pattern .= "|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]";
        $pattern .= "{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#(((";
        $pattern .= "[a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|";
        $pattern .= "(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/.test(checkboxElem)";

        $link->setAfterElementHtml(
            "<script>
        function validateLink(checkboxElem)
        {
           Validation.add(\"validate-link-url\",\"Please enter a valid URL. For example http://www.example.com\",function(checkboxElem){
               checkboxElem = (checkboxElem || '').replace(/^\s+/, '').replace(/\s+$/, '');
			    if(checkboxElem != '') {											
					if(".$pattern.") {
                        return true;
					}
					return false;
                }
				return true;
                
            });
        }
		  </script>"
        );
        $fieldset->addField(
            'banner_type', 'select', array(            
            'name' => 'banner_type',
            'style' => 'display:none',
            'values' => array(
                array(
                    'value' => 0,
                    'label' => Mage::helper('custombanner')->__('Image'),
                )               
            ),
            )
        );
        $fieldset->addField(
            'filename', 'image', array(
            'label' => Mage::helper('custombanner')->__('Image'),
            'required' => false,
            'name' => 'filename',
            )
        );
        $fieldset->addField(
            'logo', 'note', array(
            'text'  => Mage::helper('custombanner')->__('(Files type allowed: "jpg", "jpeg", "gif", "png" and we recommend that the image size should not be smaller than the image size that is set in Custom Banner Group section.)'),
            )
        );
        $fieldset->addField(
            'sort_order', 'text', array(
            'label' => Mage::helper('custombanner')->__('Sort Order'),
            'name' => 'sort_order',
            )
        );
        $fieldset->addField(
            'status', 'select', array(
            'label' => Mage::helper('custombanner')->__('Status'),
            'class' => 'required-entry',
            'name' => 'status',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('custombanner')->__('Enabled'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('custombanner')->__('Disabled'),
                ),
            ),
            )
        );
        if (Mage::getSingleton('adminhtml/session')->getBannerData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getBannerData());
            Mage::getSingleton('adminhtml/session')->setBannerData(null);
        } elseif (Mage::registry('banner_data')) {
            $form->setValues(Mage::registry('banner_data')->getData());
        }

        return parent::_prepareForm();
    }              
}
