<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 

$arr_flds = array(
    'prodspec_name' => Labels::getLabel('FRM_SPECIFICATION_NAME', $langId),
    'prodspec_value' => Labels::getLabel('FRM_SPECIFICATION_VALUE', $langId),
    'prodspec_group' => Labels::getLabel('FRM_SPECIFICATION_GROUP', $langId),
    'action' => Labels::getLabel('LBL_ACTION', $langId)
);

$tbl = new HtmlElement('table', array( 'class'=>'table'));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $key=>$val) {
    if($key == 'prodspec_group'){
        $e = $th->appendElement('th', array('class'=>'align-right'), $val);
    }else{
        $e = $th->appendElement('th', array(), $val);
    }                
}

foreach ($productSpecifications as $specification){
    $tr = $tbl->appendElement('tr');
        foreach ($arr_flds as $key=>$val){
            $td = $tr->appendElement('td');
            switch ($key){
                case 'action':   
                    
                        $ul = new HtmlElement("ul", array('class'=>'actions'));
                        $prodSpecId = $specification['prodspec_id'];
                        $li = $ul->appendElement('li');
                        $li->appendElement(
                            'input',
                            [
                                'name' => 'specifications[][id]',                               
                                'data-fatreq' =>"{&quot;required&quot;:false}",
                                'type'=>'hidden',                           
                            ]                            
                        );
                        $li->appendElement(
                            'a',
                            [
                                'href' => 'javascript:void(0)',                               
                                'title' => Labels::getLabel('BTN_EDIT', $siteLangId),
                                'onclick' => "editProdSpec($prodSpecId)"
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
                                'title' => Labels::getLabel('BTN_DELETE', $siteLangId),
                                'onclick' => "deleteProdSpec($prodSpecId,$langId)"
                            ],
                            '<svg class="svg" width="18" height="18">
                                <use
                                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#delete">
                                </use>
                            </svg>',
                            true
                        );
                        $td->appendElement('plaintext', array('class'=> 'align-right'), $ul->getHtml(), true);                      

                break;
                default:
                    $td->appendElement('plaintext', array(), $specification[$key], true);
                break;
            }
        }
}
echo $tbl->getHtml();
