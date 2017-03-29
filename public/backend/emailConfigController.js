app.controller('emailconfigCtrl', ['$scope', 'Data', '$rootScope', '$timeout', function ($scope, Data, $rootScope, $timeout) {

 $scope.currentPage =  $scope.itemsPerPage = 4;
    $scope.noOfRows = 1;
        $scope.manageEmailConfig = function (id)
        {
            Data.post('email-config/manageEmails',{id:id}).then(function (response) {
               $scope.listmails =response.records;
            });
        }
    }]);