'use strict';
app.controller('bankAccountsCtrl', ['$scope', 'Data', '$rootScope', '$timeout', 'toaster', '$filter', function ($scope, Data, $rootScope, $timeout, toaster, $filter) {

        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.manageBankAccounts = function () {
            Data.get('bank-account/manageBankAccount').then(function (response) {
                $scope.bankAccountRow = response.records;
            });
        };

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


        $scope.doBankAccountAction = function (bankAccount)
        {
            if (bankAccount.payment_heading === undefined) {
                $scope.emptyDepartmentId = true;
                $scope.applyClassDepartment = 'ng-active';
                return false;
            } else if (bankAccount.payment_heading.length == 0) {
                $scope.emptyDepartmentId = true;
                $scope.applyClassDepartment = 'ng-active';
                return false;
            } else {
                $scope.emptyDepartmentId = false;
                $scope.applyClassDepartment = 'ng-inactive';
            }
            angular.forEach(bankAccount.payment_heading, function (value, key) {
                if (key == '0') {
                    $scope.paymentHeading = value.id;
                } else {
                    $scope.paymentHeading = $scope.paymentHeading + ',' + value.id;
                }
            });

            if ($scope.id == 0) //for create
            {
                Data.post('bank-accounts/', {company_id: bankAccount.company_id,
                    account_number: bankAccount.account_number, account_type: bankAccount.account_type,
                    address: bankAccount.address, branch: bankAccount.branch, account_type: bankAccount.account_type,
                    email: bankAccount.email, ifsc: bankAccount.ifsc, micr: bankAccount.micr,
                    name: bankAccount.name, phone: bankAccount.phone, preffered_payment_headings_ids: $scope.paymentHeading}).then(function (response) {

                    if (!response.success)
                    {
                        toaster.pop('error', 'Manage bank account', 'Something Went Wrong!!');
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.bankAccountRow.push({legal_name: response.company, id: response.lastId, company_id: bankAccount.company_id, 'account_number': bankAccount.account_number, 'account_type': bankAccount.account_type,
                            'address': bankAccount.address, 'branch': bankAccount.branch, 'account_type': bankAccount.account_type,
                            'email': bankAccount.email, 'ifsc': bankAccount.ifsc, 'micr': bankAccount.micr,
                            'name': bankAccount.name, 'phone': bankAccount.phone, preffered_payment_headings_ids: $scope.paymentHeading});
                        toaster.pop('success', 'Manage bank account', 'Record created successfully');
                        $("#bankAccountModal").modal("toggle");
                    }
                });
            } else { //for update
                Data.put('bank-accounts/' + $scope.id, {company_id: bankAccount.company_id,
                    account_number: bankAccount.account_number, account_type: bankAccount.account_type,
                    address: bankAccount.address, branch: bankAccount.branch, account_type: bankAccount.account_type,
                    email: bankAccount.email, ifsc: bankAccount.ifsc, micr: bankAccount.micr,
                    name: bankAccount.name, phone: bankAccount.phone, preffered_payment_headings_ids: $scope.paymentHeading}).then(function (response) {

                    toaster.pop('success', 'Manage bank account', 'Record updated successfully');
                    $scope.bankAccountRow.splice($scope.index, 1);
                    $scope.bankAccountRow.splice($scope.index, 0, {'id': $scope.id, company_id: bankAccount.company_id, 'account_number': bankAccount.account_number, 'account_type': bankAccount.account_type,
                        'address': bankAccount.address, 'branch': bankAccount.branch, 'account_type': bankAccount.account_type,
                        'email': bankAccount.email, 'ifsc': bankAccount.ifsc, 'micr': bankAccount.micr,
                        'name': bankAccount.name, 'phone': bankAccount.phone, 'preffered_payment_headings_ids': $scope.paymentHeading, legal_name: response.company});
                    $("#bankAccountModal").modal("toggle");

                    $scope.paymentHeadingEdit($scope.paymentHeading);
                });
            }
        }
        $scope.initialModel = function (id, item, itemsPerPage, index)
        {
            $scope.id = id;
            $scope.bankAccount = {};
            $scope.heading = "Bank Accounts";
            $scope.bankAccount = angular.copy(item);
            $scope.company = item.company_id;
            $scope.account_type = item.account_type;
            $scope.index = (itemsPerPage * ($scope.noOfRows - 1) + (index + 1)) - 1;
            $scope.sbtBtn = false;
            if ($scope.id !== '0')
            {
                $scope.paymentHeadingEdit(item.preffered_payment_headings_ids);
                $scope.paymentHeadingFiltered(item.preffered_payment_headings_ids);
            }
        }
        $scope.paymentHeadingFiltered = function (ids)
        {
            $scope.paymentHeadings = [];
            Data.post('bank-accounts/paymentHeadingFiltered', {payment_headings: ids}).then(function (response) {
                $scope.paymentHeadings = response.records;
            });
        }
        $scope.paymentHeadingEdit = function (ids)
        {
            Data.post('bank-accounts/paymentHeadingEdit', {payment_headings: ids}).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.bankAccount.payment_heading = response.records;
                }
            });
        }
        $scope.manageCompanys = function ()
        {
            Data.get('bank-accounts/getCompany').then(function (response) {
                $scope.companyRow = response.records;
            });
        };
        $scope.managePaymentHeading = function () {
            $scope.paymentHeadings = [];
            Data.get('bank-account/managePaymentHeading').then(function (response) {
                $scope.paymentHeadings = response.records;
            });
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);