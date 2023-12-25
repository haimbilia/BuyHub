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

    public function setRecordCount(object $recordCountSrch, int $pageSize, int $page, &$post, $isGroupSearch = false)
    {
        if ($pageSize < 1) {
            return;
        }

        if ($page > 1 && !empty($post['total_record_count'])) {
            $this->setPageRecord($post['total_record_count'], $pageSize, $page);
            return;
        }

        $recordCountSrch->doNotLimitRecords();
        if ($isGroupSearch == false) {
            $recordCountSrch->addFld('count(1) as totalRecords');
            $recordCountSrch->doNotCalculateRecords();
            $results = FatApp::getDb()->fetch($recordCountSrch->getResultSet());
            $defaultRecordCount = !empty($results['totalRecords']) ? $results['totalRecords'] : 0;
        } else {
            $recordCountSrch->addFld('1');
            $recordCountSrch->getResultSet();
            $defaultRecordCount = $recordCountSrch->recordCount();
        }
        
        $this->setPageRecord($defaultRecordCount, $pageSize, $page);
        $post['total_record_count'] = $defaultRecordCount;
    }

    private function setPageRecord($recordCount, $pageSize, $page)
    {
        $this->set('pageCount', ($recordCount > 0) ? ceil($recordCount / $pageSize) : 0);
        $this->set('recordCount', $recordCount);
        $this->set('pageSize', $pageSize);
        $this->set('page', $page);
    }
}
