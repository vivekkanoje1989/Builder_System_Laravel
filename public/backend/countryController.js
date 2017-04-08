app.controller('countryCtrl', ['$scope', 'Data', function ($scope, Data) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.manageCountry = function () {
            Data.get('manage-country/manageCountry').then(function (response) {
                $scope.countryRow = response.records;

            });
        };
        $scope.initialModal = function (id, name, index, index1,phonecode,sortname) {

            $scope.heading = 'Country';
            $scope.id = id;
            $scope.name = name;
            $scope.index = index * ($scope.noOfRows - 1) + (index1 + 1);
            $scope.phonecode = phonecode;
            $scope.sortname = sortname;
           
        }
        $scope.doCountryAction = function () {
            $scope.errorMsg = '';

            if ($scope.id === 0) //for create
            {
                Data.post('manage-country/', {
                    name: $scope.name,phonecode:$scope.phonecode,sortname:$scope.sortname}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.countryRow.push({'name': $scope.name,'id':response.lastinsertid,'sortname':$scope.sortname,'phonecode':$scope.phonecode});
                        $('#countryModal').modal('toggle');
                        //$scope.success("Country details created successfully");
                    }
                });
            } else { //for update

                Data.put('manage-country/'+$scope.id, {
                    name: $scope.name, id: $scope.id,'sortname':$scope.sortname,'phonecode':$scope.phonecode}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.countryRow.splice($scope.index - 1, 1);
                        $scope.countryRow.splice($scope.index - 1, 0, {
                            name: $scope.name, id: $scope.id, name: $scope.name,'sortname':$scope.sortname,'phonecode':$scope.phonecode });
                        $('#countryModal').modal('toggle');
                    }
                });
            }
        }
      
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);