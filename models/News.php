<?php

namespace app\models;

use app\models\user\User;
use sbs\behaviors\DateTimeBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQueryInterface;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property int          $id
 * @property int          $category_id
 * @property string       $title
 * @property string       $slug
 * @property string       $image
 * @property string       $preview
 * @property string       $text
 * @property int          $views
 * @property int          $status
 * @property string       $publish_date
 * @property int          $create_user
 * @property int          $update_user
 * @property string       $create_date
 * @property string       $update_date
 * @property NewsCategory $category
 * @property User         $createUser
 * @property User         $updateUser
 */
class News extends ActiveRecord
{
    const STATUS_DISABLE = 0;

    const STATUS_ENABLE  = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            DateTimeBehavior::class,
            [
                'class'              => BlameableBehavior::class,
                'createdByAttribute' => 'create_user',
                'updatedByAttribute' => 'update_user',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'in', 'range' => [self::STATUS_DISABLE, self::STATUS_ENABLE]],
            [['category_id', 'views', 'status', 'create_user', 'update_user'], 'integer'],
            [['title', 'slug', 'text', 'publish_date'], 'required'],
            [['preview', 'text'], 'string'],
            [['publish_date', 'create_date', 'update_date'], 'safe'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [
                ['category_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => NewsCategory::class,
                'targetAttribute' => ['category_id' => 'id'],
            ],
            [
                ['create_user'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::class,
                'targetAttribute' => ['create_user' => 'id'],
            ],
            [
                ['update_user'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::class,
                'targetAttribute' => ['update_user' => 'id'],
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
            'id'           => '#',
            'category_id'  => Yii::t('app', 'Category'),
            'title'        => Yii::t('app', 'Title'),
            'slug'         => Yii::t('app', 'Slug'),
            'image'        => Yii::t('app', 'Image'),
            'preview'      => Yii::t('app', 'Preview'),
            'text'         => Yii::t('app', 'Text'),
            'views'        => Yii::t('app', 'Views'),
            'status'       => Yii::t('app', 'Status'),
            'publish_date' => Yii::t('app', 'Publish Date'),
            'create_user'  => Yii::t('app', 'Create User'),
            'update_user'  => Yii::t('app', 'Update User'),
            'create_date'  => Yii::t('app', 'Create Date'),
            'update_date'  => Yii::t('app', 'Update Date'),
        ];
    }

    /**
     * Grid filtering conditions.
     *
     * @param ActiveQueryInterface $query
     *
     * @throws \Exception
     *
     * @return ActiveQueryInterface
     */
    public function applyFilter(ActiveQueryInterface $query)
    {
        $query
            ->andFilterWhere([
                'category_id' => $this->category_id,
                'status'      => $this->status,
            ])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        if ($this->publish_date) {
            $data = new \DateTime($this->publish_date);
            $query->andFilterWhere([
                'between',
                'publish_date',
                $data->format('Y-m-d H:i:s'),
                $data->modify('+ 1 day - 1 sec')->format('Y-m-d H:i:s'),
            ]);
        }

        return $query;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(NewsCategory::class, ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreateUser()
    {
        return $this->hasOne(User::class, ['id' => 'create_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdateUser()
    {
        return $this->hasOne(User::class, ['id' => 'update_user']);
    }
}
