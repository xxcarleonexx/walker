<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the model class for table "url_linking".
 *
 * @property integer $id
 * @property string $site_url_old
 * @property string $site_url_linked_to
 *
 * @property InsideUrl[] $insideUrls
 */
class UrlLinking extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'url_linking';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_url_old', 'site_url_linked_to'], 'required'],
            [['site_url_old', 'site_url_linked_to'], 'url', 'defaultScheme' => 'http'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'site_url_old' => Yii::t('app', 'Site Url Old'),
            'site_url_linked_to' => Yii::t('app', 'Site Url Linked To'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getInsideUrls()
    {
        return $this->hasMany(InsideUrl::className(), ['site_link_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLogErrors()
    {
        return $this->hasMany(Errors::className(), ['site_id' => 'id'])
            ->via('insideUrls');
    }

    /**
     * @return ActiveQuery
     */
    public function getWeekErrors()
    {
        return $this->hasMany(Errors::className(), ['site_id' => 'id'])
            ->where(['>=', 'date', new Expression('DATE_SUB(NOW(), INTERVAL 1 WEEK)')])
            ->via('insideUrls');
    }

}
