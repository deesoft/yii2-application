<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Description of UserToken
 *
 * @property string $token
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class UserToken extends ActiveRecord
{
    const TOKEN_EXPIRE = 86400;
    const GC_PROBABILITY = 100; // 1%

    public function rules()
    {
        return[
            [['token', 'user_id', 'expire'], 'required'],
            [['expire'], 'integer'],
        ];
    }

    public static function tableName()
    {
        return'{{%user_token}}';
    }

    public static function getToken($user_id, $force = false)
    {
        static::gc();
        $extraParam = Yii::$app->getRequest()->getUserIP();

        $model = $force ? null : static::find()->where([
                'user_id' => $user_id,
                'param' => $extraParam,
            ])->andWhere(['>', 'expire', time()])->one();
        if ($model) {
            return $model->token;
        } else {
            $model = new static([
                'token' => Yii::$app->getSecurity()->generateRandomString(),
                'user_id' => $user_id,
                'param' => $extraParam,
                'expire' => time() + self::TOKEN_EXPIRE,
            ]);
            if ($model->save()) {
                return $model->token;
            }
        }
    }

    public static function getUser($token)
    {
        static::gc();
        $extraParam = Yii::$app->getRequest()->getUserIP();

        $model = static::find()->where([
                'token' => $token,
                'param' => $extraParam,
            ])->andWhere(['>', 'expire', time()])->one();

        if ($model) {
            return $model->user_id;
        }
    }

    public static function gc($force=false)
    {
        if ($force || mt_rand(0, 1000000) < self::GC_PROBABILITY) {
            static::deleteAll(['<','expire',time()]);
        }
    }
}