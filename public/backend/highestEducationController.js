app.controller('highestEducationCtrl', ['$scope', 'Data', '$rootScope','$timeout','toaster', function ($scope, Data, $rootScope,$timeout,toaster) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.manageHighestEducation = function () {
            Data.post('highest-education/manageHighestEducation').then(function (response) {
                $scope.educationRow = response.records;

            });
        };
        $scope.initialModal = function (id, education,status, index) {
            $scope.heading = 'Highest Education';
            $scope.id = id;
            $scope.education = education;
            $scope.index = index;
            $scope.status = status;
            $scope.sbtBtn = false;
        }
        $scope.doHighestEducationAction = function () {
            $scope.errorMsg = '';
           
            if ($scope.id === 0) //for create
            {
                Data.post('highest-education/', {
                    education: $scope.education,status :$scope.status}).then(function (response) {
             
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.educationRow.push({'education': $scope.education, 'id': response.lastinsertid,'status':$scope.status});
                        $('#highesteducModal').modal('toggle');
                       toaster.pop('success', 'Highest education', 'Record successfully created');
                    }
                });
            } else { //for update

                Data.put('highest-education/'+$scope.id, {
                    education: $scope.education, id: $scope.id,'status':$scope.status}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.educationRow.splice($scope.index, 1);
                        $scope.educationRow.splice($scope.index, 0, {
                            education: $scope.education, id: $scope.id,'status':$scope.status});
                        $('#highesteducModal').modal('toggle');
                      toaster.pop('success', 'Highest education', 'Record successfully updated');
                    }
                });
            }
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        
    }]);
