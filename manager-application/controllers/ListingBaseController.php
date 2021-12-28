<?php
class ListingBaseController extends AdminBaseController
{
    use RecordOperations;
    
    protected int $mainTableRecordId = 0;
    protected bool $isPlugin = false;
    protected object $modelObj;
    protected array $formLangFields;
    protected bool $checkMediaExist = false;
    protected int $newTabLangId = 0;

    public function __construct($action)
    {
        parent::__construct($action);
    }

    /**
     * setModel - This function is used to set related model class and used by its parent class.
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setModel(array $constructorArgs = []): void
    {
        $this->modelObj = (new ReflectionClass($this->modelClass))->newInstanceArgs($constructorArgs);
    }

    protected function addSortingElements(Form $frm, string $sortBy, string $sortOrder = applicationConstants::SORT_ASC, int $pageSize = 0): void
    {
        $sortOrder = ($sortOrder != applicationConstants::SORT_ASC) ? applicationConstants::SORT_DESC : $sortOrder;
        $pageSize = empty($pageSize) ? FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10) : $pageSize;

        $frm->addHiddenField('', 'sortBy', $sortBy, ['id' => 'sortBy']);
        $frm->addHiddenField('', 'sortOrder', $sortOrder, ['id' => 'sortOrder']);
        $frm->addHiddenField('', 'pageSize', $pageSize);
        $frm->addHiddenField('', 'listingColumns', '');
    }
}
