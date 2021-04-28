<?php

class DigitalDownloadsSearch extends SearchBase
{
    public function __construct()
    {
        parent::__construct(DigitalDownloads::DB_TBL);
    }
}
