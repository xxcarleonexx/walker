<?php

use app\models\InsideUrl;
use app\models\InsideUrlForm;
use app\models\UrlLinking;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $insideDataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('app', 'Url Linkings');
$this->params['breadcrumbs'][] = $this->title;

?>
<?php Pjax::begin(['options' => [
    'id' => 'site-linking-pjax',
    'class' => 'pjax-wraper',
]]); ?>
    <div class="url-linking-index">


        <h1><?= 'Привязка сайтов' ?></h1>
        <p>
            <?= Html::a(Yii::t('app', 'Добавить новый сайт'), '#modal-add-site', ['class' => [
                'btn', 'btn-success'], 'data-toggle' => 'modal']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'site_url_old:url',
                'site_url_linked_to:url',
                [
                    'attribute' => 'logErrors',
                    'label' => 'Количество ошибок всего',
                    'value' => function(UrlLinking $model) {
                        return $count = $model->getLogErrors()->count();
                    },
                ],
                [
                    'attribute' => 'logWeekErrors',
                    'label' => 'Количество ошибок за неделю',
                    'value' => function(UrlLinking $model) {
                        return $model->getWeekErrors()->count();
                    },
                ],
                [
                    'attribute' => 'insideUrls',
                    'label' => 'Количество сайтов на проверке',
                    'value' => function(UrlLinking $model) {
                        return $model->getInsideUrls()->count();
                    },
                ],
            ],
        ]); ?>

    </div>
    <div class="url-linking-index">

        <h1><?= 'Лог ошибок' ?></h1>
        <?= GridView::widget([
            'dataProvider' => $insideDataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'siteLink.site_url_old',
                [
                    'attribute' => 'url',
                    'label' => 'Ссылка',
                    'content' => function(InsideUrl $model) {
                        return $model->url;
                    },
                ],
                'status',
                [
                    'attribute' => '',
                    'label' => 'Обновить',
                    'content' => function(InsideUrl $model) {
                        return Html::tag('i', '', [
                            'class' => ['fa fa-refresh'],
                            'style' => ['aria-hidden' => true],
                            'data-site' => $model->id,
                        ]);
                    },
                ],
            ],
        ]); ?>
    </div>
<?php Pjax::end(); ?>
<?= $this->render('modal', [
    'model' => new InsideUrlForm(),
]) ?>
<?php $this->registerJs(/**@lang JavaScript */
    '
 var timerId = setInterval(function() {
        jsonrpcWrapper("/check/jsonrpc", "search", {}, function(xhr, status) {
            reloadPjax();
        });
   }, 10000);

$(document).on("click", ".fa-refresh", function(event) {
    var siteId = $(this).data("site");
    jsonrpcWrapper("/check/jsonrpc", "search", {id:siteId}, function(xhr, status) {
       var data = xhr.responseJSON.result;
       if (301 === data) {
           alert("Site will be remove from errors list");
       }
       reloadPjax();
       return false;
    }); 
});
function reloadPjax() {
        $.pjax.reload({container:\'#site-linking-pjax\'});
        return false;
}
');

