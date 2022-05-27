<?php

class ImageController extends FatController
{
    public function default_action()
    {
        exit(Labels::getLabel('ERR_INVALID_REQUEST!', CommonHelper::getLangId()));
    }

    public function product($recordId, $sizeType = '', $afile_id = 0)
    {
        $default_image = 'product_default_image.jpg';
        $recordId = FatUtility::int($recordId);
        $afile_id = FatUtility::int($afile_id);

        if ($afile_id > 0) {
            $res = AttachedFile::getAttributesById($afile_id);
            if (!false == $res && $res['afile_type'] == AttachedFile::FILETYPE_PRODUCT_IMAGE) {
                $file_row = $res;
            }
        } else {
            $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_PRODUCT_IMAGE, $recordId);
        }
        $image_name = isset($file_row['afile_physical_path']) ? AttachedFile::FILETYPE_PRODUCT_IMAGE_PATH . $file_row['afile_physical_path'] : '';
        $image_name = AttachedFile::setNamePrefix($image_name, $sizeType);

        $imageDimensions = ImageDimension::getData(ImageDimension::TYPE_PRODUCTS, $sizeType);

        if ($sizeType) {
            AttachedFile::displayImage($image_name, $imageDimensions['width'], $imageDimensions['height'], $default_image);
        } else {
            AttachedFile::displayOriginalImage($image_name, $default_image);
        }
    }

    public function siteAdminLogo($lang_id = 0, $sizeType = '')
    {
        $lang_id = FatUtility::int($lang_id);
        $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_ADMIN_LOGO, 0, 0, $lang_id);
        $image_name = isset($file_row['afile_physical_path']) ? $file_row['afile_physical_path'] : '';
        $default_image = 'logo_default.svg';
        $image_name = AttachedFile::setNamePrefix($image_name, $sizeType);
        AttachedFile::displayImage($image_name, 0, 0, $default_image, '', ImageResize::IMG_RESIZE_RESET_DIMENSIONS);
    }

    public function profileImage($adminId, $sizeType = '', $cropedImage = false)
    {
        $default_image = 'user_deafult_image.jpg';
        $recordId = FatUtility::int($adminId);

        if ($cropedImage == true) {
            $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_ADMIN_PROFILE_CROPED_IMAGE, $recordId);
        } else {
            $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_ADMIN_PROFILE_IMAGE, $recordId);
        }

        $image_name = isset($file_row['afile_physical_path']) ? $file_row['afile_physical_path'] : '';
        $image_name = AttachedFile::setNamePrefix($image_name, $sizeType);

        $imageDimensions = ImageDimension::getData(ImageDimension::TYPE_USER_PROFILE_IMAGE, $sizeType);

        if ($sizeType) {
            AttachedFile::displayImage($image_name, $imageDimensions['width'], $imageDimensions['height'], $default_image);
        } else {
            AttachedFile::displayOriginalImage($image_name, $default_image);
        }
    }

    public function badgeRequest($recordId, $sizeType = '')
    {
        $res = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE_REQUEST, $recordId);
        $image_name = isset($res['afile_physical_path']) ? AttachedFile::FILETYPE_BADGE_REQUEST_IMAGE_PATH . $res['afile_physical_path'] : '';
        $image_name = AttachedFile::setNamePrefix($image_name, $sizeType);
        $imageDimensions = ImageDimension::getData(ImageDimension::TYPE_ADMIN_BADGE_REQUEST, $sizeType);

        $default_image = 'badge_default.png';

        if ($sizeType) {
            AttachedFile::displayImage($image_name, $imageDimensions['width'], $imageDimensions['height'], $default_image, '', ImageResize::IMG_RESIZE_RESET_DIMENSIONS);
        } else {
            AttachedFile::displayImage($image_name, 0, 0, '', '', ImageResize::IMG_RESIZE_RESET_DIMENSIONS);
        }
    }
}
