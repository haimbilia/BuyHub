<?php defined('SYSTEM_INIT') or die('Invalid usage'); ?>
<ul>
    <li class="breadcrumb-item"><a href="<?php echo UrlHelper::generateUrl(); ?>"><?php echo Labels::getLabel('LBL_Home', $siteLangId); ?> </a></li>
    <?php
    if (!empty($this->variables['nodes'])) {
        foreach ($this->variables['nodes'] as $nodes) {
            $nodes['title'] = html_entity_decode($nodes['title'], ENT_QUOTES, 'utf-8');
            $short_title = (mb_strlen($nodes['title']) > 20) ? mb_substr(strip_tags($nodes['title']), 0, 20) . "..." : strip_tags($nodes['title']); ?>
            <?php if (!empty($nodes['href'])) { ?>
                <li class="breadcrumb-item" title="<?php echo $nodes['title']; ?>"><a href="<?php echo $nodes['href']; ?>" <?php echo (!empty($nodes['other'])) ? $nodes['other'] : ''; ?>><?php echo $short_title; ?></a></li>
            <?php } else { ?>
                <li class="breadcrumb-item" title="<?php echo $nodes['title']; ?>"><?php echo (isset($nodes['title'])) ? $short_title : ''; ?></li>
    <?php }
        }
    } ?>
</ul>