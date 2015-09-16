var kaercherApp = angular.module('kaercherApp', ['nvd3']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});;