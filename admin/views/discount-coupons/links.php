<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<main class="main mainJs">
    <div class="container">
        <?php $this->includeTemplate('_partial/header/header-breadcrumb.php', [], false); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-table">
                        <div class="table-responsive table-scrollable js-scrollable">
                            <?php
                            $tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table-dashed'));
                            $thead = $tbl->appendElement('thead');
                            $tbody = $tbl->appendElement('tbody');
                            foreach ($fields as $key => $val) {
                                $width = 'linkType' == $key ? '20%' : '80%';
                                $thead->appendElement('th', ['width' => $width])
                                    ->appendElement('span')
                                    ->appendElement('plaintext', [], $val, true);
                            }

                            foreach ($linksTypeArr as $linkType => $label) {
                                $tr = $tbody->appendElement('tr');
                                $data = $linksTypeData[$linkType] ?? [];
                                $tagifyData = [];
                                switch ($linkType) {
                                    case 'products':
                                        array_walk($data, function ($item) use (&$tagifyData, $linkType, $recordId) {
                                            $tagifyData[] = [
                                                'id' => $item['product_id'],
                                                'value' => $item['product_name'],
                                                'linkType' => $linkType,
                                                'recordId' => $recordId,
                                            ];
                                        });
                                        break;
                                    case 'categories':
                                        array_walk($data, function ($item) use (&$tagifyData, $linkType, $recordId) {
                                            $tagifyData[] = [
                                                'id' => $item['prodcat_id'],
                                                'value' => $item['prodcat_name'],
                                                'linkType' => $linkType,
                                                'recordId' => $recordId,
                                            ];
                                        });
                                        break;
                                    case 'users':
                                        array_walk($data, function ($item) use (&$tagifyData, $linkType, $recordId) {
                                            $userName = $item['user_name'] . ' ( ' . $item['credential_username'] . ' )';
                                            $tagifyData[] = [
                                                'id' => $item['user_id'],
                                                'value' => $userName,
                                                'linkType' => $linkType,
                                                'recordId' => $recordId,
                                            ];
                                        });
                                        break;
                                    case 'shops':
                                        array_walk($data, function ($item) use (&$tagifyData, $linkType, $recordId) {
                                            $tagifyData[] = [
                                                'id' => $item['shop_id'],
                                                'value' => $item['shop_name'],
                                                'linkType' => $linkType,
                                                'recordId' => $recordId,
                                            ];
                                        });
                                        break;
                                    case 'brands':
                                        array_walk($data, function ($item) use (&$tagifyData, $linkType, $recordId) {
                                            $tagifyData[] = [
                                                'id' => $item['brand_id'],
                                                'value' => $item['brand_name'],
                                                'linkType' => $linkType,
                                                'recordId' => $recordId,
                                            ];
                                        });
                                        break;
                                    default:
                                        trigger_error('Invalid Link Type', E_USER_ERROR);
                                        break;
                                }

                                foreach ($fields as $key => $val) {
                                    $td = $tr->appendElement('td');
                                    switch ($key) {
                                        case 'items':
                                            $data = $linksTypeData[$linkType];
                                            $td->appendElement('plaintext', [], "<input class='form-control tagifyJs' data-link-type='" . $linkType . "' placeholder='".Labels::getLabel('FRM_TYPE_TO_SEARCH', $siteLangId)."' data-record-id='" . $recordId . "' value='" . json_encode($tagifyData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . "'>", true);
                                            break;
                                        default:
                                            $td->appendElement('plaintext', [], $label, true);
                                            break;
                                    }
                                }
                            }
                            echo $tbl->getHtml();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>