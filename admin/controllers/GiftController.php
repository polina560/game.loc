<?php

namespace admin\controllers;

use admin\controllers\AdminController;
use admin\modules\rbac\components\RbacHtml;
use common\components\helpers\UserUrl;
use common\models\Gift;
use common\models\GiftSearch;
use kartik\grid\EditableColumnAction;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * GiftController implements the CRUD actions for Gift model.
 *
 * @package admin\controllers
 */
final class GiftController extends AdminController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => ['delete' => ['POST']]
            ]
        ]);
    }

    /**
     * Lists all Gift models.
     *
     * @throws InvalidConfigException
     */
    public function actionIndex(): string
    {
        $model = new Gift();

        if (RbacHtml::isAvailable(['create']) && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Элемент №$model->id создан успешно");
        }

        $searchModel = new GiftSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render(
            'index',
            ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'model' => $model]
        );
    }

    /**
     * Displays a single Gift model.
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id): string
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    /**
     * Creates a new Gift model.
     *
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @param string|null $redirect если нужен иной редирект после успешного создания
     *
     * @throws InvalidConfigException
     */
    public function actionCreate(string $redirect = null): Response|string
    {
        $model = new Gift();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Элемент №$model->id создан успешно");
            return match ($redirect) {
                'create' => $this->redirect(['create']),
                'index' => $this->redirect(UserUrl::setFilters(GiftSearch::class)),
                default => $this->redirect(['view', 'id' => $model->id])
            };
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updates an existing Gift model.
     *
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @throws NotFoundHttpException if the model cannot be found
     * @throws InvalidConfigException
     */
    public function actionUpdate(int $id): Response|string
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Элемент №$model->id изменен успешно");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing Gift model.
     *
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @throws NotFoundHttpException if the model cannot be found
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionDelete(int $id): Response
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', "Элемент №$id удален успешно");
        return $this->redirect(UserUrl::setFilters(GiftSearch::class));
    }

    /**
     * Finds the Gift model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    private function findModel(int $id): Gift
    {
        if (($model = Gift::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'change' => [
                'class' => EditableColumnAction::class,
                'modelClass' => Gift::class
            ]
        ];
    }
}
