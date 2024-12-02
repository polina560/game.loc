<?php

namespace common\models;

use common\models\AppActiveRecord;
use common\modules\user\models\User;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%user_gift}}".
 *
 * @property int       $id
 * @property int       $id_gift ID подарка
 * @property int       $id_user ID пользователя
 *
 * @property-read Gift $gift
 * @property-read User $user
 */


class UserGift extends AppActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user_gift}}';
    }

    public static function externalAttributes(): array
    {
        return ['user.username', 'gift.title'];
    }



    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id_gift', 'id_user'], 'required'],
            [['id_gift', 'id_user'], 'integer'],
            [['id_gift'], 'exist', 'skipOnError' => true, 'targetClass' => Gift::class, 'targetAttribute' => ['id_gift' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    final public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_gift' => Yii::t('app', 'ID Gift'),
            'id_user' => Yii::t('app', 'ID User'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    final public function getGift(): ActiveQuery
    {
        return $this->hasOne(Gift::class, ['id' => 'id_gift']);
    }

    final public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }
}
