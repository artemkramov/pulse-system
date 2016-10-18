<?php

use common\modules\i18n\Module;

?>
<script type="text/template" id="notification-disease">
    <table class="table table-notification-disease">
        <thead>
        <tr>
            <th><?= Module::t('Customer') ?></th>
            <th><?= Module::t('Threat') ?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><%= threat.customer %></td>
            <td><%= threat.name %></td>
        </tr>
        </tbody>
    </table>
    <div class="notification-more-details">
        <a class="btn btn-primary" href="<%= threat.link %>" target="_blank"><?= Module::t('Details') ?></a>
    </div>
</script>
