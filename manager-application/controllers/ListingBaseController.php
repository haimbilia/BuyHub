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

    public function setRecordCount(object $recordCountSrch, int $pageSize, int $page, &$post)
    {
        if ($pageSize < 1) {
            return;
        }

        if ($page > 1 && !empty($post['total_record_count'])) {
            $this->set('pageCount', ceil($post['total_record_count'] / $pageSize) ?? 0);
            $this->set('recordCount', $post['total_record_count']);
            $this->set('pageSize', $pageSize);
            $this->set('page', $page);
            return;
        }

        $recordCountSrch->addFld('count(*) as totalRecords');
        $recordCountSrch->doNotCalculateRecords();
        $recordCountSrch->doNotLimitRecords(); 
        $defaultRecordCount = FatApp::getDb()->fetch($recordCountSrch->getResultSet());  
        $this->set('pageCount', ceil($defaultRecordCount['totalRecords'] / $pageSize) ?? 0);
        $this->set('recordCount', $defaultRecordCount['totalRecords']);
        $this->set('pageSize', $pageSize);
        $this->set('page', $page);
        $post['total_record_count'] = $defaultRecordCount['totalRecords'];
    }

}
