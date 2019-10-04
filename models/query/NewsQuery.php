<?php

namespace app\models\query;

use app\models\News;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\News]].
 *
 * @see News
 */
class NewsQuery extends ActiveQuery
{
    /**
     * @return NewsQuery
     */
    public function active()
    {
        return $this->andWhere(['status' => News::STATUS_ENABLE]);
    }

    /**
     * @throws \Exception
     *
     * @return NewsQuery
     */
    public function publish()
    {
        return $this
            ->active()
            ->andWhere(['<=', 'publish_date', (new \DateTime())->format('Y-m-d H:i:s')]);
    }

    /**
     * @param int $id
     *
     * @return NewsQuery
     */
    public function category($id)
    {
        return $this->andWhere(['category_id' => $id]);
    }

    /**
     * {@inheritdoc}
     *
     * @return array|News[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     *
     * @return null|array|News
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
