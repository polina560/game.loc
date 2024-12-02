<?php

namespace api\modules\v1\controllers;

use api\behaviors\returnStatusBehavior\JsonSuccess;
use common\models\Gift;
use common\models\UserGift;
use common\modules\user\models\UserExt;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\Property;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class GiftController extends AppController
{

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), ['auth' => ['except' => ['list']]]);
    }

    /**
     * Add a Gift to User
     */
    #[Get(
        path: '/gift/index',
        operationId: 'gift-index',
        description: 'Присваивает подарок пользователю',
        summary: 'Подарок',
        security: [['bearerAuth' => []]],
        tags: ['gift']
    )]
    #[JsonSuccess(content: [
        new Property(
            property: 'gift', type: 'array',
            items: new Items(ref: '#/components/schemas/Gift'),
        )
    ])]
    public function actionIndex(): array
    {
        $user_id = Yii::$app->user->identity->getId();

        $user = UserExt::find()->where(['user_id' => $user_id])->one();
        if($user->attempts <= 0)
            return [
                'success' => false,
                'data' => 'У вас закончились попытки',
            ];

//        $tempModel = UserGift::find()->andWhere(['id_user' => $user_id])->all();
//        foreach($tempModel as $item)
//            if(date('j.m.Y', $item->created_at) ==  date('j.m.Y'))
//                return [
//                    'success' => false,
//                    'data' => 'Подарок уже выдан',
//                ];

        $gifts = Gift::find()->all();
        $weights = [];
        $total = 0;

        foreach ($gifts as $gift) {
            $total += $gift->chance;
            $weights[] = $total;
        }

        $random = mt_rand(0, $total - 1);
        $giftModel = null;
        foreach($weights as $index => $weight)
        {
            if($random < $weight)
            {
                $giftModel = $gifts[$index];
                break;
            }
        }


        $userGiftModel = new UserGift();
        $userGiftModel->id_gift = $giftModel->id;
        $userGiftModel->id_user = $user_id;


        $user->attempts -= 1;
        $user->save();

        if($userGiftModel->validate()){
            $userGiftModel->save();
            return $this->returnSuccess([
                'code-category' =>  $giftModel]);
        }
        else {
            return [
                'success' => false,
                'errors' => $giftModel->getErrors(),
            ];
        }


    }

    /**
     * Returns a list of Gift's
     */
    #[Get(
        path: '/gift/list',
        operationId: 'gift-list',
        description: 'Возвращает список подарков',
        summary: 'Список подарков',
        security: [['bearerAuth' => []]],
        tags: ['gift']
    )]
    #[JsonSuccess(content: [
        new Property(
            property: 'gifts', type: 'array',
            items: new Items(ref: '#/components/schemas/Gift'),
        )
    ])]
    public function actionList(): array
    {

        $query = Gift::find();

        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->returnSuccess([
            'gifts' => $provider,
        ]);


    }

}
