<?php
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal-add-site',
    'size' => 'modal-lg',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
        'show' => false,
    ],
]); ?>
    <div class="url-linking-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'oldDomain')->textInput([
            'maxlength' => true,
        ]) ?>

        <?= $form->field($model, 'newDomain')->textInput([
            'maxlength' => true,
        ]) ?>

        <?= $form->field($model, 'txtSites')->textarea([
            'rows' => 20,
            'maxlength' => true,
            'style' => ['margin-bottom' => '10px'],
        ]) ?>

        <div class="modal-footer">
            <button type="button" class="btn btn-default js__modal_close" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary js__modal_save_change">Save changes</button>
        </div>
        <!--        <div class="form-group">-->
        <!--            --><?= ''//= Html::submitButton($modelLinking->isNewRecord ?
        //                Yii::t('app', 'Create') :
        //                Yii::t('app', 'Update'),
        //                ['class' => $modelLinking->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])     ?>
        <!--        </div>-->

        <?php ActiveForm::end(); ?>
    </div>
<?php Modal::end();
$this->registerJs(/**@lang JavaScript */
    '
$(".js__modal_save_change").click(function(event) {
    var 
    $newDomain = $("#insideurlform-newdomain"),
    $oldDomain = $("#insideurlform-olddomain"),
    $txtSites = $("#insideurlform-txtsites"),
    data = {
        oldDomain: $oldDomain.val(),
        newDomain: $newDomain.val(),
        txtSites: $txtSites.val()
        };
    if ($(".form-group .has-error").length) {
        return;
    }
    jsonrpcWrapper("/check/jsonrpc", "tryToSave", {data: data}, function(xhr, status) {
        reloadPjax();
        $oldDomain.val("");
        $newDomain.val("");
        $txtSites.val("");
        $("#modal-add-site").modal("toggle");
        console.log("Save data transmit success.");
    }, function(xhr, status) {
      console.log("Errors find");
    });
    console.log("try to save");
});
');
