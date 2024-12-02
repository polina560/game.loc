<?php

use admin\components\GroupedActionColumn;
use admin\components\widgets\gridView\Column;
use admin\modules\rbac\components\RbacHtml;
use admin\widgets\sortableGridView\SortableGridView;
use common\components\export\ExportMenu;
use kartik\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/**
 * @var $this         yii\web\View
 * @var $searchModel  common\models\UserGiftSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model        common\models\UserGift
 */

$this->title = Yii::t('app', 'User\'s Gifts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-gift-index">

    <h1><?= RbacHtml::encode($this->title) ?></h1>

<!--    <div>-->
<!--        --><?php //=
//            RbacHtml::a(Yii::t('app', 'Create User Gift'), ['create'], ['class' => 'btn btn-success']);
////           $this->render('_create_modal', ['model' => $model]);
//        ?>
<!--    </div>-->

    <div class="row justify-content-between">
        <div class="col-auto mr-auto">
            <?= ExportMenu::widget([
                'id' => 'users-gifts-export-menu',
                'dataProvider' => $dataProvider,
                'staticConfig' => \common\models\UserGift::class,
                'filename' => 'gifts_fot_users_' . date('d-m-Y_H-i-s'),
                'batchSize' => 100,
            ]) ?>
        </div>
    </div>

    <?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'pjax' => true,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => SerialColumn::class],

            Column::widget(),
//            Column::widget(['attr' => 'id_gift', 'viewAttr' => 'gift.title', 'editable' => false]),
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{gift}',
                'buttons' => [
                    'gift' => function ($url, $model, $key) {
                        return Html::a($model->gift->title, Url::toRoute(['gift/view', 'id' => $model->id_gift]), ['data-pjax' => '0']);

                    },
                ],
            ],
//            Column::widget(['attr' => 'id_user', 'viewAttr' => 'user.username', 'editable' => false]),
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{user}',
                'buttons' => [
                    'user' => function ($url, $model, $key) {
                        return Html::a($model->user->username, Url::toRoute(['user/user/view', 'id' => $model->id_user]), ['data-pjax' => '0']);

                    },
                ],
            ],

            ['class' => GroupedActionColumn::class,
                'buttons' => [
                    'update' => function () {
                        return null;
                    }
                ]


            ]
        ]
    ]);
    ?>


</div>
