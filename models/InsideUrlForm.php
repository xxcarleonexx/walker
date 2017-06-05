<?php


namespace app\models;


use Yii;
use yii\base\Model;

class InsideUrlForm extends Model
{

    public $txtSites = '';
    public $oldDomain;
    public $newDomain;

    public function rules()
    {
        return [
            [['txtSites', 'linkSite', 'oldDomain', 'newDomain'], 'required'],
            ['txtSites', 'string'],
            ['linkSiteId', 'integer'],
            [['oldDomain', 'newDomain'], 'url', 'defaultScheme' => 'http'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'txtSites' => 'Ввод внутренних URL',
            'oldDomain' => 'Старый домен',
            'newDomain' => 'Новый домен',
        ];
    }

    public function save()
    {
        $transaction = Yii::$app->db->beginTransaction();
        $urlLinking = new UrlLinking();
        $urlLinking->site_url_old = $this->oldDomain;
        $urlLinking->site_url_linked_to = $this->newDomain;
        if ($urlLinking->save()) {
            $sites = explode("\n", $this->txtSites);
            foreach ($sites as $site) {
                $insideUrl = new InsideUrl();
                $insideUrl->site_link_id = $urlLinking->id;
                $insideUrl->url = $site;
                if (false === $insideUrl->save()){
                    $transaction->rollBack();
                    $this->addError('txtSites', 'Не валидный URL');
                    return false;
                };
            }
            $transaction->commit();
            return true;
        } else {
            $transaction->rollBack();
            $this->addErrors($urlLinking->getErrors());
            return false;
        }
    }

}
