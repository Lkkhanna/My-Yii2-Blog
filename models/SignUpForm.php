<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;

class SignUpForm extends \yii\db\ActiveRecord
{
    public $username;
    public $password;
    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'password_repeat'], 'required'],
            [['username', 'password', 'password_repeat'], 'string', 'min' => 4, 'max' => 16],
            ['password_repeat', 'compare', 'compareAttribute' => 'password']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function signup()
    {
        $user = new User();
        $user->username = $this->username;
        $user->password = \Yii::$app->security->generatePasswordHash($this->password);
        $user->access_token = \Yii::$app->security->generateRandomString();
        $user->auth_key = \Yii::$app->security->generateRandomString();
        $user->created_at = date('Y-m-d h:i:s');

        if ($user->save()) {
            return true;
        }
        \Yii::error('User was not saved' . VarDumper::dumpAsString($user->errors));
        return false;
    }
}
