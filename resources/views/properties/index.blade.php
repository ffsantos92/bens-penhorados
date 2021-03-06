@extends('layouts.search')

@section('advanced-search')
<div class="panel panel-default">
    <div class="panel-heading">Pesquisa avançada</div>
    <div class="panel-body form-horizontal">

        <div class="form-group">
            <label for="land-registry" class="col-sm-4 control-label">Tipo de prédio</label>
            <div class="col-sm-8">
                <select data-ng-disabled="!filteringAttr.property.landRegistryTypes" class="form-control" data-ng-model="filters.landRegistry" data-ng-options="key as value for (key , value) in filteringAttr.property.landRegistryTypes">
                    <option value="">-- Todas os tipos --</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="typology" class="col-sm-4 control-label">Tipologia</label>
            <div class="col-sm-8">
                <select data-ng-disabled="!filteringAttr.property.typologies || filters.landRegistry == 1" class="form-control" data-ng-model="filters.typology" data-ng-options="key as value for (key , value) in filteringAttr.property.typologies">
                    <option value="">-- Todas as tipologias --</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12 text-right">
                <button type="button" class="btn btn-default" data-ng-click="resetPropertyFilters()">Limpar filtros</button>
            </div>
        </div>

    </div>
</div>
@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular-resource.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular-cookies.min.js"></script>

<script src="/js/modules/dirPagination.js"></script>
<script src="/js/modules/loading-bar.min.js"></script>
<script src="/js/modules/focusIf.js"></script>

<script type="text/javascript">
var app = angular.module('bens-penhorados', ['ngResource', 'focus-if',
    'angularUtils.directives.dirPagination', 'angular-loading-bar', 'ngCookies'
    ], function($interpolateProvider) {
            $interpolateProvider.startSymbol('[[-');
            $interpolateProvider.endSymbol('-]]');
        }).filter('range', function() {
            return function(min, max) {
                var range = [];
                min = parseInt(min);
                max = parseInt(max);
                for (var i = max; i >= min; i--) {
                    range.push(i);
                }
                return range;
            }
        });

app.config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = true;
}]);

app.config(function(paginationTemplateProvider) {
    paginationTemplateProvider.setPath('/js/modules/dirPagination.tpl.html');
});

app.factory('Property', ['$resource', function($resource) {
    return $resource(
        '../api/v1/properties/:slug', {
            id: '@_slug'
        }, {
            'query': {
                method: 'GET',
                isArray: false
            }
        }
    );
}]);

app.factory('PropertyFilters', ['$resource', function($resource) {
    return $resource(
        '../api/v1/attributes/property', {}, {
            'query': {
                method: 'GET',
                isArray: false
            }
        }
    );
}]);

