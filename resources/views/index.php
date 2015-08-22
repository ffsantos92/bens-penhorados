<!DOCTYPE html>
<html data-ng-app="bens-penhorados">

<head>
    <base href="/" />
    <title data-ng-bind="pageTitle">Bens Penhorados</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/animate.css">

    <link rel="stylesheet" href="css/loading-bar.css">
</head>

<body>
    <!--[if lt IE 7]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <div data-ng-include='"templates/header.html"'></div>
    <div data-ng-view></div>
    <div data-ng-include='"templates/footer.html"'></div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular-route.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular-resource.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular-animate.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular-touch.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular-cookies.min.js"></script>

    <script src="js/modules/dirPagination.js"></script>
    <script src="js/modules/loading-bar.min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.13.0/ui-bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.13.0/ui-bootstrap-tpls.min.js"></script>

    <script src="js/main.js"></script>
    <script src="js/filters.js"></script>

    <!-- Controllers -->
    <script src="js/controllers/UserController.js"></script>
    <script src="js/controllers/PropertyControllers.js"></script>
    <script src="js/controllers/VehicleControllers.js"></script>
    <script src="js/controllers/OtherControllers.js"></script>

    <!-- Services -->
    <script src="js/services/PropertyService.js"></script>
    <script src="js/services/PropertyFiltersService.js"></script>
    <script src="js/services/VehicleService.js"></script>
    <script src="js/services/VehicleFiltersService.js"></script>
    <script src="js/services/OtherService.js"></script>
    <script src="js/services/OtherFiltersService.js"></script>

</body>

</html>
