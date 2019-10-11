<?php

namespace app\models;

use sbs\behaviors\DateTimeBehavior;
use sbs\behaviors\SeoBehavior;
use Yii;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "{{%static_page}}".
 *
 * @property int    $id
 * @property string $title
 * @property string $slug
 * @property string $text
 * @property string $update_date
 */
class StaticPage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%static_page}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class'              => DateTimeBehavior::class,
                'createdAtAttribute' => false,
            ],
            SeoBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'slug'], 'required'],
            [['text'], 'string'],
            [['update_date'], 'safe'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => '#',
            'title'       => Yii::t('app', 'Title'),
            'slug'        => Yii::t('app', 'Slug'),
            'text'        => Yii::t('app', 'Text'),
            'update_date' => Yii::t('app', 'Update Date'),
        ];
    }

    /**
     * @param int $id
     *
     * @throws NotFoundHttpException
     *
     * @return array
     */
    public static function url($id)
    {
        $model = self::findOne($id);
        if (!$model instanceof self) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        return ['/site/static-page', 'slug' => $model->slug];
    }
}
