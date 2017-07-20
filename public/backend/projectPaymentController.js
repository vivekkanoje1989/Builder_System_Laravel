app.controller('paymentHeadingController', ['$scope', 'Data', 'toaster', function ($scope, Data, toaster) {
    $scope.itemsPerPage = 30;
    $scope.noOfRows = 1;
    $scope.managePaymentHeading = function () {
        Data.get('payment-headings/managePaymentHeading').then(function (response) {
            $scope.PaymentHeadingRow = response.records;
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
            $scope.tax_heading = '';
            $scope.date_dependent_tax = '';
            $scope.tax_applicable = '';
            $scope.heading = 'Add payment heading';
            $scope.action = 'Submit';
        } else{
            $scope.tax_heading = tax_heading;
            $scope.date_dependent_tax = date_dependent_tax;
            $scope.tax_applicable = tax_applicable;
            $scope.heading = 'Edit payment heading';
            $scope.action = 'Update';
        }
        $scope.id = id;
        $scope.payment_heading = payment_heading;
        $scope.index = index * ($scope.noOfRows - 1) + (index1);
        $scope.sbtBtn = false;
    }
    $scope.dopaymentheadingAction = function () {
        $scope.errorMsg = '';
        if ($scope.id === 0) //for create
        {
            Data.post('payment-headings/', {payment_heading: $scope.payment_heading, tax_heading: $scope.tax_heading, date_dependent_tax: $scope.date_dependent_tax, tax_applicable: $scope.tax_applicable}).then(function (response) {
                if (!response.success)
                {
                    $scope.errorMsg = response.errormsg;
                } else {

                    $('#paymentheadingModal').modal('toggle');
                    $scope.PaymentHeadingRow.push({'payment_heading': $scope.payment_heading, 'id': response.lastinsertid, 'project_type_id': $scope.project_type_id, 'tax_heading': $scope.tax_heading, 'date_dependent_tax': $scope.date_dependent_tax, tax_applicable: $scope.tax_applicable});
                    toaster.pop('success', 'Payment Heading', 'Record created successfully');
                }
            });
        } else { //for update
            Data.put('payment-headings/' + $scope.id, {
                payment_heading: $scope.payment_heading, tax_heading: $scope.tax_heading, date_dependent_tax: $scope.date_dependent_tax, tax_applicable: $scope.tax_applicable}).then(function (response) {
                if (!response.success)
                {
                    $scope.errorMsg = response.errormsg;
                } else {

                    $scope.PaymentHeadingRow.splice($scope.index, 1);
                    $scope.PaymentHeadingRow.splice($scope.index, 0, {
                        'payment_heading': $scope.payment_heading, 'id': $scope.id, 'tax_heading': $scope.tax_heading, 'date_dependent_tax': $scope.date_dependent_tax, tax_applicable: $scope.tax_applicable});
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
