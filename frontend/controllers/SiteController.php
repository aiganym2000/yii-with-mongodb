<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\helpers\LanguageHelper;
use common\models\LoginForm;
use common\models\Order;
use common\models\OrderItem;
use common\models\Product;
use common\models\Review;
use common\models\Slider;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use Yii;
use yii\base\InvalidParamException;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $lang = Yii::$app->language;
        $slidersTop = Slider::find()
            ->where(['status' => (string)Slider::STATUS_ACTIVE])
            ->andWhere(['slider_position' => (string)Slider::POSITION_TOP])
            ->all();
        $slidersBottom = Slider::find()
            ->where(['status' => (string)Slider::STATUS_ACTIVE])
            ->andWhere(['slider_position' => (string)Slider::POSITION_BOTTOM])
            ->all();
        $slidersBottom = array_chunk($slidersBottom, 2);
        $toys = Product::find()
            ->where(['status' => (string)Product::STATUS_ACTIVE])
            ->andWhere(['category_id' => (string)4])
            ->all();

        $category = Category::findOne(['id' => 4]);
        if ($category)
            $categoryTitle = LanguageHelper::getField($category, 'title', 'category');
        else
            $categoryTitle = '';
        $newProducts = Product::find()
            ->where(['status' => (string)Product::STATUS_ACTIVE])
            ->orderBy(['id' => SORT_DESC])
            ->limit(10)
            ->all();
        $categories = Category::find()
            ->where(['parent_id' => (string)1])
            ->limit(6)
            ->all();
        $colorArray = ['first', 'second', 'third', 'fourth', 'fifth', 'sixth'];
        return $this->render('index', compact('slidersTop', 'slidersBottom', 'newProducts', 'toys', 'categories', 'colorArray', 'categoryTitle'));
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionProduct($id)
    {
        $product = Product::findOne(['id' => (int)$id]);
        $reviews = Review::findAll(['product_id' => (int)$id]);//todo , 'status' => Review::STATUS_PUBLISHED
        if ($product) {
            $reviewModel = new Review();
            if ($reviewModel->load(Yii::$app->request->post())) {
                $reviewModel->product_id = (int)$id;
                if ($reviewModel->save())
                    return $this->redirect(Yii::$app->request->referrer);
            }
            $categories = Product::getParentCategory($product->category_id);
        }

        return $this->render('product', [
            'model' => $this->findModel($id),
            'reviews' => $reviews,
            'reviewModel' => $reviewModel,
            'categories' => $categories
        ]);
    }

    public function actionAddToCart($id, $count = 1)
    {
        $count = (int)$count;
        if ($count < 1) {
            return;
        }
        $id = abs((int)$id);
        $product = Product::findOne(['id' => (int)$id]);
        if (empty($product)) {
            return;
        }
        if ($count > 10) {
            $count = 10;
        }
        $session = Yii::$app->session;
        $session->open();
        if (!$session->has('cart')) {
            $session->set('cart', []);
            $cart = [];
        } else {
            $cart = $session->get('cart');
        }
        if (isset($cart['products'][$product->id])) {
            $count = $cart['products'][$product->id]['count'] + $count;
            if ($count > 100) {
                $count = 100;
            }
            $cart['products'][$product->id]['count'] = $count;
        } else {
            $cart['products'][$product->id]['id'] = $product->id;
            $cart['products'][$product->id]['title'] = $product->title;
            $cart['products'][$product->id]['price'] = $product->price;
            $cart['products'][$product->id]['count'] = $count;
            $cart['products'][$product->id]['getImgPath'] = $product->getImgPath() . '/' . $product->images['0'];
        }
        $amount = 0.0;
        foreach ($cart['products'] as $item) {
            $amount = $amount + $item['price'] * $item['count'];
        }
        $cart['amount'] = $amount;
        $session->set('cart', $cart);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSubFromCart($id, $count = 1)
    {
        $count = (int)$count;
        if ($count < 1) {
            return;
        }
        $product = Product::findOne(['id' => (int)$id]);
        if (empty($product)) {
            return;
        }
        $session = Yii::$app->session;
        $session->open();
        if (!$session->has('cart')) {
            $session->set('cart', []);
            $cart = [];
        } else {
            $cart = $session->get('cart');
        }
        if (isset($cart['products'][$product->id])) {
            if ($cart['products'][$product->id]['count'] > $count) {
                $count = $cart['products'][$product->id]['count'] - $count;
                $cart['products'][$product->id]['count'] = $count;
            } elseif ($cart['products'][$product->id]['count'] == $count) {
                unset($cart['products'][$product->id]);
            }
        }
        $amount = 0.0;
        if (isset($cart['products'])) {
            foreach ($cart['products'] as $item) {
                $amount = $amount + $item['price'] * $item['count'];
            }
        }
        $cart['amount'] = $amount;
        $session->set('cart', $cart);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionCart()
    {
        $models = Yii::$app->session->get('cart');
        $order = new Order();
        $order->status = Order::STATUS_NEW;
        $order->full_amount = $models['amount'];
        if (Yii::$app->request->post('radio') == 1) {
            $order->payment_type = 1;
        } else {
            $order->payment_type = 2;
        }
        if ($order->load(Yii::$app->request->post())) {
            $order->order_item = $models['products'];
            if ($order->save())
                return $this->redirect('success?orderId='.$order->id);
        }
        return $this->render('cart', [
            'models' => $models,
            'order' => $order
        ]);
    }

    public function actionSuccess($orderId)
    {
        Yii::$app->session->destroy();
        $order = Order::findOne(['id' => (int)$orderId]);
        $params = Yii::$app->params;
        if ($order['email']) {
            Yii::$app->mailer->compose(['html' => 'Order-html'], ['order' => $order])
                ->setFrom([$params['robotEmail'] => $params['robotName']])
                ->setTo($order->email)
                ->setSubject('Заказ принят')
                ->send();
        }
        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'order',
            'value' => null,
        ]));

        return $this->render('success', ['orderId' => $order['id']]);
    }

    public function actionFail()
    {
        return $this->render('fail');
    }

    public function actionSearch()
    {
        $slidersBottom = Slider::find()
            ->where(['status' => (string)Slider::STATUS_ACTIVE])
            ->andWhere(['slider_position' => (string)Slider::POSITION_BOTTOM])
            ->all();
        $slidersBottom = array_chunk($slidersBottom, 2);
        $search = trim(Yii::$app->request->get('search'));
        if ($search == '') {
            $search = 'Empty';
        }
        $query = Product::find()->where(['like', 'title', $search])->andWhere(['status' => (string)Product::STATUS_ACTIVE]);
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 12,
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);
        $products = $query
            ->orderBy(['title' => SORT_DESC])
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('search', compact('products', 'search', 'slidersBottom', 'pages'));
    }

    public function actionCategorySearch()
    {
        $slidersBottom = Slider::find()
            ->where(['status' => (string)Slider::STATUS_ACTIVE])
            ->andWhere(['slider_position' => (string)Slider::POSITION_BOTTOM])
            ->all();
        $slidersBottom = array_chunk($slidersBottom, 2);
        $search = trim(Yii::$app->request->get('id'));
        if ($search == '') {
            $search = 'Empty';
        }
        $query = Product::find()->where(['category_id' => (string)$search])->andWhere(['status' => (string)Product::STATUS_ACTIVE]);
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 12,
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);
        $products = $query
            ->orderBy(['title' => SORT_DESC])
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $categories = Product::getParentCategory(Yii::$app->request->get('id'));
        return $this->render('search', compact('products', 'pages', 'search', 'categories', 'slidersBottom'));
    }

    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => (int)$id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('faq', 'The requested page does not exist.'));
    }
}
