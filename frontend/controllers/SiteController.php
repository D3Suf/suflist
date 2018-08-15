<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\PromoCode;
use common\models\User;
use frontend\models\Company;
use frontend\models\Timerday;
use frontend\models\Timertotal;
use frontend\models\Alert;
use frontend\models\Control;
use common\models\PasswordForm;
use frontend\models\ImgTable;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'promocode', 'suflist', 'newcompany', 'step1', 'step2', 'newoffice', 'home', 'step3', 'complete', 'view-user', 'changepassword', 'alert', 'info'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'promocode', 'suflist', 'newcompany', 'step1', 'step2', 'newoffice', 'home', 'step3', 'complete', 'view-user', 'changepassword', 'alert', 'info'],
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
     * @inheritdoc
     */
    public function actions() {
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
    public function actionIndex() {
        if (!Yii::$app->user->isGuest) {
            $id = Yii::$app->user->id;
            $username = Yii::$app->user->identity->username;
            $ceo = Yii::$app->user->identity->ceo;
            $company = Yii::$app->user->identity->company;
            $setup2 = Yii::$app->user->identity->n_func;
//            var_dump($setup2);
//            die;
            if ($ceo == 2) {
// se ele tem setup completo e é ceo; ceo = 2 e emprese = 'nome da empresa'
//IR PARA O PROFILE
                $username = self::urlTitle($username);
                return $this->redirect(['view-user', 'id' => $id, 'slug' => $username]);
            } elseif ($ceo == 1 && $company != 'insert company' && $setup2 != '0') {

                return $this->redirect('step3');
            } elseif ($ceo == 0 && $company != 'insert company') {
// se ele é funcionario ceo = 0 e empresa = 'nome da empresa'
                $username = self::urlTitle($username);
                return $this->redirect(['view-user', 'id' => $id, 'slug' => $username]);
            } else {
                return $this->redirect('setup');
            }
        } else {
            return $this->redirect('login');
        }
    }

    public function actionLoginUser() {
        $this->layout = 'login';
        return $this->render('login-user');
    }

    public function actionSuflist() {
        $this->layout = "setup";
        return $this->render('suflist');
    }

    public function actionStep1() {
        $this->layout = "setup";
        if (Yii::$app->user->identity->n_func == '0' && Yii::$app->user->identity->ceo != '0') {
            $model = User::find()
                    ->where(['id' => Yii::$app->user->id])
                    ->one();

            $value = Company::find()
                    ->where(['nome_ceo' => Yii::$app->user->id])
                    ->one();
            if (empty($value)) {
                $value = 'empty';
            }

            return $this->render('step1', [
                        'model' => $model,
                        'value' => $value,
            ]);
        } else {
            return $this->goHome();
        }
    }

    public function actionStep2() {
        $id = Yii::$app->user->id;
        if (Yii::$app->user->identity->n_func == '0') {
            $company = Company::find()
                    ->where(['nome_ceo' => $id])
                    ->one();
            if (!empty($company)) {
                $this->layout = "step2";
                return $this->render('step2', [
                            'company' => $company,
                ]);
            } else {
                return $this->goHome();
            }
        } else {
            return $this->goHome();
        }
    }

    public function actionStep3() {
        if (Yii::$app->user->identity->n_func != 0) {
            $this->layout = 'setup';
            return $this->render('step3');
        } else {
            return $this->goHome();
        }
    }

    public function action403() {
        $this->layout = 'error';
        return $this->render('403');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin() {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//old
//            return $this->goBack();
//tentativa
            return $this->goHome();
        } else {
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
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
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
    public function actionAbout() {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {
        $this->layout = 'login';
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->redirect('setup');
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
    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
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
    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    public function refresh($anchor = '') {
        return Yii::$app->getResponse()->redirect(Yii::$app->getRequest()->getUrl() . $anchor);
    }

    public static function randomPassword() {
        $length = 10;
        $chars = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        shuffle($chars);
        $password = implode(array_slice($chars, 0, $length));

        return $password;
    }

//função de envio de emails
    public static function sendEmail($email, $password, $companyname, $username) {
        $email = \Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom('noreplyiconsulting.group@gmail.com')
                ->setCc('carlos.sousa@iconsulting-group.com')
                ->setSubject('Bem vindo ao MySchedule')
                ->setHtmlBody('<b>A partir de agora já pode usar a sua conta MySchedule</b> <br>'
                        . 'Username: ' . $username . ' <br/> Email: ' . $email . '<br/> Password: ' . $password . '<br/>'
                        . 'Faz parta da equipa <strong> ' . $companyname . ' </strong> <br/> '
                        . ' Seja Muito bem vindo! faça login em <a href="www.myschedule.iconsulting-group.com">www.myschedule.iconsulting-group.com</a> ')
                ->send();
    }

    public function actionPromocode() {
        $request = Yii::$app->request;
        $code = $request->post('pwd');

        if (!empty($code)) {

            $promo = PromoCode::find()
                    ->where(['code_name' => $code])
                    ->one();

            if (!empty($promo)) {
//criar o ceo
                $id = Yii::$app->user->id;
                $user = User::find()
                        ->where(['id' => $id])
                        ->one();
                $user->ceo = '1';
                $user->save();

                return $this->redirect('../step1');
            } else {
                \Yii::$app->getSession()->setFlash('error', '
                    <div class="alert alert-danger text-center">
                    <strong> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Codigo invalido! <br> </strong> Tente novamente.
                    </div>');
                return $this->redirect('../setup');
            }
        } else {
            return $this->redirect('../setup');
        }
    }

    public function actionNewcompany() {
        if (!Yii::$app->user->isGuest) {
            $request = Yii::$app->request;
            $nome = $request->post('nome');
            $nfuncionarios = $request->post('funcionarios');
            $hentrada = strtotime($request->post('start_time'));
            $hsaida = strtotime($request->post('end_time'));
            $nsemanal = $request->post('hsemanal');
//falta garantir que os valores não vem a null ( verificar o isset) ***************************************
            $id = Yii::$app->user->id;
            $ceo = Yii::$app->user->identity->ceo;

            if ($ceo == '1' && $nome != 'insert company') {
                $user = User::find()
                        ->where(['id' => $id])
                        ->one();

                $user->company = $nome;
                $user->save();

                $com = Company::find()
                        ->where(['nome_ceo' => $id])
                        ->one();
                if (!empty($com)) {
                    $com->nome = $nome;
                    $com->nome_ceo = $id;
                    $com->n_funcionarios = $nfuncionarios;
                    $com->h_trabalho_s = $nsemanal;
                    $com->h_inicio = $hentrada;
                    $com->h_final = $hsaida;
                    $com->save();
                } else {
                    $company = new Company;
                    $company->nome = $nome;
                    $company->nome_ceo = $id;
                    $company->n_funcionarios = $nfuncionarios;
                    $company->h_trabalho_s = $nsemanal;
                    $company->h_inicio = $hentrada;
                    $company->h_final = $hsaida;
                    $company->save();
                }

                return $this->redirect('../step2');
            } else {
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            return $this->redirect('login');
        }
    }

    public function actionNewoffice() {
        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->user->identity->n_func == '0') {
                $id = Yii::$app->user->id;

                $company = Company::find()
                        ->where(['nome_ceo' => $id])
                        ->one();

                $y = $company->n_funcionarios;
                $request = Yii::$app->request;
                for ($y; $y != 0; $y--) {
                    $email = $request->post($y);
//verificar se email existe
                    $Usernewfind = User::find()
                            ->where(['email' => $email])
                            ->one();
                    if (empty($Usernewfind)) {
                        $password = SiteController::randomPassword();
                        $parts = explode("@", $email);
                        $username = $parts[0];
                        $username = str_replace('.', ' ', $username);
                        $username = str_replace('_', ' ', $username);
                        $username = str_replace('-', ' ', $username);
                        $companyname = $company->nome;

                        $user = new User;
                        $user->username = $username;
                        $user->setPassword($password);
                        $user->email = $email;
                        $user->company = $company->nome;
                        $user->generateAuthKey();
                        $user->save();

                        SiteController::sendemail($email, $password, $companyname, $username);
                    } else {

                        \Yii::$app->getSession()->setFlash('aviso', '
                        <div class="alert alert-danger text-center">
                        <strong> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Está a usar um email que já está inserido no sistema</strong>.
                        </div>');

                        return $this->redirect(Yii::$app->request->referrer);
                    }
                }

                $User = User::find()
                        ->where(['id' => $id])
                        ->one();
                $User->n_func = $company->n_funcionarios;
                $User->save();

                return $this->redirect('../step3');
            } else {
                return $this->goHome();
            }
        } else {
            return $this->redirect('login');
        }
    }

    public function actionComplete() {
        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->user->identity->n_func != '0') {
                $id = Yii::$app->user->id;
                $username = Yii::$app->user->identity->username;
                $request = Yii::$app->request;
                $ip = $request->post('ip');
                $check = $request->post('checkt');
                if ($check == 1) {
                    $user = User::find()
                            ->where(['id' => $id])
                            ->one();
                    $user->ceo = 2;
                    $user->save();

                    $company = Company::find()
                            ->where(['nome_ceo' => $id])
                            ->one();

                    $company->ip_company = $ip;
                    $company->save();

                    $username = self::urlTitle($username);
                    return $this->redirect(['view-user', 'id' => $id, 'slug' => $username]);
                } else {
                    return $this->redirect('../step3');
                }
            } else {
                return $this->goHome();
            }
        } else {
            return $this->redirect('login');
        }
    }

    public static function getRealIp() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

// user page
//find
    protected function findModeluser($id) {
        if (($model = User::findOne($id)) !== NULL) {
            return $model;
        } else {
            throw new NotFoundHttpException('The request page does not exist.');
        }
    }

//view old
//    public function actionViewUser($id, $slug) {
//        $horas_semana = self::getHorasbyweek(); // chamar funções staticas dentro do proprio controlador
//
//        if (!empty($horas_semana)) {
//            $array = ['Segunda' => date('G.i', $horas_semana->monday), 'Terça' => date('G.i', $horas_semana->tuesday), 'Quarta' => date('G.i', $horas_semana->wednesday), 'Quinta' => date('G.i', $horas_semana->thursday), 'Sexta' => date('G.i', $horas_semana->friday)];
//
//            $vars = json_encode($array);
//        } else {
//            $array = ['Segunda' => 0, 'Terça' => 0, 'Quarta' => 0, 'Quinta' => 0, 'Sexta' => 0];
//
//            $vars = json_encode($array);
//            $horas_semana = 0;
//        }
//
////        var_dump($array);
////        die;
//        return $this->render('view-user', [
//                    'model' => $this->findModeluser($id),
//                    'value' => $vars,
//                    'horas_semana' => $horas_semana,
//        ]);
//    }


    public function actionViewUser($id, $slug) {
//semana atual 
        $horas_semana = self::getHorasbyweek(0);
        $arrayBar = [];
        $diasSemana = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta'];
        $i = 0;
        if (!empty($horas_semana)) {
            foreach ($horas_semana as $seconds) {
                if (!is_null($seconds)) {
                    if ($seconds != 0) {
                        $minutes = round($seconds / 60); //seconds to minutes
                        $hours = floor($minutes / 60); //get hours from minutes
                        $fminutes = ($minutes - $hours * 60); //get minutes
                        if ($fminutes > 0 && $fminutes <= 9) {
                            $fminutes = "0" . $fminutes;
                        }
                        $hoursMinutes = $hours . '.' . $fminutes;
                    } else {
                        $hoursMinutes = 0;
                    }
                    $arrayBar[$diasSemana[$i++]] = $hoursMinutes;
                }
            }
        } else {
            $arrayBar = ['Segunda' => 0, 'Terça' => 0, 'Quarta' => 0, 'Quinta' => 0, 'Sexta' => 0];
        }

        $bars = json_encode($arrayBar);
        $total_semana = self::getTotalbyweekatual();
        $total_semanapassada = self::getTotalbyweekpassada();
        $n_saida = self::getsaidabyuser($id);
        $n_atraso = self::getAtrasobyuser($id);
        //media da semana
        $horas_falta = self::getHorasfalta($id);
//        $m_hsemana = self::getMediaweek($id);
//após o primeiro uso da plataforma retirar esta funcão
//        self::getUserphoto();
//        self::getPasswordrita();
//        self::addNewuser();
        return $this->render('view-user', [
                    'model' => $this->findModeluser($id),
                    'value' => $bars,
                    'horas_semana' => $horas_semana,
                    'total_semana' => $total_semana,
                    'total_semanapassada' => $total_semanapassada,
                    'n_saida' => $n_saida,
                    'n_atraso' => $n_atraso,
                    'horas_falta' => $horas_falta,
//                    'm_hsemana' => $m_hsemana,
        ]);
    }

    public static function getTimerday($id) {
        $model = Timerday::find()
                ->where(['id_user' => $id])
                ->one();
        return $model;
    }

//h-inicio da company
    public static function getHinicompany() {
        $company_name = Yii::$app->user->identity->company;
        $model = Company::find()
                ->where(['nome' => $company_name])
                ->one();

        $horainicio = $model->h_inicio;


        return $horainicio;
    }

//h-final da company
    public static function getHfinalcompany() {
        $company_name = Yii::$app->user->identity->company;
        $model = Company::find()
                ->where(['nome' => $company_name])
                ->one();
        $horafinal = $model->h_final;

        return $horafinal;
    }

//ip from company
    public static function getIpcompany() {
        $namecompany = Yii::$app->user->identity->company;
        $company = Company::find()
                ->where(['nome' => $namecompany])
                ->one();

        $ipcompany = $company->ip_company;
        return $ipcompany;
    }

    public function actionStart($id) {
        if ($id == Yii::$app->user->id) {
            $realip = self::getRealIp();
            $companyip = self::getIpcompany();
            if ($realip == $companyip) {
                $model = Timerday::find()
                        ->where(['id_user' => $id])
                        ->one();

                if (!empty($model)) {
// já deu start uma vez
                    $model->h_inicio = time();
                    $model->status = 'start';
                    $model->save();

                    return $this->redirect(Yii::$app->request->referrer);
                } else {
                    $model = new Timerday();
                    $model->id_user = $id;
                    $model->h_inicio = time();
                    $model->status = 'start';
                    $horainicio = SiteController::getHinicompany();
                    $horainiciov1 = date('H:i', $horainicio);
                    $horafinal = self::getHfinalcompany();
                    $horafinalv1 = date('H:i', $horafinal);
                    if ($model->h_inicio < strtotime($horafinalv1)) {
                        if ($model->h_inicio >= strtotime($horainiciov1)) {
//já passa da hora de entrada
                            $model->dia = date('l', time());
                            $model->save();

//criar alerta de atraso
                            $company_user = Yii::$app->user->identity->company;
                            $value = Company::find()
                                    ->where(['nome' => $company_user])
                                    ->one();

                            $alert = new Alert();
                            $alert->id_user = $id;
                            $alert->id_ceo = $value->nome_ceo;
                            $alert->date_alert = time();
                            $alert->type = 'Atraso';
                            $alert->check_alert = 'Aberto';
                            $alert->from_to = date('d', time());
                            $alert->save();

//após passagem da hora enviar mensagem de atraso e criar um alerta para o ceo da empresa com a data hora que o funcionario se atrásou
                            \Yii::$app->getSession()->setFlash('aviso', '
                    <div class="alert alert-warning text-center">
                    <strong> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Atenção está atrasado.</strong>.
                    <a class="modal-with-form btn btn-warning" href="#atraso">Justifique</a>
                    </div>');

                            return $this->redirect(Yii::$app->request->referrer);
                        } else {
                            $model->dia = date('l', time());
                            $model->save();
                            Yii::$app->getSession()->setFlash('success', [
                                'title' => 'Bom Trabalho',
                            ]);

                            return $this->redirect(Yii::$app->request->referrer);
                        }
                    } else {
                        Yii::$app->getSession()->setFlash('error', [
                            'title' => 'Atenção já passa da hora de saida. Já não é permitido iniciar o dia, volte amanha',
                        ]);

                        return $this->redirect(Yii::$app->request->referrer);
                    }
                }
            } else {
//go to 403 not found
                return $this->redirect(['site/403']);
            }
        } else {
// go to 403 not found
            return $this->redirect(['site/login']);
        }
    }

    public function actionPause($id) {
        if ($id == Yii::$app->user->id) {
            $realip = self::getRealIp();
            $companyip = self::getIpcompany();
            if ($realip == $companyip) {
                $model = Timerday::find()
                        ->where(['id_user' => $id])
                        ->one();

                if (!empty($model) && $model->status == 'start') {
                    $model->h_pausa = time();
                    $model->h_total += ($model->h_pausa - $model->h_inicio);
                    $model->status = 'pause';
                    $model->save();

                    return $this->redirect(Yii::$app->request->referrer);
                }
            } else {
//go to 403 not found
                return $this->redirect(['site/403']);
            }
        } else {
// go to 403 not found
            return $this->redirect(['site/login']);
        }
    }

    public function actionFinish($id) {
        if ($id == Yii::$app->user->id) {
            $realip = self::getRealIp();
            $companyip = self::getIpcompany();
            if ($realip == $companyip) {
                $hora_final = SiteController::getHfinalcompany();
                $hora_finalv1 = date('H:i', $hora_final);
                $hora_final = strtotime($hora_finalv1);

                $model = Timerday::find()
                        ->where(['id_user' => $id])
                        ->one();

                if (!empty($model) && $model->status == 'start') {
                    if ($hora_final <= time()) {
                        if (!empty($model->h_pausa)) {
                            $model->h_final = time();
                            $model->h_total = ((time() - $model->h_inicio) + $model->h_total);
                            $model->status = 'finish';
                            $model->h_check = 1;
                            $model->save();
                            Yii::$app->getSession()->setFlash('success', [
                                'title' => 'Dia fechado com sucesso',
                            ]);
                        } else {
                            $model->h_final = time();
                            $model->h_total += ($model->h_final - $model->h_inicio);
                            $model->status = 'finish';
                            $model->h_check = 1;
                            $model->save();
                            Yii::$app->getSession()->setFlash('success', [
                                'title' => 'Dia fechado com sucesso',
                            ]);
                        }
                    } else {
                        if (!empty($model->h_pausa)) {
                            $model->h_final = time();
                            $model->h_total = ((time() - $model->h_inicio) + $model->h_total);
                            $model->status = 'finish';
                            $model->h_check = 1;
                            $model->save();
                        } else {
                            $model->h_final = time();
                            $model->h_total += ($model->h_final - $model->h_inicio);
                            $model->status = 'finish';
                            $model->h_check = 1;
                            $model->save();
                        }

//create alert saida
                        $company_user = Yii::$app->user->identity->company;

                        $value = Company::find()
                                ->where(['nome' => $company_user])
                                ->one();

                        $alert = new Alert();
                        $alert->id_user = $id;
                        $alert->id_ceo = $value->nome_ceo;
                        $alert->date_alert = time();
                        $alert->type = 'Saida antes da hora';
                        $alert->check_alert = 'Aberto';
                        $alert->from_to = date('d', time());
                        $alert->save();


                        \Yii::$app->getSession()->setFlash('aviso', '
                    <div class="alert alert-danger text-center">
                    <strong> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Atenção está a terminar o dia antes da hora</strong>.
                    <a class="modal-with-form btn btn-danger" href="#saida">Justifique a sua saida</a>
                    </div>');
                    }

                    return $this->redirect(Yii::$app->request->referrer);
                }
            } else {
// go to 403 not found
                return $this->redirect(['site/403']);
            }
        } else {
// go to 403 not found
            return $this->redirect(['site/login']);
        }
    }

    public static function deleteTimer($model, $id) {

        $value = new Timertotal();

        $value->id_user = $id;
        $value->data_inicio = $model->data_insert;
        $value->hs_total = $model->h_total;
        $value->day = $model->dia;
        $value->week = date('W', $model->h_inicio);
        $value->save();

        $model->delete();
        Yii::$app->controller->refresh();
    }

    public function actionAtraso() {
        $id = Yii::$app->user->id;
        $request = Yii::$app->request;

        $alert = Alert::find()
                ->where(['id_user' => $id, 'from_to' => date('d', time()), 'type' => 'Atraso'])
                ->one();

        if (!empty($alert)) {

            $alert->obs = $request->post('motivo');
            $alert->save();
            Yii::$app->getSession()->setFlash('success', [
                'title' => 'Justificação enviada com sucesso.',
            ]);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSaida() {
        $id = Yii::$app->user->id;
        $request = Yii::$app->request;

        $alert = Alert::find()
                ->where(['id_user' => $id, 'from_to' => date('d', time()), 'type' => 'Saida antes da hora'])
                ->one();

        if (!empty($alert)) {

            $alert->obs = $request->post('motivo');
            $alert->save();
            Yii::$app->getSession()->setFlash('success', [
                'title' => 'Justificação enviada com sucesso.',
            ]);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionNoclose() {
        $id_user = Yii::$app->user->id;
        $company_user = Yii::$app->user->identity->company;

        $request = Yii::$app->request;

        $value = Company::find()
                ->where(['nome' => $company_user])
                ->one();

        $model = Timerday::find()
                ->where(['id_user' => $id_user])
                ->one();

        $alert = new Alert();
        $alert->id_user = $id_user;
        $alert->id_ceo = $value->nome_ceo;
        //receber o dia que trabalhou.
        $diatrabalho = date('Y-m-d', $model->h_inicio);
        $horatrabalho = date('H:i:s', $model->h_inicio);
        $inputuser = $request->post('hora_final');
        //verificar hora
        $horamaxima = '23:58';
        if ((strtotime($horamaxima) < strtotime($inputuser)) || (strtotime($horatrabalho) > strtotime($inputuser))) {
            Yii::$app->getSession()->setFlash('error', [
                'title' => 'A hora introduzida não é valida',
            ]);

            return $this->redirect(Yii::$app->request->referrer);
        }
        $horaediainput = ($diatrabalho . ' ' . $inputuser);
        $alert->date_alert = strtotime($horaediainput);

        $alert->obs = $request->post('motivo');
        $alert->type = 'Não fechou o dia';
        $alert->check_alert = 'Aberto';
        $alert->h_inicio = $model->h_inicio;
        if (!empty($model->h_pausa)) {
            $alert->h_pausa = $model->h_pausa;
            $alert->h_final = strtotime($horaediainput);
            $alert->h_total = (($alert->h_final - $alert->h_inicio) + $model->h_total);
        } else {
            $alert->h_pausa = $model->h_pausa;
            $alert->h_final = strtotime($horaediainput);
            $alert->h_total = (($alert->h_final - $alert->h_inicio));
        }
        $alert->save();

        Yii::$app->getSession()->setFlash('success', [
            'title' => 'Dia Fechado com sucesso. É necessario a confirmação do CEO.',
        ]);

        $model->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

//verificar dia
    public static function checkDay($value, $control) {
        if ($value->day == 'Monday' && empty($control->monday)) {
            $control->monday = $value->hs_total;
            $control->h_total += $control->monday;
            $control->update();
            Yii::$app->controller->refresh();
        } elseif ($value->day == 'Tuesday' && empty($control->tuesday)) {
            $control->tuesday = $value->hs_total;
            $control->h_total += $control->tuesday;
            $control->update();
            Yii::$app->controller->refresh();
        } elseif ($value->day == 'Wednesday' && empty($control->wednesday)) {
            $control->wednesday = $value->hs_total;
            $control->h_total += $control->wednesday;
            $control->update();
            Yii::$app->controller->refresh();
        } elseif ($value->day == 'Thursday' && empty($control->thursday)) {
            $control->thursday = $value->hs_total;
            $control->h_total += $control->thursday;
            $control->update();
            Yii::$app->controller->refresh();
        } elseif ($value->day == 'Friday' && empty($control->friday)) {
            $control->friday = $value->hs_total;
            $control->h_total += $control->friday;
            $control->update();
            Yii::$app->controller->refresh();
        }
    }

//verificar dia
    public static function checkDayv2($value) {
        $control = new Control();
        $control->id_user = $value->id_user;
        $control->week = $value->week;
        if ($value->day == 'Monday') {
            $control->monday = $value->hs_total;
            $control->h_total += $control->monday;
            $control->save();
            Yii::$app->controller->refresh();
        } elseif ($value->day == 'Tuesday') {
            $control->tuesday = $value->hs_total;
            $control->h_total += $control->tuesday;
            $control->save();
            Yii::$app->controller->refresh();
        } elseif ($value->day == 'Wednesday') {
            $control->wednesday = $value->hs_total;
            $control->h_total += $control->wednesday;
            $control->save();
            Yii::$app->controller->refresh();
        } elseif ($value->day == 'Thursday') {
            $control->thursday = $value->hs_total;
            $control->h_total += $control->thursday;
            $control->save();
            Yii::$app->controller->refresh();
        } elseif ($value->day == 'Friday') {
            $control->friday = $value->hs_total;
            $control->h_total += $control->friday;
            $control->save();
            Yii::$app->controller->refresh();
        }
    }

//verificar week
    public static function addWeek() {
        $Timertotal = Timertotal::find()
                ->all();

        foreach ($Timertotal as $value) {

            $control = Control::find()
                    ->where(['week' => $value->week, 'id_user' => $value->id_user])
                    ->one();

            if (empty($control)) {
//criar a semana e utilizadores 
                self::checkDayv2($value);
            } else {
                self::checkDay($value, $control);
            }
        }
    }

//chnage user password
    public function actionChangepassword() {
        $model = new PasswordForm;
        $user = User::find()
                ->where(['id' => Yii::$app->user->id])
                ->one();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                try {
                    $user->setPassword($model->newpassword);
                    if ($user->save()) {
                        Yii::$app->getSession()->setFlash('success', [
                            'title' => 'Password trocada com sucesso.',
                        ]);
                        return $this->goHome();
                    }
                } catch (Exception $ex) {
                    Yii::$app->getSession()->setFlash('error', [
                        'title' => 'Erro ao trocar a password',
                    ]);
                    return $this->render('changepassword', [
                                'model' => $model
                    ]);
                }
            } else {
                return $this->render('changepassword', [
                            'model' => $model
                ]);
            }
        } else {
            return $this->render('changepassword', [
                        'model' => $model
            ]);
        }
    }

//para escolher a week que quero visualizar
    public static function getHorasbyweek($removeweek) {
        $thisweek = date('W', time()) - $removeweek;
        $id = Yii::$app->user->id;
        $control = Control::find()
                ->select(['monday', 'tuesday', 'wednesday', 'thursday', 'friday'])
                ->where(['id_user' => $id, 'week' => $thisweek])
                ->one();
        return $control;
    }

    public static function getTotalbyweekatual() {
        $thisweek = date('W', time());
        $id = Yii::$app->user->id;
        $control = Control::find()
                ->select(['h_total'])
                ->where(['id_user' => $id, 'week' => $thisweek])
                ->one();

        if (!empty($control)) {
            $horas = $control->h_total / 3600;
            $control = (100 * $horas) / 40;
        } else {
            $control = 0;
        }

        return $control;
    }

    public static function getTotalbyweekpassada() {
        $thisweek = date('W', time()) - 1;
        $id = Yii::$app->user->id;
        $control = Control::find()
                ->select(['h_total'])
                ->where(['id_user' => $id, 'week' => $thisweek])
                ->one();

        if (!empty($control)) {
            $horas = $control->h_total / 3600;
            $control = (100 * $horas) / 40;
        } else {
            $control = 0;
        }

        return $control;
    }

//saida antes da hora
    public static function getSaidabyuser($id) {
        $saida = Alert::find()
                ->where(['id_user' => $id, 'type' => 'Saida antes da hora'])
                ->all();

        $saida = count($saida);
        return $saida;
    }

//chegou atrasado
    public static function getAtrasobyuser($id) {
        $atraso = Alert::find()
                ->where(['id_user' => $id, 'type' => 'Atraso'])
                ->all();

        $atraso = count($atraso);
        return $atraso;
    }

    public function actionAlert() {
        $id = Yii::$app->user->id;
        $role = Yii::$app->user->identity->ceo;
        if ($role == '2') {
//render
            $alert = Alert::find()
                    ->orderBy('id DESC')
                    ->where(['id_ceo' => $id, 'check_alert' => 'Aberto'])
                    ->all();

            return $this->render('alert', [
                        'model' => $alert,
            ]);
        } else {
// go to 403 not found
            return $this->redirect(['site/403']);
        }
    }

//verificar conta e adicionar imagem de perfil
//    public static function getUserphoto() {
//        $allphotos = ImgTable::find()
//                ->all();
//
//        foreach ($allphotos as $value) {
//            $user = User::find()
//                    ->where(['email' => $value->email])
//                    ->one();
//            if (!empty($user) && $user->photo == 'default-profile') {
//                $user->photo = $value->facebook_id;
//                $user->update();
//                Yii::$app->controller->refresh();
//            }
//        }
//    }
//media de horas por semana
    public static function getMediaweek($id) {
        $control = Control::find()
                ->where(['id_user' => $id])
                ->all();

        if (!empty($control)) {
            $nsemana = count($control);
            $nhoras = 0;
            foreach ($control as $value) {
                $nhoras += $value->h_total;
            }
            $media = $nhoras / $nsemana;
            $hmedia = round($media / 3600);
        } else {
            $hmedia = 0;
        }


        return $hmedia;
    }

//função preparar url title
    public static function urlTitle($title) {
        $from = explode(',', "ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,(,),[,],'");
        $to = explode(',', 'c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,,,,,,');
        $title = strtolower(str_replace($from, $to, trim($title)));
        $title = str_replace(' ', '-', $title);
        $title = str_replace('?', '', $title);
        $title = str_replace('---', '-', $title);

        return $title;
    }

//    public static function getPasswordrita() {
//        $User = User::find()
//                ->where(['id' => '98'])
//                ->one();
//
//        $password = 'Croma';
//        $User->setPassword($password);
//        $User->save();
//    }
//função de getlunch
//    public static function getLunch($model) {
//        if (!empty($model->h_pausa)) {
//            $model->h_pausa = strtotime('12:45:00');
//            $startlunch = strtotime('12:30:00');
//            $finishlunch = strtotime('14:30:00');
//            $pospausa = $model->h_pausa + (strtotime('+45 minute'));
////            $atual = time();
//            $atual = strtotime('13:45:00');
//
//            var_dump(date('H:i:s', ($model->h_pausa)));
//            var_dump(date('H:i:s', ($startlunch)));
//            var_dump(date('H:i:s', ($finishlunch)));
//            var_dump(date('H:i:s', ($pospausa)));
//            var_dump(date('H:i:s', ($atual)));
//            die;
//            if ($model->h_pausa >= $startlunch && $model->h_pausa <= $finishlunch && $apospausa <= $atual) {
//                var_dump($apospausa);
//                die;
//            }
//        }
//    }
    //função para ver em que dia foi o alerta
    public static function getAlertday($alert) {
        $thisday = date('d', time());
        $dayalert = date('d', $alert);

        if ($thisday == $dayalert) {
            return TRUE;
        }
    }

    public function actionValidardia($id) {
        $alerta = Alert::find()
                ->where(['id' => $id])
                ->one();

        $value = new Timertotal();

        $value->id_user = $alerta->id_user;
        $value->data_inicio = date('Y-m-d H:i:s', $alerta->h_inicio);
        $value->hs_total = $alerta->h_total;
        $value->day = date('l', $alerta->h_inicio);
        $value->week = date('W', $alerta->h_inicio);
        $value->save();

        $alerta->delete();

        Yii::$app->getSession()->setFlash('success', [
            'title' => 'Alerta validado com sucesso.',
        ]);

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionNaovalidardia($id) {
        $alert = Alert::find()
                ->where(['id' => $id])
                ->one();

        $value = new Timertotal();

        $value->id_user = $alert->id_user;
        $value->data_inicio = date('Y-m-d H:i:s', $alert->h_inicio);
        $userinput = $alert->h_final;
        $diainput = date('Y-m-d', $alert->h_inicio);
        $hora_final = date('H:i', self::getHfinalcompany());
        $horauser = strtotime(($diainput . ' ' . $hora_final));
        $dif = $userinput - $horauser;
        $h_total = $alert->h_total - $dif;
        $value->hs_total = $h_total;
        $value->day = date('l', $alert->h_inicio);
        $value->week = date('W', $alert->h_inicio);
        $value->save();

        $alert->delete();

        Yii::$app->getSession()->setFlash('success', [
            'title' => 'Alerta não validado com sucesso.',
        ]);

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionValidaratraso($id) {
        $alerta = Alert::find()
                ->where(['id' => $id])
                ->one();
        $request = Yii::$app->request;

        $horainputceo = $request->post('hora_chegada');
        ///verificação
        $diareal = date('Y-m-d', strtotime($alerta->data_insert));
        $horareal = date('H:i', strtotime($alerta->data_insert));
        $horausar = ($diareal . ' ' . $horainputceo);

        if (strtotime($horausar) < strtotime($alerta->data_insert)) {
            $dif = (strtotime($alerta->data_insert)) - (strtotime($horausar));

            $timerday = Timerday::find()
                    ->where(['id_user' => $alerta->id_user])
                    ->one();

            if (!empty($timerday) && (date('Y-m-d', strtotime($timerday->data_insert)) == date('Y-m-d', strtotime($alerta->data_insert)))) {
                $timerday->data_insert = $horausar;
                $timerday->h_total = $timerday->h_total + $dif;
                $timerday->save();

                $alerta->delete();

                Yii::$app->getSession()->setFlash('success', [
                    'title' => 'Alerta validado com sucesso.',
                ]);

                return $this->redirect(Yii::$app->request->referrer);
            } elseif ((self::getAlertnoclose($horausar, $alerta->id_user)) == TRUE) {
                Yii::$app->getSession()->setFlash('error', [
                    'title' => 'Existe um alerta do tipo "Não fechou o dia", execute uma acção sobre esse mesmo alerta primeiro.',
                ]);

                return $this->redirect(Yii::$app->request->referrer);
            } else {
                $timertotal = Timertotal::find()
                        ->where(['id_user' => $alerta->id_user])
                        ->all();

                if (!empty($timertotal)) {
                    foreach ($timertotal as $daytimer) {
                        if ((date('Y-m-d', strtotime($daytimer->data_inicio)) == date('Y-m-d', strtotime($alerta->data_insert)))) {

                            $daytimer->data_inicio = $horausar;
                            $daytimer->hs_total = $daytimer->hs_total + $dif;
                            $daytimer->save();

                            $daycontrol = strtolower(date('l', strtotime($horausar)));
                            $weekcontrol = date('W', strtotime($horausar));

                            $control = Control::find()
                                    ->where(['id_user' => $alerta->id_user, 'week' => $weekcontrol])
                                    ->one();

                            if (!empty($control) && $daycontrol == 'monday' || $daycontrol == 'tuesday' || $daycontrol == 'wednesday' || $daycontrol == 'thursday' || $daycontrol == 'friday') {
                                $control->$daycontrol = $control->$daycontrol + $dif;
                                $control->h_total = $control->h_total + $dif;
                                $control->save();
                            }

                            $alerta->delete();

                            Yii::$app->getSession()->setFlash('success', [
                                'title' => 'Alerta validado com sucesso.',
                            ]);
                            return $this->redirect(Yii::$app->request->referrer);
                        }
                    }
                }
            }

            $alerta->delete();

            Yii::$app->getSession()->setFlash('error', [
                'title' => 'Alerta eliminado, não existia um "dia" associado ao mesmo',
            ]);


            return $this->redirect(Yii::$app->request->referrer);
        } else {
            // hora colocada pelo ceo maior que a hora que o utilizador chegou

            Yii::$app->getSession()->setFlash('error', [
                'title' => 'A hora introduzida não é valida',
            ]);

            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public static function getAlertnoclose($horausar, $id_user) {
        $horaausar = strtotime($horausar);

        $alertanew = Alert::find()
                ->where(['id_user' => $id_user, 'type' => 'Não fechou o dia'])
                ->all();
        if (!empty($alertanew)) {
            foreach ($alertanew as $model) {
                $x = date('Y-m-d', $model->h_inicio);
                $y = date('Y-m-d', $horaausar);
                if ($x == $y) {
                    return TRUE;
                }
            }
        } else {
            return FALSE;
        }
    }

    public function actionNaovalidaratraso($id) {
        $alerta = Alert::find()
                ->where(['id' => $id])
                ->one();

        $alerta->check_alert = 'Fechado';
        $alerta->save();

        Yii::$app->getSession()->setFlash('success', [
            'title' => 'Alerta Fechado com sucesso.',
        ]);

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionInfo() {
        $control = Control::find()
                ->orderBy('week DESC')
                ->all();

        return $this->render('info', [
                    'control' => $control,
        ]);
    }

    //função de saber as horas que faltam para terminar o dia
    public static function getHorasfalta($id) {
        //week
        $week = date('W', time());
//        $connection = Yii::$app->getDb();
//        $query = $connection->createCommand("SELECT `h_total` FROM `control` WHERE id_user = $id AND week = $week");
//
//        $horas_feitas = $query->queryAll();
//        $horas_feitas = (round($horas_feitas / 3600));
        $horasfeitas = Control::find()
                ->select('h_total')
                ->where(['id_user' => $id, 'week' => $week])
                ->one();

        $horastotal = '144000';
        if (!empty($horasfeitas)) {
            $horas_falta = ((int) $horastotal) - ((int) $horasfeitas->h_total);
            $horas_falta = round($horas_falta / 3600);
        } else {
            $horas_falta = $horastotal;
            $horas_falta = round($horas_falta / 3600);
        }
        return $horas_falta;
    }

    //adicionar utilizador
    public static function addNewuser() {
        //dados a dar do utilizador 
        //email user;
        $email = 'daniel.marques@iconsulting-group.com';
        //company name
        $companyname = 'iConsulting Group';

        $password = SiteController::randomPassword();
        $parts = explode("@", $email);
        $username = $parts[0];
        $username = str_replace('.', ' ', $username);
        $username = str_replace('_', ' ', $username);
        $username = str_replace('-', ' ', $username);

        $user = new User;
        $user->username = $username;
        $user->setPassword($password);
        $user->email = $email;
        $user->company = $companyname;
        $user->generateAuthKey();
        //userphoto
        $user->photo = '100004096655334';
        $user->save();

        SiteController::sendemail($email, $password, $companyname, $username);

        var_dump('Adicionar o Daniel');
        die;
    }

}
