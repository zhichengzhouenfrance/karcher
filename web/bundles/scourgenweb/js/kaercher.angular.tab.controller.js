kaercherApp.controller('TabController', function ($scope) {

    $scope.actualPage = "admin";

    $scope.affichePage = affichePage;

    function affichePage (page){
        $scope.actualPage  = page;
        console.log($scope.actualPage);
    }

});