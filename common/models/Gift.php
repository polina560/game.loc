<?php

namespace common\models;

use common\models\AppActiveRecord;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%gift}}".
 *
 * @property int             $id
 * @property string          $title    Название
 * @property int|null        $cashback Кол-во кэшбэка
 * @property int|null        $chance   Дата измененияШанс выпадения
 *
 * @property-read UserGift[] $userGifts
 */

#[Schema(properties: [
    new Property(property: 'title', type: 'string'),
    new Property(property: 'cashback', type: 'integer'),
])]
class Gift extends AppActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%gift}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['cashback', 'chance'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    final public function fields(): array
    {
        return [
            'title',
            'cashback',
        ];
    }

    /**
     * {@inheritdoc}
     */
    final public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'cashback' => Yii::t('app', 'Cashback'),
            'chance' => Yii::t('app', 'Chance'),
        ];
    }

    final public function getUserGifts(): ActiveQuery
    {
        return $this->hasMany(UserGift::class, ['id_gift' => 'id']);
    }
}
