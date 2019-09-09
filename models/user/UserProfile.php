<?php

namespace app\models\user;

use borales\extensions\phoneInput\PhoneInputValidator;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property int $user_id
 * @property string $name
 * @property string $phone
 * @property string $DOB
 * @property int $gender
 * @property int $subscribe
 * @property string $info
 * @property User $user
 */
class UserProfile extends ActiveRecord
{
    const GENDER_THING = 0;

    const GENDER_MALE = 1;

    const GENDER_FEMALE = 2;

    const SUBSCRIBE_NOT_ACTIVE = 0;

    const SUBSCRIBE_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone'], 'trim'],
            [['DOB'], 'safe'],
            [['gender', 'subscribe'], 'integer'],
            [['info'], 'string'],
            [['name', 'phone'], 'string', 'max' => 255],
            [['phone'], PhoneInputValidator::class],
            [
                ['user_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::class,
                'targetAttribute' => ['user_id' => 'id'],
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
            'user_id'   => Yii::t('app', 'User ID'),
            'name'      => Yii::t('app', 'Name'),
            'phone'     => Yii::t('app', 'Phone'),
            'DOB'       => Yii::t('app', 'Dob'),
            'gender'    => Yii::t('app', 'Gender'),
            'subscribe' => Yii::t('app', 'Subscribe'),
            'info'      => Yii::t('app', 'Info'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
