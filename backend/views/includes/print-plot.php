<?

use common\modules\i18n\Module;

?>
<script type="text/template" id="template-print-plot">
    <!DOCTYPE html>
    <html>
    <head>
        <title><?= Module::t('Print') ?></title>
    </head>
    <body>
    <img src="<%= img.src %>"/>
    </body>
    </html>
</script>