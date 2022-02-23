<?php defined('SYSTEM_INIT') or die('Invalid usage'); ?>
<div class="breadcrumb-wrap">
    <ul class="breadcrumb ">
        <li class="breadcrumb-item">
            <a href="<?php echo UrlHelper::generateUrl('') ?>">
                <?php echo labels::getLabel('LBL_Home', (isset($langId)  && 0 < $langId ? $langId : $siteLangId)); ?>
            </a>
        </li>
        <?php
        if (!empty($this->variables['nodes'])) {
            foreach ($this->variables['nodes'] as $nodes) {
        ?>
                <?php if (!empty($nodes['href'])) { ?>
                    <li class="breadcrumb-item">
                        <a href="<?php echo $nodes['href']; ?>" <?php echo (!empty($nodes['other'])) ? $nodes['other'] : ''; ?>>
                            <?php echo $nodes['title'] ?? ''; ?>
                        </a>
                    </li>
                <?php } else { ?>
                    <li class="breadcrumb-item">
                        <?php echo $nodes['title'] ?? ''; ?>
                    </li>
        <?php
                }
            }
        }

        if (isset($headerHtmlContent) && NULL != $headerHtmlContent) {
            echo $headerHtmlContent;
        } ?>
    </ul>
</div>