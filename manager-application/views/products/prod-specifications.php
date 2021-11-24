<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$arr_flds = array(
    'prodspec_name' => Labels::getLabel('FRM_SPECIFICATION_NAME', $langId),
    'prodspec_value' => Labels::getLabel('FRM_SPECIFICATION_VALUE', $langId),
    'prodspec_group' => Labels::getLabel('FRM_SPECIFICATION_GROUP', $langId),
    'action' => Labels::getLabel('LBL_ACTION', $langId)
);

$tbl = new HtmlElement('table', array('class' => 'table'));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $key => $val) {
    if ($key == 'action') {
        $e = $th->appendElement('th', array('class' => 'align-right'), $val);
    } else {
        $e = $th->appendElement('th', array(), $val);
    }
}
$tbody = $tbl->appendElement('tbody');
foreach ($productSpecifications as $specification) {
    $prodSpecId = $specification['prodspec_id'];
    $tr = $tbody->appendElement('tr',['data-id' => $prodSpecId ]);
    foreach ($arr_flds as $key => $val) {   
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : ['class'=> str_replace(ProdSpecification::DB_TBL_PREFIX,'',$key)."Js"];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'action':
                $ul = new HtmlElement("ul", array('class' => 'actions'));               
                $li = $ul->appendElement('li');
                $li->appendElement(
                    'input',
                    [
                        'name' => 'specifications[][id]',
                        'type' => 'hidden',
                        'value' => $specification['prodspec_id'],
                        'data-fatreq' => "{&quot;required&quot;:false}",
                    ]
                );
                $li->appendElement(
                    'a',
                    [
                        'href' => 'javascript:void(0)',
                        'title' => Labels::getLabel('BTN_EDIT', $langId),
                        'onclick' => "editProdSpec(this)"
                    ],
                    '<svg class="svg" width="18" height="18">
                                <use
                                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#edit">
                                </use>
                            </svg>',
                    true
                );

                $li = $ul->appendElement('li');
                $li->appendElement(
                    'a',
                    [
                        'href' => 'javascript:void(0)',
                        'title' => Labels::getLabel('BTN_DELETE', $langId),
                        'onclick' => "deleteProdSpec(this)",
                        'data-id' => $prodSpecId,
                    ],
                    '<svg class="svg" width="18" height="18">
                                <use
                                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#delete">
                                </use>
                            </svg>',
                    true
                );
                $td->appendElement('plaintext', $tdAttr, $ul->getHtml(), true);

                break;
            default:
                $td->appendElement('plaintext',$tdAttr, $specification[$key], true);
                break;
        }
    }
}
echo $tbl->getHtml();
