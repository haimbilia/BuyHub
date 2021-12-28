<?php
class TrackingCodeRelationController extends ListingBaseController
{
    
    public function __construct($action)
    {
        parent::__construct($action);  
        if(!$this->objPrivilege->canViewTrackingRelationCode()){
            Message::addErrorMessage(Labels::getLabel('LBL_Please_activate_ship_station_and_tracking_plugins', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Plugins'));
        }
    }
    
    public function index()
    {
        $this->_template->render();
    }
    
    public function search()
    {
        $shipmentTracking = new ShipmentTracking(); 
		if (false === $shipmentTracking->init($this->siteLangId)) {
			LibHelper::exitWithError($shipmentTracking->getError(), true);
		}
		
        if(false === $shipmentTracking->getTrackingCouriers()) {
			LibHelper::exitWithError($shipmentTracking->getError(), true);
		}
		
        $trackingCourier = $shipmentTracking->getResponse();
        if($trackingCourier == false){
            LibHelper::exitWithError($shipmentTracking->getError(), true);
        }
        
        $plugin = new Plugin();
        $shipApiPluginData = $plugin->getDefaultPluginData(Plugin::TYPE_SHIPPING_SERVICES, ['plugin_code', 'plugin_id']);
        $shipApi = PluginHelper::callPlugin($shipApiPluginData['plugin_code'], [$this->siteLangId], $error, $this->siteLangId);
        if($shipApi->init() === false){              
            LibHelper::exitWithError($shipApi->getError(), true);
        }
        
        $carriers = $shipApi->getCarriers();
        if(empty($carriers)){
            LibHelper::exitWithError($shipApi->getError(), true);
        }
       
        $trackingApiPluginId = $plugin->getDefaultPluginData(Plugin::TYPE_SHIPMENT_TRACKING, 'plugin_id');
        $trackingRelation = new TrackingCourierCodeRelation();
        $records = $trackingRelation->getDefaultShipAndTrackingRecords($shipApiPluginData['plugin_id'], $trackingApiPluginId);
        
        $this->set('trackingCourier', $trackingCourier);
        $this->set('carriers', $carriers); 
        $this->set('records', $records); 
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }
    
    public function setUpCourierRelation()
    {
        $trackingApiCode = FatApp::getPostedData('trackingApiCode', FatUtility::VAR_STRING, '');
        $shipApiCode = FatApp::getPostedData('shipApiCode', FatUtility::VAR_STRING, '');
        if(empty($trackingApiCode) || empty($shipApiCode)){
            LibHelper::exitWithError(Labels::getLabel('LBL_Invalid_Request', $this->siteLangId), true);
        }
        
        $plugin = new Plugin();
        $trackingApiPluginId = $plugin->getDefaultPluginData(Plugin::TYPE_SHIPMENT_TRACKING, 'plugin_id');
        $shipApiPluginId = $plugin->getDefaultPluginData(Plugin::TYPE_SHIPPING_SERVICES, 'plugin_id');
        if($trackingApiPluginId < 1 || $shipApiPluginId < 1){
            LibHelper::exitWithError(Labels::getLabel('LBL_Invalid_Request', $this->siteLangId), true);
        }
        
        $data = array(
            'tccr_shipapi_plugin_id' => $shipApiPluginId,
            'tccr_shipapi_courier_code' => $shipApiCode,
            'tccr_tracking_plugin_id' => $trackingApiPluginId,
            'tccr_tracking_courier_code' => $trackingApiCode
            
        );
        if (!FatApp::getDb()->insertFromArray(TrackingCourierCodeRelation::DB_TBL, $data, false, array(), $data)) {
            LibHelper::exitWithError(FatApp::getDb()->getError(), true);
        }
        
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }
 
}
