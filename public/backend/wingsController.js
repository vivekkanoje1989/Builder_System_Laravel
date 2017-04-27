app.controller('wingsController', ['$scope', '$state', 'Data', 'toaster', '$timeout', function ($scope, $state, Data, toaster, $timeout) {
        $scope.currentPage = $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.wingData = {};

        $scope.manageWings = function (id)
        {
            Data.post('wings/getWingList', {id: id}).then(function (response) {
                if (id < 0)
                { // For Index
                    $scope.listWings = response.records;
                    console.log($scope.listWings);
                }
                if (id > 0)
                { // For Update
                    $scope.pageHeading = "Update Wing";
                    $scope.savebtn = "Save";
                    $scope.wingData = angular.copy(response.records[0]);
                }
                if (id === 0)
                { // For Craete
                    $scope.pageHeading = "Create Wing";
                    $scope.savebtn = "Create";
                }
            })

        }
        $scope.saveWingsInfo = function (wingData, id) {
            wingData.wing_status = (typeof wingData.wing_status === 'undefined') ? 2 : wingData.wing_status;
            wingData.wing_status_for_enquiries = (typeof wingData.wing_status_for_enquiries === 'undefined') ? 2 : wingData.wing_status_for_enquiries;
            wingData.wing_status_for_bookings = (typeof wingData.wing_status_for_bookings === 'undefined') ? 2 : wingData.wing_status_for_bookings;
            if (id === 0)
            { // For Create
                Data.post('wings', {wingData: wingData}).then(function (response) {
                    if (!response.success)
                    {
                        toaster.pop('error', 'Project Wings', 'Something Went Wrong');
                    } else
                    {
                        toaster.pop('success', 'Project Wings', 'Wing Created Successfully.');
                        $state.go(getUrl + '.wingsIndex');
                    }
                })
            } else
            { // For Update 
                Data.put('wings/'+id, {wingData: wingData}).then(function (response) {
                    if (!response.success)
                    {
                        toaster.pop('error', 'Project Wings', 'Something Went Wrong');
                    } else
                    {
                        toaster.pop('success', 'Project Wings', 'Wing Updated Successfully.');
                        $state.go(getUrl + '.wingsIndex');
                    }
                })
            }
        }
    }]);