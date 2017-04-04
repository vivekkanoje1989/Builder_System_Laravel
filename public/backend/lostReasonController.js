app.controller('lostReasonsController', ['$scope', 'Data','toaster', function ($scope, Data,toaster) {
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
            $scope.sbtBtn = false;
        };
        $scope.doLostReasonsAction = function ()
        {
            if ($scope.actionModal === 0)
            { //create
                Data.post('lost-reasons/', {
                    reason: $scope.reason, lost_reason_status: $scope.lost_reason_status
                }).then(function (response) {

                    if (response.success) {
                        $scope.listLostReasons.push({'id': response.lastinsertid, 'reason': $scope.reason, lost_reason_status: $scope.lost_reason_status});
                        $('#lostReasonModal').modal('toggle');
                        toaster.pop('success', 'Lost reason', 'Record successfully created');
                    }
                });
            } else
            { //update
                Data.put('lost-reasons/' + $scope.actionModal, {
                    reason: $scope.reason, lost_reason_status: $scope.lost_reason_status, id: $scope.actionModal
                }).then(function (response) {

                    $('#lostReasonModal').modal('toggle');
                    $scope.listLostReasons.splice($scope.index, 1);
                    $scope.listLostReasons.splice($scope.index, 0, {
                        reason: $scope.reason, lost_reason_status: $scope.lost_reason_status, id: $scope.actionModal});
                    toaster.pop('success', 'Lost reason', 'Record successfully updated');
                });
            }
        }
    }]);
