<header style="background: rgba(255, 255, 255, 0) none repeat scroll 0% 0%; border-bottom: 1px solid transparent;"
        class="header clear" role="banner">

    <!-- logo -->
    <div class="logo">
        <a href="<?= \Yii::$app->homeUrl ?>">
            <!-- svg logo - toddmotto.com/mastering-svg-use-for-a-retina-web-fallbacks-with-png-script -->
            <img src="<?= $directoryAsset ?>/img/logo.png" alt="Logo" class="logo-img">
        </a>
    </div>
    <!-- /logo -->

    <!-- nav -->
    <nav class="nav" role="navigation">

        <ul class="secondary-nav">
            <li class="secondary-nav-search">
                <i class="fa fa-search"></i>
            </li>
            <li class="secondary-nav-account">
                <a href="http://www.jenadin.com.ua/ru/my-account/">Профиль
                </a>
            </li>
            <li class="secondary-nav-cart">
                <a class="cart-contents" href="" title="View your shopping cart">
                    <?
                    echo \Yii::$app->basket->getBasketCount();
                    ?>
                </a>
                <div style="max-height: 305px;" class="cart-contents-items">
                    <table>

                        <tbody>
                        <tr>
                            <td colspan="2" class="cart-contents-sum"><span>Итого: </span> <span
                                    class="amount">0грн.</span></td>
                            <td colspan="2" class="toCartButton"><a
                                    href="http://www.jenadin.com.ua/ru/cart/">Оформить</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>


            </li>
        </ul>
        <?= \frontend\widgets\MenuTopWidget::widget(); ?>
        <button style="display: none;" class="burger">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </button>
        <form role="search" method="get" class="woocommerce-product-search" action="http://www.jenadin.com.ua/ru/">
            <!--label class="screen-reader-text" for="s"></label-->

            <input class="search-field" placeholder="Поиск товаров…" value="" name="s" title="Искать:" type="search">
            <input style="position: absolute; right: -99999px" value="Поиск" type="submit">
            <input name="post_type" value="product" type="hidden">
            <button class="close">
                <span class="close-line"></span>
                <span class="close-line"></span>
            </button>
        </form>
    </nav>
    <!-- /nav -->

</header>
<script type="text/javascript">
    var siteUrl = '<?= Yii::$app->request->hostInfo . '/' . \common\models\Lang::getCurrent()->url ?>';
</script>
<!-- END HEADER -->