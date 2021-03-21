<?php

/* @var $this yii\web\View */

use \yii\helpers\Html;

$this->title = 'My Yii Application';
?>

<div id="app" class="container h-100vh">
    <div class="row">
        <div class="col-lg-9 d-none d-lg-block">
            <div class="card">
                <iframe class="card-img-top" width="100%" height="400px" src="<?= $youtubeURL ?>?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
        <div class="col-lg-3 d-none d-lg-block">
            <div class="card main-product">
                <span class="product-status badge badge-primary">Текущий товар</span>
                <img class="card-img-left" src="https://cdn.goldapple.ru/media/catalog/product/cache/fb5d06f7acfb2f26f85333624ccbfb5e/8/8/887167525559_1_wwnsndubrzb88cud.jpg" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Название товара</h5>
                    <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                    <h5 class="card-text lead">7 980</h5>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-primary d-block w-100"><i class="fas fa-plus"></i> Добавить в корзину</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-nav-tabs d-none d-lg-block">
        <div class="card-header card-header-primary">
            <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                    <div class="nav-tabs-wrapper d-flex justify-content-between">
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#comments" data-toggle="tab">
                                    <i class="fas fa-comment"></i> Комментарии <span v-if="connections">({{connections}} онлайн)</span>
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
                                <a class="nav-link" :href="'/api/checkout?products=' + encodeURIComponent(JSON.stringify(cart)) + '&streamId=' + <?= $id ?> + '&userId=' + encodeURIComponent(getUId())">
                                    <!-- <button class="nav-link" data-toggle="modal" data-target="#cartModal"> -->
                                    <i class="fas fa-receipt"></i> Оформить заказ
                                    <!-- </button> -->
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="comments">
                    <div v-if="!ready">
                        <form @submit.prevent="addUser" class="container">
                            <div class="form-group mx-2 bmd-form-group w-100">
                                <label class="bmd-label-floating">Ваше имя</label>
                                <input v-model="username" type="text" class="form-control">
                            </div>
                        </form>
                    </div>

                    <div class="card" v-if="ready">
                        <!-- <div class="card-header card-header-primary">
                            <h4> <span class="float-right">{{connections}} онлайн</span></h4>
                        </div> -->

                        <ul class="list-group list-group-flush text-right">
                            <!-- <small v-if="typing">{{typing}} is typing</small> -->

                            <li class="list-group-item" v-for="message in messages">
                                <span :class="{'float-left':message.type === 1}">
                                    {{message.message}}

                                    <small>:{{message.user}}</small>
                                </span>
                            </li>
                        </ul>

                        <div class="card-body bg-grey">
                            <form @submit.prevent="send">
                                <div class="form-group">
                                    <input type="text" class="form-control" v-model="newMessage" placeholder="Введите ваше сообщение">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="products">
                    <div class="products w-100 d-flex flex-nowrap">
                        <div class="col-3" v-for="(product, idx) in products" :key="idx">
                            <div class="card">
                                <img class="card-img" :src="product.image" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{ product.name }}</h5>
                                    <h5 class="card-text lead">{{ product.price }}</h5>
                                </div>
                                <div class="card-footer">
                                    <button v-if="!cart.includes(product.id)" @click="addProductToCart(idx)" class="btn btn-primary d-block w-100"><i class="fas fa-plus"></i> Добавить в корзину</button>
                                    <button v-else @click="delProductFromCart(product.id)" class="btn btn-danger d-block w-100"><i class="fas fa-trash-alt"></i> Убрать из корзины</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="cart">
                    <div class="products w-100 d-flex flex-nowrap">
                        <div class="col-3" v-for="(productId, idx) in cart">
                            <div class="card">
                                <img class="card-img" :src="getProductById(productId).image" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{ getProductById(productId).name }}</h5>
                                    <p class="card-text">{{ getProductById(productId).description }}</p>
                                    <h5 class="card-text lead">{{ getProductById(productId).price }}</h5>
                                </div>
                                <div class="card-footer">
                                    <button @click="delProductFromCart(productId)" class="btn btn-danger d-block w-100"><i class="fas fa-trash-alt"></i> Убрать из корзины</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile -->

    <div class="tab-content tab-space d-lg-none h-100 pb-150">
        <div class="tab-pane h-100" id="comments-mobile">
            <!-- <div class="msgs pb-150 h-100">
                <div class="card mt-0 mb-1" v-for="i in 50" :key="i">
                    <div class="card-body p-2">
                        <h6 class="card-title mb-1"><span class="text-muted float-right">09:21 20.03.2021</span></h6>
                        <p class="card-text">Текст сообщения пользователя</p>
                    </div>
                </div>
            </div>

            <div class="container fixed-bottom mb-150 bg-grey">
                <div class="row mx-2">
                    <div class="col pl-0">
                        <div class="form-group bmd-form-group w-100">
                            <label class="bmd-label-floating">Ваш комментарий</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-auto d-flex align-items-center pr-0">
                        <button type="button" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div> -->

            <!-- <div v-if="ready">
                <p v-for="user in info">
                    {{user.username}} {{user.type}}
                </p>
            </div> -->

            <div v-if="!ready">
                <form @submit.prevent="addUser" class="container fixed-bottom mb-150 bg-grey">
                    <div class="form-group mx-2 bmd-form-group w-100">
                        <label class="bmd-label-floating">Ваше имя</label>
                        <input type="text" class="form-control">
                    </div>
                </form>
            </div>

            <h2 v-else>{{username}}</h2>

            <div class="card" v-if="ready">
                <div class="card-header card-header-primary">
                    <h4> <span class="float-right">{{connections}} онлайн</span></h4>
                </div>

                <ul class="list-group list-group-flush text-right h-60vh">
                    <!-- <small v-if="typing">{{typing}} is typing</small> -->

                    <li class="list-group-item" v-for="message in messages">
                        <span :class="{'float-left':message.type === 1}">
                            {{message.message}}

                            <small>:{{message.user}}</small>
                        </span>
                    </li>
                </ul>

                <div class="card-body fixed-bottom pb-150 bg-grey">
                    <form @submit.prevent="send">
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="newMessage" placeholder="Введите ваше сообщение">
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="tab-pane active h-100" id="stream-mobile">
            <iframe class="card-img-top" width="100%" height="100%" src="<?= $youtubeURL ?>?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div class="tab-pane pb-150" id="products-mobile">
            <div class="col-12 px-1" v-for="(product, idx) in products" :key="idx">
                <div class="card">
                    <span v-if="product.current" class="product-status-mobile badge badge-primary">Сейчас обозревают</span>
                    <img class="card-img" :src="product.image" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{ product.name }}</h5>
                        <p class="card-text">{{ product.description }}</h5>
                        <h5 class="card-text lead">{{ product.price }}</h5>
                    </div>
                    <div class="card-footer">
                        <button v-if="!cart.includes(product.id)" @click="addProductToCart(idx)" class="btn btn-primary d-block w-100"><i class="fas fa-plus"></i> Добавить в корзину</button>
                        <button v-else @click="delProductFromCart(product.id)" class="btn btn-danger d-block w-100"><i class="fas fa-trash-alt"></i> Убрать из корзины</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane pb-150" id="cart-mobile">
            <div class="pb-150">
                <div v-for="(productId, idx) in cart" class="col-12 px-1">
                    <div class="card">
                        <img class="card-img" :src="getProductById(productId).image" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{ getProductById(productId).name }}</h5>
                            <p class="cart-text">{{ getProductById(productId).description }}</p>
                            <h5 class="card-text lead">{{ getProductById(productId).price }}</h5>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-danger d-block w-100"><i class="fas fa-trash-alt"></i> Убрать из корзины</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fixed-bottom pb-150 bg-grey text-white px-3">
                <a class="btn btn-success d-block w-100"> Оформить заказ</a>
            </div>
        </div>
    </div>

    <div class="fixed-bottom p-3 bg-white d-lg-none">
        <ul class="nav nav-pills nav-pills-icons p-0 d-flex justify-content-between" role="tablist">
            <li class="nav-item">
                <a class="nav-link small p-1 active w-20vw" href="#stream-mobile" role="tab" data-toggle="tab">
                    <i class="fab fa-youtube"></i> Стрим
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link small p-1 w-20vw" href="#products-mobile" role="tab" data-toggle="tab">
                    <i class="fas fa-store-alt"></i> Товары
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link small p-1 w-20vw" href="#comments-mobile" role="tab" data-toggle="tab">
                    <i class="fas fa-comment"></i> Чат
                </a>
            </li>
            <li class="nav-item">
                <span v-if="cart.length" class="count-products-mobile badge badge-pill badge-warning p-2 position-absolute">{{ cart.length }}</span>

                <a class="nav-link small p-1 w-20vw" href="#cart-mobile" role="tab" data-toggle="tab">
                    <i class="fas fa-shopping-cart"></i> Корзина
                </a>
            </li>
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/socket.io-client@2.1/dist/socket.io.min.js"></script>

