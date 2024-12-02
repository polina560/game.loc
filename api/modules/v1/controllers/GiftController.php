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
use yii\db\Expression;

class GiftController extends AppController
{

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

        $giftModel = Gift::find()->orderBy(new Expression('rand()'))->one();
        $userGiftModel = new UserGift();

        $userGiftModel->id_gift = $giftModel->id;
        $userGiftModel->id_user = $user_id;
        $userGiftModel->created_at = time();


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

}
