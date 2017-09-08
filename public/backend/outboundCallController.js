'use strict';
app.controller('outboundCallController', ['$scope', 'Data', 'toaster', function ($scope, Data, toaster) {
      
        $scope.cloudCallingLog = function (modules, employee_id, enquire_id, customer_id, sequence) {
            Data.post('cloudcallinglogs/out', {
                modules: modules, employee_id: employee_id, enquire_id: enquire_id, customer_id: customer_id, sequence: sequence
            }).then(function (response) {
                var successMsg = response.message;
                toaster.pop('success', 'Call Status', successMsg);
            });
        }
}]);
