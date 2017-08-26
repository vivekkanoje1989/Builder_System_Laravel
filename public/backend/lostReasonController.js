app.controller('lostReasonsController', ['$scope', 'Data', 'toaster', function ($scope, Data, toaster) {
        $scope.heading = 'Create Lost Reason';
        $scope.noOfRows = 1;
        $scope.itemsPerPage = 30;
        $scope.manageLostReasons = function () {
            $scope.modal = {};
            Data.post('lost-reasons/manageLostReason').then(function (response) {
                $scope.listLostReasons = response.records;
            });
        };
        $scope.searchDetails = {};
        $scope.searchData = {};

        $scope.filterDetails = function (search) {
//            $scope.searchDetails = {};
            $scope.searchData = search;
            $('#showFilterModal').modal('hide');
        }
        $scope.removeFilterData = function (keyvalue) {
            delete $scope.searchData[keyvalue];
            $scope.filterDetails($scope.searchData);
        }
        $scope.closeModal = function () {
            $scope.searchData = {};
        }

        $scope.initialModal = function (id, reason, status, index, index1) {
            if (id == 0)
            {
                $scope.heading = 'Add Lost Reason';
                $scope.actionModal = '0';
                $scope.reason = '';
                $scope.lost_reason_status = '';
                $scope.action = 'Add';
            } else {
                $scope.heading = 'Edit Lost Reason';
                $scope.actionModal = id;
                $scope.reason = reason;
                $scope.lost_reason_status = status;
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
                    } else {
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
                    } else {
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
