<?php
/* @var $panel yii\debug\panels\ProfilingPanel */
/* @var $searchModel yii\debug\models\search\Profile */
/* @var $dataProvider yii\data\ArrayDataProvider */
/* @var $time string */
/* @var $memory string */
/* @var $numFiles string */

use yii\grid\GridView;
use yii\helpers\Html;

?>
<h1>Performance Profiling</h1>
<p>
    Total processing time: <b><?= $time ?></b>;
    Peak memory: <b><?= $memory ?></b>;
    Number of included files: <b><?= $numFiles ?></b>
</p>
<?php

// change sort order to sequence instead of duration
$dataProvider->sort->defaultOrder = ["seq" => SORT_ASC];

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'id' => 'profile-panel-detailed-grid',
    'options' => ['class' => 'detail-grid-view table-responsive'],
    'filterModel' => $searchModel,
    'filterUrl' => $panel->getUrl(),
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'seq',
            'label' => 'Time',
            'value' => function ($data) {
                $timeInSeconds = $data['timestamp'] / 1000;
                $millisecondsDiff = (int) (($timeInSeconds - (int) $timeInSeconds) * 1000);

                return date('H:i:s.', $timeInSeconds) . sprintf('%03d', $millisecondsDiff);
            },
            'headerOptions' => [
                'class' => 'sort-numerical'
            ]
        ],
        [
            'attribute' => 'duration',
            'value' => function ($data) {
                return sprintf('%.1f ms', $data['duration']);
            },
            'options' => [
                'width' => '10%',
            ],
            'headerOptions' => [
                'class' => 'sort-numerical'
            ]
        ],
        'category',
        [
            'attribute' => 'info',
            'value' => function ($data) {
                return str_repeat('<span class="indent">→</span>', $data['level']) . Html::encode($data['info']);
            },
            'format' => 'raw',
            'options' => [
                'width' => '60%',
            ],
        ],
    ],
]);
