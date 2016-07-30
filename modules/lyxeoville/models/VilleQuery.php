<?php

namespace app\modules\lyxeoville\models;

/**
 * This is the ActiveQuery class for [[Ville]].
 *
 * @see Ville
 */
class VilleQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * @inheritdoc
     * @return Ville[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Ville|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
