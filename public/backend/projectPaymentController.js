app.controller('paymentHeadingController', ['$scope', 'Data', 'toaster', '$parse', function ($scope, Data, toaster, $parse) {
        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.paymentData = [];
        $scope.payHeading = false;
        $scope.managePaymentHeading = function () {
            Data.get('payment-headings/managePaymentHeading').then(function (response) {
                $scope.paymentDetails = response.records;
            });
        };
        $scope.getProjectNames = function () {
            Data.post('payment-headings/manageProjectTypes').then(function (response) {
                $scope.getProjectNamesRow = response.records;
            });
        }
        $scope.initialModal = function (id, payment_heading, tax_heading, date_dependent_tax, tax_applicable, index, index1) {

            if (id == 0)
            {
                $scope.paymentData.tax_heading = '';
                $scope.paymentData.date_dependent_tax = '';
                $scope.paymentData.tax_applicable = '';
                $scope.heading = 'Add payment heading';
                $scope.action = 'Submit';
            } else {
                $scope.paymentData.tax_heading = tax_heading;
                $scope.paymentData.date_dependent_tax = date_dependent_tax;
                $scope.paymentData.tax_applicable = tax_applicable;
                $scope.heading = 'Edit payment heading';
                $scope.action = 'Update';
            }
            $scope.id = id;
            $scope.paymentData.payment_heading = payment_heading;
            $scope.index = index * ($scope.noOfRows - 1) + (index1);
            $scope.sbtBtn = false;
        }
        $scope.dopaymentheadingAction = function (paymentData) {
            $scope.errorMsg = '';
            $scope.payHeading = true;
            if ($scope.id === 0) //for create
            {
                $scope.payHeading = false;
                Data.post('payment-headings/', {paymentData: paymentData}).then(function (response) {
                    if (!response.success)
                    {
                        var obj = response.message;
                        var selector = [];
                        for (var key in obj) {
                            var model = $parse(key); // Get the model
                            model.assign($scope, obj[key][0]); // Assigns a value to it
                            selector.push(key);
                        }
                        $scope.errorMsg = response.errormsg;
                    } else {

                        $('#paymentheadingModal').modal('toggle');
                        $scope.PaymentHeadingRow.push({'payment_heading': response.records.payment_heading, 'id': response.lastinsertid, 'project_type_id': response.records.project_type_id, 'tax_heading': response.records.tax_heading, 'date_dependent_tax': response.records.date_dependent_tax, tax_applicable: response.records.tax_applicable});
                        toaster.pop('success', 'Payment Heading', 'Record created successfully');
                    }
                });
            } else { //for update
                
                $scope.payHeading = false;
                Data.put('payment-headings/' + $scope.id, {
                    paymentData: paymentData}).then(function (response) {
                    if (!response.success)
                    {
                        var obj = response.message;
                        var selector = [];
                        for (var key in obj) {
                            var model = $parse(key);// Get the model
                            model.assign($scope, obj[key][0]);// Assigns a value to it
                            selector.push(key);
                        }
                        $scope.errorMsg = response.errormsg;
                    } else {

                        $scope.PaymentHeadingRow.splice($scope.index, 1);
                        $scope.PaymentHeadingRow.splice($scope.index, 0, {
                            'payment_heading': response.records.payment_heading, 'id': $scope.id, 'tax_heading': response.records.tax_heading, 'date_dependent_tax': response.records.date_dependent_tax, tax_applicable: response.records.tax_applicable});
                        $('#paymentheadingModal').modal('toggle');
                        toaster.pop('success', 'Payment Heading', 'Record updated successfully');
                    }
                });
            }
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);
