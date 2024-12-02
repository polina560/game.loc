<?php

namespace common\modules\user\actions;

use api\behaviors\returnStatusBehavior\JsonSuccess;
use common\components\exceptions\ModelSaveException;
use common\models\Setting;
use common\modules\user\helpers\UserHelper;
use common\modules\user\models\UserExt;
use OpenApi\Attributes\{Get, Property};
use Yii;
use yii\base\Exception;
use yii\web\HttpException;

/**
 * Возвращение профиля пользователя
 *
 * @package user\actions
 * @author  m.kropukhinsky <m.kropukhinsky@peppers-studio.ru>
 */
#[Get(
    path: '/user/profile',
    operationId: 'profile',
    description: 'Запрос данных профиля',
    summary: 'Данные профиля',
    security: [['bearerAuth' => []]],
    tags: ['user'],
)]
#[JsonSuccess(content: [new Property(property: 'profile', ref: '#/components/schemas/Profile')])]
class ProfileAction extends BaseAction
{
    /**
     * @throws ModelSaveException
     * @throws Exception
     * @throws HttpException
     */
    final public function run(): array
    {
        $user_id = Yii::$app->user->identity->getId();
        /** @var UserExt $user */
        $user = UserExt::find()->where(['user_id' => $user_id])->one();

        if(date('j.m.Y', $user->recovery_attempts) !=  date('j.m.Y')) {
            $user->recovery_attempts = time();
            $user->attempts = Setting::findOne(['parameter' => 'attempts_count'])->value;
            $user->save();
        }

        return $this->controller->returnSuccess(UserHelper::getProfile(), 'profile');
    }
}
