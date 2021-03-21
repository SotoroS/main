<!--
=========================================================
Material Kit - v2.0.7
=========================================================

Product Page: https://www.creative-tim.com/product/material-kit
Copyright 2020 Creative Tim (https://www.creative-tim.com/)

Coded by Creative Tim

=========================================================

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="/material/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/material/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Material Kit by Creative Tim
    </title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="/material/css/material-kit.css?v=2.0.7" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="/material/demo/demo.css" rel="stylesheet" />
    <link href="/css/material.css" rel="stylesheet" />

    <script src="https://kit.fontawesome.com/0a43ad58ff.js" crossorigin="anonymous"></script>
</head>

<body class="index-page sidebar-collapse">
    
    <?= $content ?>

    <!--   Core JS Files   -->
    <script src="/material/js/core/jquery.min.js" type="text/javascript"></script>
    <script src="/material/js/core/popper.min.js" type="text/javascript"></script>
    <script src="/material/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
    <script src="/material/js/plugins/moment.min.js"></script>
    <!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
    <script src="/material/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="/material/js/plugins/nouislider.min.js" type="text/javascript"></script>
    <!--  Google Maps Plugin    -->
    <!-- Control Center for Material Kit: parallax effects, scripts for the example pages etc -->
    <script src="/material/js/material-kit.js?v=2.0.7" type="text/javascript"></script>
    <!-- <script>
        $(document).ready(function() {
            //init DateTimePickers
            materialKit.initFormExtendedDatetimepickers();

            // Sliders Init
            materialKit.initSliders();
        });


        function scrollToDownload() {
            if ($('.section-download').length != 0) {
                $("html, body").animate({
                    scrollTop: $('.section-download').offset().top
                }, 1000);
            }
        }
    </script> -->
</body>

</html>