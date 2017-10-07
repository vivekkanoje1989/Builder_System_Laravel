app.controller('websiteChangeController', ['$rootScope', '$scope', '$state', 'Data', 'Upload', '$timeout', '$parse', '$stateParams', 'toaster', 'SweetAlert', function ($rootScope, $scope, $state, Data, Upload, $timeout, $parse, $stateParams, toaster, SweetAlert) {
     
     
     $scope.manageThemes = function () {
            $scope.showloader();
            Data.post('websiteChange/getThemes').then(function (response) {
                $scope.hideloader();
                $scope.themesRow = response.records;

            });
        };
    }])