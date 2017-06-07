<?php

namespace app\models;

use DateInterval;
use Yii;
use yii\base\Exception;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "inside_url".
 *
 * @property integer $id
 * @property integer $site_link_id
 * @property integer $status
 * @property string $url
 * @property string $next_date_check
 *
 * @property UrlLinking $siteLink
 */
class InsideUrl extends \yii\db\ActiveRecord
{

    public $txtUrlSites = '';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inside_url';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_link_id'], 'required'],
            [['site_link_id', 'status'], 'integer'],
            ['url', 'url', 'defaultScheme' => 'http'],
            [['site_link_id'], 'exist', 'skipOnError' => true, 'targetClass' => UrlLinking::className(),
                'targetAttribute' => ['site_link_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'site_link_id' => Yii::t('app', 'Site Link ID'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiteLink()
    {
        return $this->hasOne(UrlLinking::className(), ['id' => 'site_link_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogErrors()
    {
        return $this->hasOne(Errors::className(), ['site_id' => 'id']);
    }

    /**
     * @param null|integer $id
     * @return bool|int|mixed
     */
    public static function checkUrls($id)
    {
        $query = InsideUrl::find();
        $statusCode = 404;

        if (empty($id)) {
            $query->andWhere(['<=', 'next_date_check', new Expression('NOW()')]);
        } else {
            $query->andWhere(['id' => $id]);
        }
        $sites = $query->asArray()->all();
        foreach ($sites as $site) {
            try {
                $statusCode = static::checkCode(ArrayHelper::getValue($site, 'url'));
            } catch (Exception $e) {
                $statusCode = 404;
            }
            if (empty($statusCode)) {
                $statusCode = 404;
            }
            $insideUrl = InsideUrl::findOne($site['id']);
            $insideUrl->next_date_check = (new \DateTime('now'))
                ->add(new DateInterval("PT12H"))
                ->format('Y-m-d H:i:s');
            $insideUrl->status = $statusCode;
            $insideUrl->save(false);
            if (301 != $statusCode) {
                $errors = new Errors();
                $errors->site_id = $insideUrl->id;
                $errors->date = new Expression('NOW()');
                $errors->save();
            }
        }
        if (!empty($id)) {
            return $statusCode;
        }
        return true;
    }

    /**
     * @param $url
     * @return mixed
     */
    private static function checkCode($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpcode;
    }

}
