app.controller('managePaymentHeadingCtrl', ['$scope', 'Data', '$rootScope','$timeout', function ($scope, Data, $rootScope,$timeout) {

        $scope.managePaymentHeading = function () {
            Data.get('payment-headings/managePaymentHeading').then(function (response) {
                $scope.PaymentHeadingRow = response.records;
               console.log($scope.PaymentHeadingRow);
                
            });
        };
        
        $scope.getProjectNames = function(){
            Data.post('payment-headings/manageProjectTypes').then(function (response) {
                $scope.getProjectNamesRow = response.records;
               
            });
        }
        $scope.initialModal = function (id, payment_heading,tax_heading,date_dependent_tax,tax_applicable,index) {

            $scope.heading = 'Project Heading';
            if(id == 0)
            {
                $scope.tax_heading = 1;
                $scope.date_dependent_tax = 1;
                $scope.tax_applicable = 1;
            }else
            {
                $scope.tax_heading = tax_heading;
                $scope.date_dependent_tax = date_dependent_tax;
                $scope.tax_applicable = tax_applicable;
            }
            $scope.id = id;
            $scope.payment_heading = payment_heading;
            $scope.index = index;
        }
        $scope.dopaymentheadingAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('payment-headings/', { payment_heading:$scope.payment_heading,tax_heading:$scope.tax_heading,date_dependent_tax:$scope.date_dependent_tax,tax_applicable:$scope.tax_applicable}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#paymentheadingModal').modal('toggle');
                        $scope.PaymentHeadingRow.push({'payment_heading': $scope.payment_heading, 'id':response.lastinsertid,'project_type_id': $scope.project_type_id,'tax_heading':$scope.tax_heading,'date_dependent_tax':$scope.date_dependent_tax,tax_applicable:$scope.tax_applicable});
                       
                        // $scope.success("Payment heading created successfully");   
                    }
                });
            } else { //for update

                Data.put('payment-headings/'+$scope.id, {
                     payment_heading:$scope.payment_heading,tax_heading:$scope.tax_heading,date_dependent_tax:$scope.date_dependent_tax,tax_applicable:$scope.tax_applicable}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.PaymentHeadingRow.splice($scope.index, 1);
                        $scope.PaymentHeadingRow.splice($scope.index, 0, {
                            'payment_heading': $scope.payment_heading, 'id': $scope.id,'tax_heading':$scope.tax_heading,'date_dependent_tax':$scope.date_dependent_tax,tax_applicable:$scope.tax_applicable});
                        $('#paymentheadingModal').modal('toggle');
                       // $scope.success("Payment heading updated successfully");   
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
