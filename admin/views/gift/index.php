<?php

use admin\components\GroupedActionColumn;
use admin\components\widgets\gridView\Column;
use admin\modules\rbac\components\RbacHtml;
use admin\widgets\sortableGridView\SortableGridView;
use kartik\grid\SerialColumn;
use yii\widgets\ListView;

/**
 * @var $this         yii\web\View
 * @var $searchModel  common\models\GiftSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model        common\models\Gift
 */

$this->title = Yii::t('app', 'Gifts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gift-index">

    <h1><?= RbacHtml::encode($this->title) ?></h1>

    <div>
        <?= 
            RbacHtml::a(Yii::t('app', 'Create Gift'), ['create'], ['class' => 'btn btn-success']);
//           $this->render('_create_modal', ['model' => $model]);
        ?>
    </div>

    <?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'pjax' => true,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => SerialColumn::class],

            Column::widget(),
            Column::widget(['attr' => 'title']),
            Column::widget(['attr' => 'cashback']),
            Column::widget(['attr' => 'chance']),

            ['class' => GroupedActionColumn::class]
        ]
    ]) ?>
</div>
