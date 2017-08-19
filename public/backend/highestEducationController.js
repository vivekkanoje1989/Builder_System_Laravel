app.controller('highestEducationCtrl', ['$scope', 'Data', function ($scope, Data) {

        $scope.itemsPerPage = 30;
        $scope.eduBtn = false;
        $scope.noOfRows = 1;
        
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
            $scope.eduBtn = true;
            if ($scope.id == '0') //for create
            {
                $scope.eduBtn = false;
                Data.post('highest-education/', {
                    education: $scope.education, 'status': $scope.status, }).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.educationRow.push({'education': $scope.education, 'status': $scope.status, 'id': response.lastinsertid});
                        $('#highesteducModal').modal('toggle');
                        // $scope.success("Education details Created successfully"); 
                    }
                });
            } else { //for update
                $scope.eduBtn = false;
                Data.put('highest-education/' + $scope.id, {
                    education: $scope.education, 'status': $scope.status}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.educationRow.splice($scope.index, 1);
                        $scope.educationRow.splice($scope.index, 0, {
                            education: $scope.education, 'status': $scope.status, id: $scope.id});
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
