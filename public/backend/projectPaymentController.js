app.controller('managePaymentHeadingCtrl', ['$scope', 'Data', '$rootScope','$timeout', function ($scope, Data, $rootScope,$timeout) {

        $scope.managePaymentHeading = function () {
            Data.get('payment-headings/managePaymentHeading').then(function (response) {
                $scope.PaymentHeadingRow = response.records;
         
                
            });
        };
        
        $scope.getProjectNames = function(){
            Data.post('payment-headings/manageProjectTypes').then(function (response) {
                $scope.getProjectNamesRow = response.records;
               
            });
        }
        $scope.initialModal = function (id, type_of_payment,project_type_id,is_tax_heading,is_date_dependent,index) {

            $scope.heading = 'Project Heading';
            if(id == 0)
            {
                $scope.is_tax_heading = 1;
                $scope.is_date_dependent = 1;
            }else
            {
                $scope.is_tax_heading = is_tax_heading;
                $scope.is_date_dependent = is_date_dependent;
            }
            $scope.id = id;
            $scope.project_type_id = project_type_id;
            $scope.type_of_payment = type_of_payment;
            $scope.index = index;
        }
        $scope.dopaymentheadingAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('payment-headings/', { type_of_payment:$scope.type_of_payment,
                    project_type_id: $scope.project_type_id,is_tax_heading:$scope.is_tax_heading,is_date_dependent:$scope.is_date_dependent}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#paymentheadingModal').modal('toggle');
                        $scope.PaymentHeadingRow.push({'type_of_payment': $scope.type_of_payment, 'id': $scope.PaymentHeadingRow.length + 1,'project_type_id': $scope.project_type_id,'is_tax_heading':$scope.is_tax_heading,'is_date_dependent':$scope.is_date_dependent});
                       
                        // $scope.success("Payment heading created successfully");   
                    }
                });
            } else { //for update

                Data.put('payment-headings/'+$scope.id, {
                     type_of_payment:$scope.type_of_payment,
                    project_type_id: $scope.project_type_id,id:$scope.id,is_tax_heading:$scope.is_tax_heading,is_date_dependent:$scope.is_date_dependent,is_tax_heading:$scope.is_tax_heading,is_date_dependent:$scope.is_date_dependent}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.PaymentHeadingRow.splice($scope.index, 1);
                        $scope.PaymentHeadingRow.splice($scope.index, 0, {
                            'type_of_payment': $scope.type_of_payment, 'id': $scope.id,'project_type_id': $scope.project_type_id,'is_tax_heading':$scope.is_tax_heading,'is_date_dependent':$scope.is_date_dependent});
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
