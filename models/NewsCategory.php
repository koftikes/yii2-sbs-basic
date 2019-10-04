<?php

namespace app\models;

use sbs\behaviors\DateTimeBehavior;
use sbs\behaviors\SeoBehavior;
use sbs\models\Seo;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%news_category}}".
 *
 * @property int            $id
 * @property string         $name
 * @property string         $slug
 * @property string         $description
 * @property int            $parent_id
 * @property int            $status
 * @property string         $create_date
 * @property string         $update_date
 * @property News[]         $news
 * @property NewsCategory   $parent
 * @property NewsCategory[] $children
 * @property Seo          $seo
 */
class NewsCategory extends ActiveRecord
{
    const STATUS_DISABLE = 0;

    const STATUS_ENABLE  = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%news_category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            DateTimeBehavior::class,
            SeoBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'in', 'range' => [self::STATUS_DISABLE, self::STATUS_ENABLE]],
            [['name', 'slug'], 'required'],
            [['description'], 'string'],
            [['parent_id', 'status'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [
                ['parent_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => self::class,
                'targetAttribute' => ['parent_id' => 'id'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     * {@codeCoverageIgnore}.
     */
    public function attributeLabels()
    {
        return [
            'id'          => '#',
            'name'        => Yii::t('app', 'Name'),
            'slug'        => Yii::t('app', 'Slug'),
            'description' => Yii::t('app', 'Description'),
            'parent_id'   => Yii::t('app', 'Parent'),
            'status'      => Yii::t('app', 'Active'),
            'create_date' => Yii::t('app', 'Create Date'),
            'update_date' => Yii::t('app', 'Update Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::class, ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }
}
