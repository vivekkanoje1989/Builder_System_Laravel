app.controller('highestEducationCtrl', ['$scope', 'Data', '$rootScope','$timeout', function ($scope, Data, $rootScope,$timeout) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.manageHighestEducation = function () {
            Data.post('highest-education/manageHighestEducation').then(function (response) {
                $scope.educationRow = response.records;

            });
        };
        $scope.initialModal = function (id, education_title, index) {

            $scope.heading = 'Highest Education';
            $scope.education_id = id;
            $scope.education_title = education_title;
            $scope.index = index;
        }
        $scope.doHighestEducationAction = function () {
            $scope.errorMsg = '';
            if ($scope.education_id === 0) //for create
            {
                Data.post('highest-education/', {
                    education_title: $scope.education_title}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.educationRow.push({'education_title': $scope.education_title, 'education_id': response.lastinsertid});
                        $('#highesteducModal').modal('toggle');
                        // $scope.success("Education details Created successfully"); 
                    }
                });
            } else { //for update

                Data.put('highest-education/'+$scope.education_id, {
                    education_title: $scope.education_title, education_id: $scope.education_id}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.educationRow.splice($scope.index, 1);
                        $scope.educationRow.splice($scope.index, 0, {
                            education_title: $scope.education_title, education_id: $scope.education_id});
                        $('#highesteducModal').modal('toggle');
                        //$scope.success("Education details updated successfully"); 
                    }
                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        
    }]);
