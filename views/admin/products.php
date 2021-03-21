<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Все Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stream-index p-5">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="table-responsive">

        <form action="/admin/checkbox-form" method="post">
        <?= Html::beginForm(['/admin/checkbox-form'], 'POST'); ?>
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="sort" data-sort="name">Изображение</th>
                        <th scope="col" class="sort" data-sort="name">Наименование</th>
                        <th scope="col" class="sort" data-sort="budget">Ссылка на товар</th>
                        <th scope="col" class="sort" data-sort="budget">Выбрать</th>
                    </tr>
                </thead>
                <tbody class="list">
                    <?php foreach($models as $key => $model):?>
                    <tr>
                        <td>
                            <?=$key+1?>
                        </td>
                        <td>
                            <div class="avatar rounded-circle" style="background-position: center; background-size: cover; background-repeat: no-repeat; background-image: url('<?=$model->image?>');"></div>
                        </td>
                        <!-- Наименование -->
                        <td scope="row">
                            <div class="media align-items-center">
                                <div class="media-body">
                                    <span class="name mb-0 text-sm"><?=$model->name?> </span>
                                </div>
                            </div>
                        </td>
                        <!-- Ссылка на товар -->
                        <td class="budget">
                            <?=$model->url?>
                        </td>
                        <!-- Выбор -->
                        <td>
                            <input type="checkbox" name="arrayID[]" value="<?=$model->id?>">
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>

            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']); ?>
            <?= Html::endForm(); ?>
    </div>
</div>
