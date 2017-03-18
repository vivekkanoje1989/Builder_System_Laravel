'use strict';
app.controller('autoassignEnquiriesCtrl', ['$scope', 'Data', '$rootScope','$timeout', function ($scope, Data, $rootScope,$timeout) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.manageEnquiries = function () {
            Data.post('assign-enquiry/manageAutoEnquiries').then(function (response) {
                $scope.EnquirieRow = response.records;
            });
        };
      
        $scope.doautoenquiriesAction = function () {
           
            $scope.errorMsg = '';
                Data.put('assign-enquiry/'+ $scope.employee_id, {
                    employee_id: $scope.employee_id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        
                       // $scope.success("Contact details updated successfully");
                    }
                });
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
    }]);