<script>
    var socket = io("https://live.fokin-team.ru:4000", {
        secure: true
    });

    if (!localStorage.getItem('uid')) {
        localStorage.setItem('uid', this.uuidv4())
    }

    socket.emit('setUid', localStorage.getItem('uid'), <?= $id ?>)

    var app = new Vue({
        el: '#app',
        data: {
            newMessage: null,
            messages: [],
            typing: false,
            username: null,
            ready: false,
            info: [],
            connections: 0,
            cart: [],
            products: <?= $products ?>,
            current: null
        },
        mounted: function() {
            window.onbeforeunload = () => {
                socket.emit('leave', this.username);
            }

            socket.on('chat-message', (data) => {
                this.messages.push({
                    message: data.message,
                    type: 1,
                    user: data.user,
                });
            });

            socket.on('typing', (data) => {
                this.typing = data;
            });


            socket.on('stopTyping', () => {
                this.typing = false;
            });

            socket.on('joined', (data) => {
                this.info.push({
                    username: data,
                    type: 'joined'
                });

                setTimeout(() => {
                    this.info = [];
                }, 5000);
            });

            socket.on('leave', (data) => {
                this.info.push({
                    username: data,
                    type: 'left'
                });

                setTimeout(() => {
                    this.info = [];
                }, 5000);
            });

            socket.on('connections', (data) => {
                this.connections = data;
            });
        },

        watch: {
            newMessage(value) {
                value ? socket.emit('typing', this.username) : socket.emit('stopTyping')
            }
        },

        methods: {
            send() {
                this.messages.push({
                    message: this.newMessage,
                    type: 0,
                    user: 'Я',
                });

                socket.emit('chat-message', {
                    message: this.newMessage,
                    user: this.username
                });
                this.newMessage = null;
            },
            addUser() {
                this.ready = true;
                socket.emit('joined', this.username)
            },
            getAllProducts: function(idx) {

            },
            addProductToCart: function(idx) {
                this.cart.push(this.products[idx].id)
            },
            delProductFromCart: function(value) {
                this.cart.splice(this.cart.indexOf(value), 1);
            },
            getProductById: function(id) {
                return this.products.find(product => product.id == id)
            },
            uuidv4: function() {
                return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                    var r = Math.random() * 16 | 0,
                        v = c == 'x' ? r : (r & 0x3 | 0x8);
                    return v.toString(16);
                });
            },
            getUId: function() {
                return localStorage.getItem('uid')
            }
        }
    })
</script>