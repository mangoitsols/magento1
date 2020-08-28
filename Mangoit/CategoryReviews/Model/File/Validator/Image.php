<?php
/**
 * @category   Mangoit
 * @package    Mangoit_CategoryReviews
 * Custom CategoryReviews Model
 */

class Mangoit_CategoryReviews_Model_File_Validator_Image extends Mage_Core_Model_File_Validator_Image
{
	
	/**
     * Validation callback for checking is file is image
     *
     * @param  string $filePath Path to temporary uploaded file
     * @return null
     * @throws Mage_Core_Exception
     */
     public function validate($filePath)
    {
        list($imageWidth, $imageHeight, $fileType) = getimagesize($filePath);
        if ($fileType) {
            if ($this->isImageType($fileType)) {
                /** if 'general/reprocess_images/active' false then skip image reprocessing. */
                if (!Mage::getStoreConfigFlag('general/reprocess_images/active')) {
                    return null;
                }
                //replace tmp image with re-sampled copy to exclude images with malicious data
                if ($fileType == IMAGETYPE_GIF) {
                    $image = imagecreatefromgif(file_get_contents($filePath));
                } else {
                    $image = imagecreatefromstring(file_get_contents($filePath));
                }

                if ($image !== false) {
                    if ($fileType != IMAGETYPE_GIF) {
                        $img = imagecreatetruecolor($imageWidth, $imageHeight);
                        imagealphablending($img, false);
                        imagecopyresampled($img, $image, 0, 0, 0, 0, $imageWidth, $imageHeight, $imageWidth, $imageHeight);
                        imagesavealpha($img, true);
                    }

                    switch ($fileType) {
                        case IMAGETYPE_GIF:
                            imagegif($image, $filePath);
                            break;
                        case IMAGETYPE_JPEG:
                            imagejpeg($img, $filePath, 100);
                            break;
                        case IMAGETYPE_PNG:
                            imagepng($img, $filePath);
                            break;
                        default:
                            break;
                    }

                    imagedestroy($img);
                    imagedestroy($image);
                    return null;
                } else {
                    throw Mage::exception('Mage_Core', Mage::helper('core')->__('Invalid image.'));
                }
            }
        }
        throw Mage::exception('Mage_Core', Mage::helper('core')->__('Invalid MIME type.'));
    }
}