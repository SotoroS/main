<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Все стримы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stream-index p-5">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать стрим', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="table-responsive">

    <table class="table align-items-center table-flush">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col" class="sort" data-sort="name">Имя</th>
                <th scope="col" class="sort" data-sort="budget">Ссылка на YouTube</th>
                <th scope="col" class="sort" data-sort="budget">Ссылка на стрим</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody class="list">
            <?php foreach($models as $key => $model):?>
            <tr>
                <td>
                    <?=$key+1?>
                </td>
                <!-- Имя клиента -->
                <td scope="row">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <span class="name mb-0 text-sm"><?=$model->name?> </span>
                        </div>
                    </div>
                </td>
                <!-- Ссылка на YouTube -->
                <td class="budget">
                    <?php $linkOwner = $model->youtube_url;?>
                    <a href="<?=$linkOwner?>" target="_blank"><span><?=$linkOwner?></span></a>
                </td>
                <!-- Ссылка на стрим -->
                <td>
                    <?php $linkOwner = "https://live.fokin-team.ru/view/stream/" . $model->id;?>
                    <a href="<?=$linkOwner?>" target="_blank"><span><?=$linkOwner?></span></a>

                </td>
                <td class="text-right">
                    <?php
                        echo Html::a('<h3><i class="fa fa-eye" aria-hidden="true"></i></h3>', ['view', 'id' => $model->id]);
                        // echo Html::a('<h3>delete</h3>', ['delete', 'id' => $model->id]);
                    ?>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    </div>

</div>
