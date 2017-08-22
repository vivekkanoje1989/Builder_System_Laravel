app.controller('manageProfessionCtrl', ['$scope', 'Data', 'toaster', function ($scope, Data, toaster) {

        $scope.noOfRows = 1;
        $scope.itemsPerPage = 30;
        $scope.profBtn = false;
        $scope.manageProfession = function () {
            Data.post('manage-profession/manageProfession').then(function (response) {
                $scope.professionRow = response.records;

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


        $scope.initialModal = function (id, profession, status, index, index1) {

            if (id == 0)
            {
                $scope.heading = 'Add Profession';
                $scope.action = 'submit';
            } else {
                $scope.heading = 'Edit Profession';
                $scope.action = 'Update';
            }
            $scope.id = id;
            $scope.profession = profession;
            $scope.status = status;
            $scope.sbtBtn = false;
            $scope.index = index * ($scope.noOfRows - 1) + (index1);
        }
        $scope.doprofessionAction = function () {
            $scope.errorMsg = '';
            $scope.profBtn = true;
            if ($scope.id == 0) //for create
            {
                $scope.profBtn = false;
                Data.post('manage-profession/', {
                    profession: $scope.profession, 'status': $scope.status}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.professionRow.push({'profession': $scope.profession, 'status': $scope.status, 'id': response.lastinsertid});
                        toaster.pop('success', 'Manage Profession', "record created successfully");
                        $('#professionModal').modal('toggle');
                    }
                });
            } else { //for update
                $scope.profBtn = false;
                Data.put('manage-profession/' + $scope.id, {
                    profession: $scope.profession, 'status': $scope.status, id: $scope.id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.professionRow.splice($scope.index, 1);
                        $scope.professionRow.splice($scope.index, 0, {
                            profession: $scope.profession, 'status': $scope.status, id: $scope.id});
                        toaster.pop('success', 'Manage Profession', "record updated successfully");
                        $('#professionModal').modal('toggle');
                    }
                });
            }
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);
