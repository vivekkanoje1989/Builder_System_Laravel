app.controller('socialwebsitesCtrl', ['$scope', 'Data', '$rootScope', '$timeout','$state', function ($scope, Data, $rootScope, $timeout, $state ) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.manageSocialWebsite = function () {
            Data.post('social-website/manageSocialWebsite').then(function (response) {
                $scope.socialwebsiteRow = response.records;

            });
        };
        $scope.initialModal = function (id, name, link, status, index) {

            $scope.heading = 'Update social website';
            $scope.id = id;
            $scope.name = name;
            $scope.index = index;
            $scope.link = link;
            $scope.status = status;
        }
        $scope.dosocialwebsiteAction = function () {
            $scope.errorMsg = '';

            Data.put('social-website/'+$scope.id, {
                name: $scope.name, id: $scope.id, link: $scope.link, status: $scope.status}).then(function (response) {
                if (!response.success)
                {
                    $scope.errorMsg = response.errormsg;
                } else {
                    $scope.socialwebsiteRow.splice($scope.index, 1);
                    $scope.socialwebsiteRow.splice($scope.index, 0, {
                        name: $scope.name, id: $scope.id, link: $scope.link, status: $scope.status});
                    $('#contactUsModal').modal('toggle');
                    //$scope.success("Social website details updated successfully");
                }
            });
        }
        $scope.success = function (message) {
            Flash.create('success', message);
        };

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);
