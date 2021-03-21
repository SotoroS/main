<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>

<pre>

<?= print_r($products) ?>
</pre>

<div id="app" class="container h-100vh">
    <div class="row">
        <div class="col-lg-9 d-none d-lg-block">
            <div class="card">
                <iframe class="card-img-top" width="100%" height="400px" src="<?= $youtubeURL ?>?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
        <div class="col-lg-3 d-none d-lg-block">
            
        </div>
    </div>

    <div class="card card-nav-tabs d-none d-lg-block">
        <!-- <div class="card-header card-header-primary">
            <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                    <div class="nav-tabs-wrapper d-flex justify-content-between">
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#comments" data-toggle="tab">
                                    <i class="fas fa-comment"></i> Комментарии
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#products" data-toggle="tab">
                                    <i class="fas fa-store-alt"></i> Товары
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#cart" data-toggle="tab">
                                    <i class="fas fa-shopping-cart"></i> Корзина <span v-if="cart.length">({{ cart.length }})</span>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="nav-item">
                                <a class="nav-link" :href="'/api/checkout?products=' + encodeURIComponent(JSON.stringify(cart))">
                                    <i class="fas fa-receipt"></i> Оформить заказ
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> -->

        

    
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/socket.io-client@2.1/dist/socket.io.min.js"></script>

