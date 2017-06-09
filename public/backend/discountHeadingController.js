app.controller('discountheadingController', ['$scope', 'Data', '$rootScope', 'toaster', function ($scope, Data, $rootScope, toaster) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;

        $scope.manageDiscountHeading = function () {

            Data.post('discount-headings/manageDiscountHeading').then(function (response) {
                $scope.DiscountHeadingRow = response.records;
            });
        };
        $scope.initialModal = function (id, discount_name, status, index, index1) {

            if (id == 0)
            {
                $scope.heading = 'Add Discount Heading';
                $scope.action = 'submit';
            } else {
                $scope.heading = 'Edit Discount Heading';
                $scope.action = 'Update';
            }
            $scope.actionModal = id;
            $scope.discount_name = discount_name;
            $scope.status = status;
            $scope.sbtBtn = false;
            $scope.index = index * ($scope.noOfRows - 1) + (index1);
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
                    }
                });
            } else { //for update
                Data.put('discount-headings/' + $scope.actionModal, {
                    discount_name: $scope.discount_name, status: $scope.status, id: $scope.actionModal}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.DiscountHeadingRow.splice($scope.index, 1);
                        $scope.DiscountHeadingRow.splice($scope.index, 0, {
                            discount_name: $scope.discount_name, 'status': $scope.status, id: $scope.id});
                        $('#discountheadingModal').modal('toggle');
                    }
                });
            }
        }

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);
