<?php

use common\modules\i18n\Module;

/**
 * @var \common\models\Threat $threat
 */

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>border-collapse</title>
    <style>
        table {
            width: 100%;
            border: 2px solid black;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            background: #ccc;
            padding: 5px;
            border: 1px solid black;
        }

        td {
            padding: 5px;
            border: 1px solid black;
        }
    </style>
</head>
<body>
<table style="width: 100%">
    <thead>
    <tr>
        <th><?= Module::t('Customer') ?></th>
        <th><?= Module::t('Threat') ?></th>
        <th><?= Module::t('BPM') ?></th>
        <th><?= Module::t('Time') ?></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?= $threat->customer->name ?></td>
        <td><?= Module::t($threat->alias) ?></td>
        <td><?= $threat->bpm ?></td>
        <td><?= $threat->created_at ?></td>
    </tr>
    </tbody>
</table>
</body>
</html>