app.controller('SearchCtrl', ['$scope', '$location', '$cookies', 'Property', 'PropertyFilters',
    function($scope, $location, $cookies, Property, PropertyFilters) {
        $scope.items = [];
        $scope.totalItems = 0;
        $scope.itemsFrom = 0;
        $scope.itemsTo = 0;
        $scope.itemsPerPageValues = [10, 25, 50, 100];
        $scope.priceRange = getPriceRange();
        $scope.alerts = {
            hideGenericFilterAlert: $cookies.get('hide_generic_property_filter_alert'),
        };

        init();

        var $toWatch = [
            'filters.district',
            'filters.municipality',
            'filters.purchaseType',
            'filters.withImages',
            'filters.ignoreSuspended',
            'filters.minPrice',
            'filters.maxPrice',
            'filters.noPrice',
            'filters.landRegistry',
            'filters.typology',
            'filters.searchQuery',
            'itemsPerPage',
            'pagination',
        ];

        $scope.$watchGroup($toWatch, function(newValues, oldValues, scope) {
            if (!angular.equals(newValues, oldValues)) {
                setSearchVars(1);
            }
        });

        function init() {
            var search = $location.search();
            $scope.pagination = {
                current: search.page || 1,
            };
            $scope.itemsPerPage = parseInt(search.limit) || 10;
            $scope.filters = {
                district: search.district,
                municipality: search.municipality,
                purchaseType: search.purchasetype,
                withImages: parseInt(search.withimages) || undefined,
                ignoreSuspended: parseInt(search.nosuspended) || undefined,
                minPrice: parseInt(search.minprice) || undefined,
                maxPrice: parseInt(search.maxprice) || undefined,
                noPrice: parseInt(search.noprice) || undefined,
                landRegistry: search.landregistry,
                typology: search.typology,
                searchQuery: search.q,
            };
            getResultsPage($scope.pagination.current);
            getFilteringAttributes();
        }

        function setSearchVars(pageNumber) {
            $location.search(getSearchObject(pageNumber));

            getResultsPage($scope.pagination.current);
            getFilteringAttributes();
        }

        function getResultsPage(pageNumber) {
            Property.query(getSearchObject(pageNumber), function(data) {
                $scope.result = data;
                $scope.noResults = ((data.items.length) ? false : true);
            }, function(error) {});
        }

        function getFilteringAttributes() {
            PropertyFilters.query({
                district: $scope.filters.district,
            }, function(data) {
                $scope.filteringAttr = data;
            }, function(error) {});
        }

        function getSearchObject(pageNumber) {
            return {
                page: pageNumber,
                limit: $scope.itemsPerPage,
                district: $scope.filters.district,
                municipality: $scope.filters.municipality,
                purchasetype: $scope.filters.purchaseType,
                withimages: $scope.filters.withImages,
                nosuspended: $scope.filters.ignoreSuspended,
                minprice: getMinPrice(),
                maxprice: getMaxPrice(),
                noprice: $scope.filters.noPrice,
                landregistry: $scope.filters.landRegistry,
                typology: $scope.filters.typology,
                q: $scope.filters.searchQuery,
            };
        }

        function getMinPrice() {
            if ($scope.filters.noPrice !== undefined || $scope.filters.minPrice === undefined) {
                return;
            }

            if ($scope.filters.maxPrice === undefined) {
                return $scope.filters.minPrice;
            }

            if ($scope.filters.minPrice <= $scope.filters.maxPrice) {
                return $scope.filters.minPrice;
            }

            return $scope.filters.maxPrice;
        }

        function getMaxPrice() {
            if ($scope.filters.noPrice !== undefined || $scope.filters.maxPrice === undefined) {
                return;
            }

            if ($scope.filters.minPrice === undefined) {
                return $scope.filters.maxPrice;
            }

            if ($scope.filters.maxPrice >= $scope.filters.minPrice) {
                return $scope.filters.maxPrice;
            }

            return $scope.filters.minPrice;
        }

        function getPriceRange() {
            var prices = [];
            var i = 1;
            while (i <= 150000) {
                prices.push(i);
                if (i === 1) {
                    i += 99;
                } else if (i < 1000) {
                    i += 100;
                } else if (i < 5000) {
                    i += 500;
                } else if (i < 10000) {
                    i += 1000;
                } else if (i < 50000) {
                    i += 10000;
                } else {
                    i += 50000;
                }
            }

            return prices;
        }

        $scope.resetGenericFilters = function() {
            var filtersToReset = ['district', 'municipality', 'ignoreSuspended',
                'withImages', 'purchaseType', 'noPrice', 'minPrice', 'maxPrice',
                'searchQuery',
            ];

            angular.forEach(filtersToReset, function(value, key) {
                $scope.filters[value] = undefined;
            });
        }

        $scope.resetPropertyFilters = function() {
            var filtersToReset = ['landRegistry', 'typology'];

            angular.forEach(filtersToReset, function(value, key) {
                $scope.filters[value] = undefined;
            });
        }

        $scope.pageChangeHandler = function(newPage) {
            setSearchVars(newPage);
        };

        $scope.closeAlert = function(name) {
            if (name == 'generic') {
                $cookies.put('hide_generic_property_filter_alert', true);
                $scope.alerts.hideGenericFilterAlert = true;
            }
        }
}]);
</script>
@stop
