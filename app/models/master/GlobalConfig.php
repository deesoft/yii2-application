<?php

namespace app\models\master;

use Yii;

/**
 * This is the model class for table "{{%global_config}}".
 *
 * @property string $group
 * @property string $name
 * @property string $description
 * @property string $raw_value
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class GlobalConfig extends \yii\db\ActiveRecord
{
    /**
     * @var array definition
     */
    public static $schemaDefinition;

    /**
     * @var array 
     */
    private $_schema;

    /**
     * @var array
     */
    private $_values = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%global_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['group', 'name'], 'required'],
            [['group'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
        ];

        if ($this->_schema) {
            $_rules = [];
            foreach ($this->_schema as $name => $rule) {
                $_rules[$rule[0]][] = $name;
                if ($rule[1]) {
                    $_rules['required'][] = $name;
                }
            }
            foreach ($_rules as $rule => $attributes) {
                $rules[] = [$attributes, $rule];
            }
        }
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group' => 'Group',
            'name' => 'Name',
            'description' => 'Description',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        if ($this->_schema && isset($this->_schema[$name])) {
            if (array_key_exists($name, $this->_values)) {
                return $this->_values[$name];
            } else {
                return null;
            }
        }
        return parent::__get($name);
    }

    /**
     * @inheritdoc
     */
    public function __set($name, $value)
    {
        if ($name === 'group') {
            $this->_schema = static::$schemaDefinition[$value];
        }
        if ($this->_schema && isset($this->_schema[$name])) {
            $this->_values[$name] = $value;
        } else {
            parent::__set($name, $value);
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->raw_value = serialize($this->_values);
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        $this->_schema = static::$schemaDefinition[$this->group];
        $this->_values = unserialize($this->raw_value);
        parent::afterFind();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return[
            [
                'class' => 'yii\behaviors\TimestampBehavior',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'yii\behaviors\BlameableBehavior',
        ];
    }
}
//
GlobalConfig::$schemaDefinition = require(__DIR__ . '/schema_definition.php');
