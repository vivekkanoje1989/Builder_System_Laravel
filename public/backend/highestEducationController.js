app.controller('highestEducationCtrl', ['$scope', 'Data', function ($scope, Data) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.manageHighestEducation = function () {
            Data.post('highest-education/manageHighestEducation').then(function (response) {
                $scope.educationRow = response.records;

            });
        };
        $scope.initialModal = function (id, education, status, index, index1) {
       
            if (id == 0)
            {
                $scope.heading = 'Add Highest Education';
                $scope.id = '0';
                $scope.education = '';
                $scope.action = 'Submit';
            } else
            {
                $scope.heading = 'Edit Highest Education';

                $scope.action = 'Update';
            }
            $scope.id = id;
            $scope.status = status;
            $scope.education = education;
            $scope.index = index * ($scope.noOfRows - 1) + (index1);
            $scope.sbtBtn = false;
        }
        $scope.doHighestEducationAction = function () {
            $scope.errorMsg = '';
            if ($scope.id == '0') //for create
            {
                Data.post('highest-education/', {
                    education: $scope.education,'status':$scope.status,}).then(function (response) {
               
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.educationRow.push({'education': $scope.education,'status':$scope.status, 'id': response.lastinsertid});
                        $('#highesteducModal').modal('toggle');
                        // $scope.success("Education details Created successfully"); 
                    }
                });
            } else { //for update

                Data.put('highest-education/' + $scope.id, {
                    education: $scope.education,'status':$scope.status}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.educationRow.splice($scope.index, 1);
                        $scope.educationRow.splice($scope.index, 0, {
                            education: $scope.education,'status':$scope.status, id: $scope.id});
                        $('#highesteducModal').modal('toggle');
                        //$scope.success("Education details updated successfully"); 
                    }
                });
            }
        }
       
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);
