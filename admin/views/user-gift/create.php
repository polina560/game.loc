<?php

use common\components\helpers\UserUrl;
use common\models\UserGiftSearch;
use yii\bootstrap5\Html;

/**
 * @var $this  yii\web\View
 * @var $model common\models\UserGift
 */

$this->title = Yii::t('app', 'Create User Gift');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'User Gifts'),
    'url' => UserUrl::setFilters(UserGiftSearch::class)
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-gift-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['model' => $model, 'isCreate' => true]) ?>

</div>
