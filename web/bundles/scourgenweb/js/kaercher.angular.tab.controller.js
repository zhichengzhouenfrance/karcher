kaercherApp.controller('TabController', function ($scope,StatistiqueService) {

    $scope.actualPage = "admin";
    $scope.adminActive = 'active';
    $scope.statisticActive = '';

    $scope.affichePage = affichePage;

    function affichePage (page){
        $scope.actualPage  = page;
        if(page==="admin"){
            $scope.adminActive = 'active';
            $scope.statisticActive='';
        }else{
            $scope.adminActive = ''
            $scope.statisticActive='active';
        }
    }

    Date.prototype.getWeek = function() {
        var onejan = new Date(this.getFullYear(), 0, 1);
        return Math.ceil((((this - onejan) / 86400000) + onejan.getDay() + 1) / 7);
    }

    var nomsDesMois = new Array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre") ;
    var d = new Date();
    var n = d.getMonth();
    $scope.moisCourrant  = nomsDesMois[n];
    $scope.yearCourrant = d.getFullYear();
    $scope.dayCourrant = d.getDate();
    $scope.weekCourrant = d.getWeek();

    StatistiqueService.getStatistiques().then(function(statistiques){
        var nombres = statistiques.nombre;
        $scope.nombreToday = nombres[0];
        $scope.nombreWeek = nombres[1];
        $scope.nombreMonth = nombres[2];
        $scope.nombreYear = nombres[3];

        console.log($scope.nombreToday,$scope.nombreMonth,$scope.nombreYear);
    });



});