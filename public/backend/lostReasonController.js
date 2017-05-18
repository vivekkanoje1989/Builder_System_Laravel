app.controller('lostReasonsController', ['$rootScope', '$scope', '$state', 'Data', '$timeout', '$parse','toaster', function ($rootScope, $scope, $state, Data, $timeout, $parse,toaster) {
        $scope.heading = 'Create Lost Reason';
        $scope.noOfRows = 1;
        $scope.itemsPerPage = 4;
        $scope.manageLostReasons = function () {
            $scope.modal = {};
            Data.post('lost-reasons/manageLostReason').then(function (response) {
                $scope.listLostReasons = response.records;
            });
        };
        $scope.initialModal = function (id, reason, status, index,index1) {
            
               if (id == 0)
            {
                $scope.heading = 'Add Lost Reason';
                $scope.actionModal = '0';
                $scope.reason = '';
                $scope.lost_reason_status= '';
                $scope.action = 'submit';
            } else {
                $scope.heading = 'Edit Lost Reason';
                $scope.actionModal = id;
                $scope.reason = reason;
                $scope.lost_reason_status= status;
                $scope.action = 'Update'; 
            }
            $scope.sbtBtn = false;
            $scope.index = index * ($scope.noOfRows - 1) + (index1);
        };

        $scope.doLostReasonsAction = function ()
        {
            if ($scope.actionModal == 0)
            {
                Data.post('lost-reasons/', {
                    reason: $scope.reason, lost_reason_status: $scope.lost_reason_status
                }).then(function (response) {
                    if (response.success) {
                        toaster.pop('success', 'Manage lost reason', "record updated successfully");
                        $scope.listLostReasons.push({'id': response.lastinsertid, 'reason': $scope.reason, lost_reason_status: $scope.lost_reason_status});
                        $('#lostReasonModal').modal('toggle');
                        // $scope.success("Lost reason details created successfully"); 
                    }else{
                       $scope.errorMsg = response.errormsg;
                    }
                });
            } else
            { //update
                Data.put('lost-reasons/' + $scope.actionModal, {
                    reason: $scope.reason, lost_reason_status: $scope.lost_reason_status, id: $scope.actionModal
                }).then(function (response) {
console.log(response)
                    if (response.success) {
                        toaster.pop('success', 'Manage lost reason', "record updated successfully");
                        $('#lostReasonModal').modal('toggle');
                        $scope.listLostReasons.splice($scope.index, 1);
                        $scope.listLostReasons.splice($scope.index, 0, {
                            reason: $scope.reason, lost_reason_status: $scope.lost_reason_status, id: $scope.actionModal});
                        //$scope.success("Lost reason details updated successfully"); 
                    }else{
                       $scope.errorMsg = response.errormsg;
                    }

                });
            }
        }
        
        
         $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);
