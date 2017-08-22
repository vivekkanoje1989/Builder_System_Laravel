app.controller('paymentHeadingController', ['$scope', 'Data', 'toaster', '$rootScope', '$timeout','$parse', function ($scope, Data, toaster, $parse) {
       
        $scope.paymentData = {};
        $scope.payHeading = false;
        $scope.itemsPerPage = 30;
        $scope.pageNumber = 1;
        
        $scope.pageChanged = function (pageNo, functionName, id) {
            $scope[functionName](id, pageNo, $scope.itemsPerPage);
            $scope.pageNumber = pageNo;
        };

        $scope.noOfRows = 1;
        $scope.managePaymentHeading = function (empId, pageNumber, itemPerPage) {
            Data.post('payment-headings/managePaymentHeading').then(function (response) {
                $scope.paymentDetails = response.records;
                $scope.paymentDetailsLength = response.totalCount;
            });
        };
        
         $scope.searchData = {};
        $scope.searchDetails = {};
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
         
//        $scope.getProcName = $scope.type = '';
//        $scope.procName = function (procedureName, isTeam) {
//            $scope.getProcName = angular.copy(procedureName);
//            $scope.type = angular.copy(isTeam);
//        }
//
//
//        $scope.filterData = {};
//        $scope.data = {};
//
//        $scope.filteredData = function (data, page, noOfRecords) {
//            $scope.showloader();
//            page = noOfRecords * (page - 1);
//            Data.post('payment-headings/filteredData', {filterData: data, getProcName: $scope.getProcName, pageNumber: page, itemPerPage: noOfRecords}).then(function (response) {
//                if (response.success)
//                {
//                    $scope.paymentDetails = response.records;
//                    $scope.paymentDetailsLength = response.totalCount;
//                } else
//                {
//                    $scope.paymentDetails = response.records;
//                    $scope.paymentDetailsLength = 0;
//                }
//                $('#showFilterModal').modal('hide');
//                $scope.showFilterData = $scope.filterData;
//                $scope.hideloader();
//                return false;
//
//            });
//        }
//
//        $scope.removeDataFromFilter = function (keyvalue)
//        {
//            delete $scope.filterData[keyvalue];
//            $scope.filteredData($scope.filterData, 1, 30);
//        }
//        
        
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
                         toaster.pop('success', 'Payment Heading', 'Record created successfully');
                        $scope.PaymentHeadingRow.push({'payment_heading': response.records.payment_heading, 'id': response.lastinsertid, 'project_type_id': response.records.project_type_id, 'tax_heading': response.records.tax_heading, 'date_dependent_tax': response.records.date_dependent_tax, tax_applicable: response.records.tax_applicable});
                       
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
                        $('#paymentheadingModal').modal('toggle');
                         toaster.pop('success', 'Payment Heading', 'Record updated successfully');
                        $scope.PaymentHeadingRow.splice($scope.index, 1);
                        $scope.PaymentHeadingRow.splice($scope.index, 0, {
                            'payment_heading': response.records.payment_heading, 'id': $scope.id, 'tax_heading': response.records.tax_heading, 'date_dependent_tax': response.records.date_dependent_tax, tax_applicable: response.records.tax_applicable});
                        
                    }
                });
            }
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);
