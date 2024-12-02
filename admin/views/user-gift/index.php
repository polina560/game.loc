<?php

use admin\components\GroupedActionColumn;
use admin\components\widgets\gridView\Column;
use admin\modules\rbac\components\RbacHtml;
use admin\widgets\sortableGridView\SortableGridView;
use kartik\grid\SerialColumn;
use yii\widgets\ListView;

/**
 * @var $this         yii\web\View
 * @var $searchModel  common\models\UserGiftSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model        common\models\UserGift
 */

$this->title = Yii::t('app', 'User Gifts');
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

    <?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'pjax' => true,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => SerialColumn::class],

            Column::widget(),
            Column::widget(['attr' => 'id_gift', 'viewAttr' => 'gift.title', 'editable' => false]),
            Column::widget(['attr' => 'id_user', 'viewAttr' => 'user.username', 'editable' => false]),

            ['class' => GroupedActionColumn::class,
                'buttons' => [
                    'update' => function () {
                        return null;
                    }
                ]


            ]
        ]
    ]) ?>
</div>
