kaercherApp.controller('LoginController', function ($scope) {

    $scope.login;

    $scope.isDisabled ;

    $scope.validateLogin = function(){
        $scope.isDisabled = true;
        if($scope.login.length >= 10 && $scope.login.indexOf('1701') == 0){
            $scope.isDisabled = false;
        }
    }

});