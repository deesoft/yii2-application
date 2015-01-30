<?php

use yii\helpers\Html;
use app\components\Toolbar;

/* @var $this yii\web\View */
/* @var $model app\models\master\Price */
/* @var $categories app\models\master\PriceCategory[] */

$this->title = 'Create Price';
$this->params['breadcrumbs'][] = ['label' => 'Prices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    #tabular-input input{
        text-align: right;
    }
</style>
<div class="col-lg-8 price-create">
    <?php
    echo Toolbar::widget(['items' => [
            //['label' => 'Create', 'url' => ['create'], 'icon' => 'fa fa-plus-square', 'linkOptions' => ['class' => 'btn btn-success btn-sm']],
            //['label' => 'Detail', 'url' => ['view', 'id' => $model->id],'icon' => 'fa fa-search', 'linkOptions' => ['class' => 'btn bg-navy btn-sm']],
            //['label' => 'Update', 'url' => ['update', 'id' => $model->id],'icon' => 'fa fa-pencil', 'linkOptions' => ['class' => 'btn btn-warning btn-sm']],
            //['label' => 'Delete', 'url' => ['delete', 'id' => $model->id],'icon' => 'fa fa-trash-o', 'linkOptions' => ['class' => 'btn btn-danger btn-sm', 'data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]],
            ['label' => 'List', 'url' => ['index'], 'icon' => 'fa fa-list', 'linkOptions' => ['class' => 'btn btn-info btn-sm']]
    ]]);
    ?>
    <?= Html::beginForm() ?>
    <?= Html::errorSummary($products) ?>
    <table id="tabular-input">
        <thead>
            <tr>
                <th rowspan="2">Product</th>
                <th rowspan="2">Kategory</th>
                <th rowspan="2">Harga</th>
                <?php
                foreach ($categories as $category) {
                    echo Html::tag('th', $category->name);
                }
                ?>
            </tr>
            <tr>
                <?php
                foreach ($categories as $category) {
                    echo Html::tag('th', Html::textInput('', '', [
                            'class' => 'markup',
                            'data-ct_id' => $category->id
                    ]));
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $id=>$product): ?>
                <tr>
                    <td ><?= $product['name'] ?></td>
                    <td ><?= $product['category'] ?></td>
                    <td class="price"><?= $product['price'] ?></td>
                    <?php
                    foreach ($categories as $category) {
                        echo Html::tag('td', Html::activeTextInput($product, "[$id]prices[{$category->id}]", [
                                'class' => 'price',
                                'data-ct_id' => $category->id
                        ]));
                    }
                    ?>
                </tr>            
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= Html::a('save', '#', ['class'=>'btn btn-primary','data-method'=>'post']) ?>
    <?= Html::endForm() ?>
</div>
<?php
$js = <<<JS
    $('input.markup').change(function(){
        var markup = this.value;
        var ct_id = $(this).data('ct_id');
        var inp_sel = 'input[data-ct_id=' + ct_id + ']';
        if(markup.trim() == ''){
            $('#tabular-input > tbody '+inp_sel).val('');
            return;
        }
        var mp = 1 - 0.01*markup;
        $('#tabular-input > tbody > tr').each(function(){
            var \$tr = $(this);
            var sel_price = 1 * \$tr.children('td.price').text() / mp;
            \$tr.find(inp_sel).val(Math.round(sel_price));
        });
    });
    $('input.price').keyup(function(e){
        var \$td = $(this).closest('td');
        var \$tr = \$td.closest('tr');
        switch(e.which){
            // down
            case 13:
            case 40:
                if(\$tr.next().length > 0){
                    \$tr.next().children().eq(\$td.index()).find('input').focus();
                }
            break;
            // up
            case 38:
                if(\$tr.prev().length > 0){
                    \$tr.prev().children().eq(\$td.index()).find('input').focus();
                }
            break;
            // left
            case 37:
                if(\$td.index() > 3){
                    \$td.prev().find('input').focus();
                }
            break;
            // right
            case 39:
                if(\$td.next().length > 0){
                    \$td.next().find('input').focus();
                }
            break;
        }
    });
    $('input.price').focus(function(){
        $(this).select();
    });
JS;

$this->registerJs($js);
