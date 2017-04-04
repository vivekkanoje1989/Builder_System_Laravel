app.controller('discountheadingController',['$scope', 'Data', '$rootScope','$timeout','toaster', function ($scope, Data, $rootScope,$timeout,toaster) {

        $scope.manageDiscountHeading = function () {
           
            Data.post('discount-headings/manageDiscountHeading').then(function (response) {
                $scope.DiscountHeadingRow = response.records;
            });
        };
        $scope.initialModal = function (id, discount_name, status, index) {

            $scope.heading = 'Discount Heading';
            $scope.actionModal = id;
            $scope.discount_name = discount_name;
            $scope.status = status;
            $scope.index = index;
            $scope.sbtBtn = false;
        }
        $scope.doDiscountHeadingAction = function () {
            $scope.errorMsg = '';
            if ($scope.actionModal === 0) //for create
            {
                Data.post('discount-headings/', {
                    discount_name: $scope.discount_name}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#discountheadingModal').modal('toggle');
                        $scope.DiscountHeadingRow.push({'discount_name': $scope.discount_name, 'id': response.lastinsertid, 'status': $scope.status});
                        toaster.pop('success', 'Manage discount heading', 'Record successfully created');
                    }
                });
            } else { //for update

                Data.put('discount-headings/'+$scope.actionModal, {
                    discount_name: $scope.discount_name, status: $scope.status, id: $scope.actionModal}).then(function (response) {
                  
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.DiscountHeadingRow.splice($scope.index, 1);
                        $scope.DiscountHeadingRow.splice($scope.index, 0, {
                            discount_name: $scope.discount_name, id: $scope.id, 'status': $scope.status});
                        $('#discountheadingModal').modal('toggle');
                         toaster.pop('success', 'Manage discount heading', 'Record successfully updated');
                    }
                });
            }
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        
    }]);