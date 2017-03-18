'use strict';
/*******************************MANOJ*********************************/
app.controller('contactUsCtrl', ['$scope', 'Data', '$rootScope', '$timeout', function ($scope, Data, $rootScope, $timeout) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.manageContactUs = function () {
            Data.post('contact-us/manageContactUs').then(function (response) {
                $scope.contactUsRow = response.records;

            });
        };
        $scope.initialModal = function (id, address, telephone, email, index) {

            $scope.heading = 'Update office address';
            $scope.id = id;
            $scope.address = address;
            $scope.index = index;
            $scope.telephone = telephone;
            $scope.email = email;
        }
        $scope.doContactusAction = function () {
            $scope.errorMsg = '';
            Data.put('contact-us/'+$scope.id, {
                address: $scope.address, id: $scope.id, 'telephone': $scope.telephone, 'email': $scope.email}).then(function (response) {

                if (!response.success)
                {
                    $scope.errorMsg = response.errormsg;
                } else {
                    $scope.contactUsRow.splice($scope.index - 1, 1);
                    $scope.contactUsRow.splice($scope.index - 1, 0, {
                        address: $scope.address, id: $scope.id, name: $scope.name, 'telephone': $scope.telephone, 'email': $scope.email});

                    $('#contactUsModal').modal('toggle');
                  //  $scope.success("Contact details updated successfully");
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