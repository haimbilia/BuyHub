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

    public function setRecordCount(object $srch, int $pageSize)
    {
        if ($pageSize < 1) {
            return;
        }

        $srch->addFld('count(*) as totalRecords');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $defaultRecordCount = FatApp::getDb()->fetch($srch->getResultSet());
        $this->set('pageCount', ceil($defaultRecordCount['totalRecords'] / $pageSize) ?? 0);
        $this->set('recordCount', $defaultRecordCount['totalRecords']);
        $this->set('pageSize', $pageSize);
    }

}
