kaercherApp.controller('TabController', function ($scope) {

    console.log("test");

    $scope.test = "test";

    $scope.afficheTest = afficheTest;

    function afficheTest (){
        console.log($scope.test);
    }

});