 <?php

    $imageUrl = isset($image) ? ($image . "t=" . time()) : '';
    $body = '
        <div class="img-container">
            <img src="' . $imageUrl . '" alt="Picture" id="new-img" class="img_responsive cropper-hidden">
            <div class="loader-positon" id="loader-js"></div>
        </div>
    ';

    $footer = '
    <div class="rotator-actions mediaCropButtonsJs" id="actions">
        
            <ul class="actions">
                <li>
                    <a href="javascript:void(0)" class="docs-tooltip"  data-method="rotate" data-option="-90" data-toggle="tooltip"  title="' . Labels::getLabel('LBL_Rotate_Left', $siteLangId) . '">
                        <span class="fa fa-undo-alt"></span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="docs-tooltip" data-toggle="tooltip" data-method="rotate" data-option="90" title="' . Labels::getLabel('LBL_Rotate_Right', $siteLangId) . '">
                        <span class="fa fa-redo-alt"></span>
                    </a>
                </li>
            
                <li>
                    <a href="javascript:void(0)" class="docs-tooltip" data-toggle="tooltip"  data-method="scaleX" data-option="-1" title="' . Labels::getLabel('LBL_Flip_Horizontal', $siteLangId) . '">
                        <span class="fa fa-arrows-alt-h"></span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="docs-tooltip" data-toggle="tooltip" data-method="scaleY" data-option="-1" title="' . Labels::getLabel('LBL_Flip_Vertical', $siteLangId) . '">
                        <span class="fa fa-arrows-alt-v"></span>
                    </a>
                </li>
                <li>            
                <label class="btn-upload m-0" for="inputImage" title="' . Labels::getLabel('LBL_UPLOAD_IMAGE_FILE', $siteLangId) . '">
                    <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*">
                    <a class="docs-tooltip" data-toggle="tooltip">
                        <span class="fa fa-upload"></span>  
                    </a>
                </label>
                </li>              
                <li>
                    <a href="javascript:void(0)" class="docs-tooltip" data-toggle="tooltip"  data-method="reset" title="' . Labels::getLabel('LBL_RESET', $siteLangId) . '">
                        <span class="fa fa-sync-alt"></span>
                    </a>
                </li>
            </ul>
            <div class="">
                <button type="button" data-dismiss="modal" class="btn btn-outline-secondary btn-wide dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
                <button type="button" class="btn btn-brand btn-wide " data-method="getCroppedCanvas">' . Labels::getLabel('LBL_APPLY', $siteLangId) . '</button>
            </div>
       
    </div>';

    FatUtility::dieJsonSuccess(['body' => $body, 'footer' => $footer]);