<?php
list(, $dir) = Yii::$app->getAssetManager()->publish('@backend/rbac/plugins');
$svg = $dir . '/image/loading.svg';
?>
<style type="text/css">
    .rbac-loading {
        background: rgba(0, 0, 0, 0.5);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 3050 !important;
    }

    .in-box {
        width: 100px;
        height: 100px;
        position: relative;
        top: 44.8%;
        left: 47.4%;
    }

    .img-loading {
        width: 45px;
        height: 45px;
        -webkit-animation: sum-loading 1.5s infinite linear;
        animation: sum-loading 1.5s infinite linear;
        -moz-animation: sum-loading 1.5s infinite linear;
        -o-animation: sum-loading 1.5s infinite linear;
    }

    .rbac-loading-hide {
        display: none;
    }

    .loading-font {
        margin-top: 8px;
        font-size: 16px;
        font-weight: 500;
        color: white;
    }

    @-moz-keyframes sum-loading {
        from {
            transform: rotateZ(0deg);
            -moz-transform: rotateZ(0deg);
            -webkit-transform: rotateZ(0deg);
            -o-transform: rotateZ(0deg);
            -ms-transform: rotateZ(0deg);
        }
        to {
            transform: rotateZ(360deg);
            -moz-transform: rotateZ(360deg);
            -webkit-transform: rotateZ(360deg);
            -o-transform: rotateZ(360deg);
            -ms-transform: rotateZ(360deg);
        }
    }

    @-ms-keyframes sum-loading {
        from {
            transform: rotateZ(0deg);
            -moz-transform: rotateZ(0deg);
            -webkit-transform: rotateZ(0deg);
            -o-transform: rotateZ(0deg);
            -ms-transform: rotateZ(0deg);
        }
        to {
            transform: rotateZ(360deg);
            -moz-transform: rotateZ(360deg);
            -webkit-transform: rotateZ(360deg);
            -o-transform: rotateZ(360deg);
            -ms-transform: rotateZ(360deg);
        }
    }

    @-o-keyframes sum-loading {
        from {
            transform: rotateZ(0deg);
            -moz-transform: rotateZ(0deg);
            -webkit-transform: rotateZ(0deg);
            -o-transform: rotateZ(0deg);
            -ms-transform: rotateZ(0deg);
        }
        to {
            transform: rotateZ(360deg);
            -moz-transform: rotateZ(360deg);
            -webkit-transform: rotateZ(360deg);
            -o-transform: rotateZ(360deg);
            -ms-transform: rotateZ(360deg);
        }
    }

    @keyframes sum-loading {
        from {
            transform: rotateZ(0deg);
            -moz-transform: rotateZ(0deg);
            -webkit-transform: rotateZ(0deg);
            -o-transform: rotateZ(0deg);
            -ms-transform: rotateZ(0deg);
        }
        to {
            transform: rotateZ(360deg);
            -moz-transform: rotateZ(360deg);
            -webkit-transform: rotateZ(360deg);
            -o-transform: rotateZ(360deg);
            -ms-transform: rotateZ(360deg);
        }
    }

    @-webkit-keyframes sum-loading {
        from {
            transform: rotateZ(0deg);
            -moz-transform: rotateZ(0deg);
            -webkit-transform: rotateZ(0deg);
            -o-transform: rotateZ(0deg);
            -ms-transform: rotateZ(0deg);
        }
        to {
            transform: rotateZ(360deg);
            -moz-transform: rotateZ(360deg);
            -webkit-transform: rotateZ(360deg);
            -o-transform: rotateZ(360deg);
            -ms-transform: rotateZ(360deg);
        }
    }
</style>
<div id="rbac-loading" class="rbac-loading rbac-loading-hide">
    <div class="text-center in-box">
        <img class="img-loading" src="<?php echo $svg; ?>" alt="加载中...">
        <p class="loading-font">疯狂加载中...</p>
    </div>
</div>