<?
$menuItems = array_chunk($menuCollection, 6);
?>
<div class="vc_row wpb_row vc_row-fluid footer-links-menu-wrap">
    <?
    foreach ($menuItems as $counter => $menuBlock) {
        if ($counter > 1) break;
        echo $this->render('_block', [
            'menuCollection' => $menuBlock
        ]);
    }
    ?>
</div>