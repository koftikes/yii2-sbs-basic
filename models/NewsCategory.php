<?php

namespace app\models;

use phpDocumentor\Reflection\Types\This;
use sbs\behaviors\SlugBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use sbs\behaviors\DateTimeBehavior;
use yii\helpers\ArrayHelper;

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
 *
 * @property News[]         $news
 * @property NewsCategory   $parent
 * @property NewsCategory[] $newsCategories
 */
class NewsCategory extends ActiveRecord
{
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['parent_id', 'status'], 'integer'],
            [['slug', 'create_date', 'update_date'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [
                ['parent_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => NewsCategory::class,
                'targetAttribute' => ['parent_id' => 'id'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @return yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::class, ['category_id' => 'id']);
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(NewsCategory::class, ['id' => 'parent_id']);
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public function getNewsCategories()
    {
        return $this->hasMany(NewsCategory::class, ['parent_id' => 'id']);
    }
}
