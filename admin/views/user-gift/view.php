<?php

use admin\components\widgets\detailView\Column;
use admin\modules\rbac\components\RbacHtml;
use common\components\helpers\UserUrl;
use common\models\UserGiftSearch;
use yii\widgets\DetailView;

/**
 * @var $this  yii\web\View
 * @var $model common\models\UserGift

 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'User Gifts'),
    'url' => UserUrl::setFilters(UserGiftSearch::class)
];
$this->params['breadcrumbs'][] = RbacHtml::encode($this->title);


?>
<div class="user-gift-view">

    <h1><?= RbacHtml::encode($this->title) ?></h1>

    <p>
<!--        --><?php //= RbacHtml::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= RbacHtml::a(
            Yii::t('app', 'Delete'),
            ['delete', 'id' => $model->id],
            [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post'
                ]
            ]
        ) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            Column::widget(),
            Column::widget(['attr' => 'id_gift', 'viewAttr' => 'gift.title']),
            Column::widget(['attr' => 'id_user', 'viewAttr' => 'user.username']),
        ]
    ]) ?>

</div>
