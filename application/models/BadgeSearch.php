<?php

class BadgeSearch extends SearchBase
{
    private $langId;

    /**
     * __construct
     *
     * @param  int $langId   
     * @return void
     */
    public function __construct(int $langId = 0)
    {
        $this->langId = $langId;
        parent::__construct(Badge::DB_TBL, 'bdg');

        if ($this->langId > 0) {
            $this->joinTable(
                Badge::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'bdg_l.badgelang_badge_id = bdg.badge_id AND bdg_l.badgelang_lang_id = ' . $langId,
                'bdg_l'
            );
        }
    }

    /**
     * addTypesCondition
     *
     * @param  array $typesArr
     * @return void
     */
    public function addTypesCondition(array $typesArr)
    {
        $this->addCondition(Badge::DB_TBL_PREFIX . 'type', 'IN',  $typesArr);
    }

    /**
     * addShapeTypesCondition
     *
     * @param  array $shapeTypesArr
     * @return void
     */
    public function addShapeTypesCondition(array $shapeTypesArr)
    {
        $this->addCondition(Badge::DB_TBL_PREFIX . 'shape_type', 'IN',  $shapeTypesArr);
    }

    /**
     * descOrder
     *
     * @param  array $descOrder
     * @return void
     */
    public function descOrder()
    {
        $this->addOrder(Badge::DB_TBL_PREFIX . 'id', 'DESC');
    }
}
