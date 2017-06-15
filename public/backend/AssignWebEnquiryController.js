'use strict';
app.controller('autoassignEnquiriesCtrl', ['$scope', 'Data', function ($scope, Data) {
        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.manageEnquiries = function () {
            Data.post('assign-enquiry/manageAutoEnquiries').then(function (response) {
                $scope.EnquirieRow = response.records;
            });
        };

        $scope.doautoenquiriesAction = function () { 
            $scope.errorMsg = '';
            Data.put('assign-enquiry/' + $scope.employee_id, {
                employee_id: $scope.employee_id}).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.errormsg;
                }
            });
        }
    }]);