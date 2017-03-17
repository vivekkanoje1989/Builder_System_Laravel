app.controller('manageProfessionCtrl', ['$scope', 'Data', '$rootScope','$timeout', function ($scope, Data, $rootScope,$timeout) {

        $scope.manageProfession = function () {
            Data.post('manage-profession/manageProfession').then(function (response) {
                $scope.professionRow = response.records;

            });
        };
        $scope.initialModal = function (id, profession, index) {

            $scope.heading = 'Profession';
            $scope.id = id;
            $scope.profession = profession;
            $scope.index = index;

        }
        $scope.doprofessionAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('manage-profession/', {
                    profession: $scope.profession}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {

                        $scope.professionRow.push({'profession': $scope.profession, 'id': response.lastinsertid});
                       // $scope.success("Profession details created successfully"); 
                              $('#professionModal').modal('toggle');
                    }

                });
            } else { //for update

                Data.put('manage-profession/'+$scope.id, {
                    profession: $scope.profession, id: $scope.id}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.professionRow.splice($scope.index, 1);
                        $scope.professionRow.splice($scope.index, 0, {
                            profession: $scope.profession, id: $scope.id});
                        $('#professionModal').modal('toggle');
                       // $scope.success("Profession details updated successfully"); 
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
