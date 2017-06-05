<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "errors".
 *
 * @property integer $id
 * @property string $date
 * @property integer $site_id
 */
class Errors extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'errors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['date'], 'safe'],
            [['site_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'date' => Yii::t('app', 'Date'),
            'site_id' => Yii::t('app', 'Site Link ID'),
        ];
    }
}
