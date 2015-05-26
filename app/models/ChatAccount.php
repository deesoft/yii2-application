<?php

namespace app\models;

/**
 * Description of Chat
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class ChatAccount extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%chat_account}}';
    }
}