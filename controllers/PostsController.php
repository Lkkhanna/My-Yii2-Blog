<?php

namespace app\controllers;

use app\models\PostCategoriesMapping;
use app\models\PostImages;
use app\models\Posts;
use app\models\PostsSearch;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile as WebUploadedFile;

/**
 * PostsController implements the CRUD actions for Posts model.
 */
class PostsController extends Controller
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
     * Lists all Posts models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Posts model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        $images = Posts::getImagesOfPost($slug);
        // dd($images);
        return $this->render('view', [
            'model' => $this->findModel($slug),
            'images' => $images
        ]);
    }

    /**
     * Creates a new Posts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        try {
            $transaction = Yii::$app->db->beginTransaction();
            $model = new Posts();
            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {
                    $model->created_at = date('Y-m-d h:m:s');
                    // Insert Post data
                    if ($model->save()) {
                        // Upload Image
                        $names = WebUploadedFile::getInstances($model, 'image');
                        foreach ($names as $name) {
                            $fileName = time() . '.' . $name->extension;
                            $name->saveAs('uploads/' . $fileName);
                            $post_images = new PostImages();
                            $post_images->post_id = $model->id;
                            $post_images->image = $fileName;
                            $post_images->save();
                        }
                        // Insert Category id in mapping table
                        foreach ($_POST['Posts']['categories'] as $val) {
                            $post_categories = new PostCategoriesMapping();
                            $post_categories->post_id = $model->id;
                            $post_categories->category_id = $val;
                            $post_categories->created_at = date('Y-m-d h:m:s');
                            $post_categories->save();
                        }
                        $transaction->commit();
                        return $this->redirect(['view', 'slug' => $model->slug]);
                    }
                }
            } else {dd(0);
                $model->loadDefaultValues();
            }dd(1);
            return $this->render('create', [
                'model' => $model,
            ]);
        } catch (Exception $e) {dd(2);
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Updates an existing Posts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        $model = $this->findModel($slug);
        if ($model->created_by !== Yii::$app->user->id){
            throw new ForbiddenHttpException("You do not have permission to edit this Post");
        }
        try {
            $transaction = Yii::$app->db->beginTransaction();
            if ($this->request->isPost && $model->load($this->request->post())) {
                $model->updated_at = date('Y-m-d h:m:s');
                // Save updated data
                if ($model->save()) {
                    // Deleting existing images
                    PostImages::deleteAll(['post_id' => $model->id]);
                    // Upload Image
                    $names = WebUploadedFile::getInstances($model, 'image');
                    foreach ($names as $name) {
                        $fileName = time() . '.' . $name->extension;
                        $name->saveAs('uploads/' . $fileName);
                        $post_images = new PostImages();
                        $post_images->post_id = $model->id;
                        $post_images->image = $fileName;
                        $post_images->save();
                    }
                    // Deleting existing categories
                    PostCategoriesMapping::deleteAll(['post_id' => $model->id]);
                    // Insert Category id in mapping table
                    foreach ($_POST['Posts']['categories'] as $val) {
                        $post_categories = new PostCategoriesMapping();
                        $post_categories->post_id = $model->id;
                        $post_categories->category_id = $val;
                        $post_categories->created_at = date('Y-m-d h:m:s');
                        $post_categories->save();
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'slug' => $model->slug]);
                }
            }
            $x = PostCategoriesMapping::find()->where(['post_id' => $model->id])->all();
            
            foreach ($x as $val) {
                $categories[$val->category_id] = array("selected"=>true);
            }

            return $this->render('update', [
                'model' => $model,
                'categories' => $categories
            ]);
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Deletes an existing Posts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($slug)
    {
        $model = $this->findModel($slug);
        if ($model->created_by !== Yii::$app->user->id) {
            throw new ForbiddenHttpException("You do not have permission to delete this Post");
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Posts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Posts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        if (($model = Posts::findOne(['slug' => $slug])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
