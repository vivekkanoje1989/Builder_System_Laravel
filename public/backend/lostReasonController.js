app.controller('lostReasonsController', ['$rootScope', '$scope', '$state', 'Data', '$timeout', '$parse',function ($rootScope, $scope, $state, Data, $timeout, $parse) {
        $scope.heading = 'Create Lost Reason';
        $scope.manageLostReasons = function () {
            $scope.modal = {};
            Data.post('lost-reasons/manageLostReason').then(function (response) {
                $scope.listLostReasons = response.records;
            });
        };
        $scope.initialModal = function (id, reason, status, index) {
            $scope.actionModal = id;
            $scope.heading = 'Lost Reason';
            $scope.reason = reason;
            $scope.lost_reason_status = status;
            $scope.index = index;
        };

        $scope.doLostReasonsAction = function ()
        {
            if ($scope.actionModal === 0)
            { //create
                Data.post('lost-reasons/', {
                    reason: $scope.reason, lost_reason_status: $scope.lost_reason_status
                }).then(function (response) {
                  
                    if (response.success) {
                        $scope.listLostReasons.push({'id': response.lastinsertid,'reason': $scope.reason, lost_reason_status: $scope.lost_reason_status});
                        $('#lostReasonModal').modal('toggle');
                       // $scope.success("Lost reason details created successfully"); 
                    }
                });
            } else
            { //update
                Data.put('lost-reasons/'+ $scope.actionModal, {
                    reason: $scope.reason, lost_reason_status: $scope.lost_reason_status, id: $scope.actionModal
                }).then(function (response) {
                    
                         $('#lostReasonModal').modal('toggle');
                        $scope.listLostReasons.splice($scope.index, 1);
                        $scope.listLostReasons.splice($scope.index, 0, {
                            reason: $scope.reason, lost_reason_status: $scope.lost_reason_status, id: $scope.actionModal});
                        //$scope.success("Lost reason details updated successfully"); 

                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
    }]);
