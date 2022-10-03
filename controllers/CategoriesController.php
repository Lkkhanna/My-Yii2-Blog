<?php

namespace app\controllers;

use app\models\Categories;
use app\models\CategorySearch;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

/**
 * CategoriesController implements the CRUD actions for Categories model.
 */
class CategoriesController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                [
                    'class' => AccessControl::class,
                    'only' => ['create', 'update', 'delete'],
                    'rules' => [
                        [
                            'actions' => ['create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['@']
                        ]
                    ]
                ],
            ]
        );
    }

    /**
     * Lists all Categories models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Categories model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Categories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new Categories();

            if ($this->request->isPost && $model->load($this->request->post())) {
                $model->created_at = date('Y-m-d h:i:s');
                $model->created_by = Yii::$app->user->id;
                if ($model->save()) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', "Category created successfully.");
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $model->loadDefaultValues();
            }

            return $this->render('create', [
                'model' => $model,
            ]);

        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::error($e, __METHOD__);
            Yii::$app->session->setFlash('error', "Some error occurred. Category creation failed.");
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Categories model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = $this->findModel($id);
            if ($this->request->isPost && $model->load($this->request->post())) {
                $model->updated_at = date('Y-m-d h:i:s');
                if ($model->save()) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', "Category updated successfully.");
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::error($e, __METHOD__);
            Yii::$app->session->setFlash('error', "Some error occurred. Category updation failed.");
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Categories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $model = $this->findModel($id);
            if ($model->created_by !== Yii::$app->user->id){
                throw new ForbiddenHttpException("You do not have permission to delete this Category");
            }
            $model->delete();
            Yii::$app->session->setFlash('success', "Category deleted successfully.");
            return $this->redirect(['index']);
        } catch (Exception $e) {
            Yii::error($e, __METHOD__);
            Yii::$app->session->setFlash('error', "Some error occurred. Category deletion failed.");
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**$model->delete();
     * Finds the Categories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Categories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categories::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
