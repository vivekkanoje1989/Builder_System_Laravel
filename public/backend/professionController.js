app.controller('manageProfessionCtrl', ['$scope', 'Data', 'toaster', function ($scope, Data, toaster) {

        $scope.manageProfession = function () {
            Data.post('manage-profession/manageProfession').then(function (response) {
                $scope.professionRow = response.records;
            });
        };
        $scope.initialModal = function (id, profession,status,index) {
            $scope.heading = 'Profession';
            $scope.id = id;
            $scope.profession = profession;
            $scope.index = index;
            $scope.status = status;
            $scope.sbtBtn = false;
        }
        $scope.doprofessionAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('manage-profession/', {
                    profession: $scope.profession,status:$scope.status}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.professionRow.push({'profession': $scope.profession, 'id': response.lastinsertid,'status':$scope.status});
                        $('#professionModal').modal('toggle');
                        toaster.pop('success', 'Manage profession', 'Record successfully created');
                    }
                });
            } else { //for update
                Data.put('manage-profession/' + $scope.id, {
                    profession: $scope.profession, id: $scope.id,status:$scope.status}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.professionRow.splice($scope.index, 1);
                        $scope.professionRow.splice($scope.index, 0, {
                            profession: $scope.profession, id: $scope.id,'status':$scope.status});
                        $('#professionModal').modal('toggle');
                        toaster.pop('success', 'Manage profession', 'Record successfully updated');
                    }
                });
            }
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);
