'use strict';
app.controller('bankAccountsCtrl', ['$scope', 'Data', '$rootScope', '$timeout', 'toaster', '$filter', '$modal', function ($scope, Data, $rootScope, $timeout, toaster, $filter, $modal) {

        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.manageBankAccounts = function () {
            Data.get('bank-account/manageBankAccount').then(function (response) {
                if (response.status) {
                    $scope.bankAccountRow = response.records;
                    $scope.exportData = response.exportData;
                    $scope.deleteBtn = response.delete;
                } else {
                    $scope.hideloader();
                    $scope.totalCount = 0;
                    $scope.disableBtn = true;
                }
            });
        };
        $scope.orderByField = function (keyname) {
            $scope.sortKey = keyname;
            $scope.reverseSort = !$scope.reverseSort;
        }

        $scope.bankAccountExportToxls = function () {
            $scope.getexcel = window.location = "/bank-account/bankAccountExportToxls";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        }

        $scope.showHelpBankAccounts = function () {
            $scope.optionModal = $modal.open({
                template: '<div class="modal-header" ng-mouseleave="close()"><h3 class="modal-title" style="text-align:center;">Welcome to the BMS Help Center<i class="fa fa-close" style="float:right; color: #ccc;" ng-click="closeModal()"></i></h3></div><div class="modal-body">Bank Accounts</div><div class="modal-footer"> <button ng-click="closeModal()" class="btn btn-primary" style="float:right;">Close</button></div>',
                controller: [
                    '$scope', '$modalInstance', function ($scope, $modalInstance) {
                        $scope.closeModal = function () {
                            $modalInstance.dismiss();
                        };
                    }
                ]
            });
        }

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

        $scope.deleteBankAccount = function (id, index) {
            Data.post('bank-accounts/deleteBankAccount', {
                'id': id}).then(function (response) {
//                toaster.pop('success', 'Bank Accounts', 'Bank Account deleted successfully');
                $scope.bankAccountRow.splice(index, 1);
            });
        }

        $scope.$on("deleteRecords", function (event, args) {
            $scope.deleteBankAccount(args['id'], args['index']);
        });

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
            $scope.heading = "Add Bank Account";
            $scope.btn = "Add";
            $scope.bankAccount = angular.copy(item);
            $scope.company = item.company_id;
            $scope.account_type = item.account_type;
            $scope.index = (itemsPerPage * ($scope.noOfRows - 1) + (index + 1)) - 1;
            $scope.sbtBtn = false;
            if ($scope.id !== '0')
            {
                $scope.heading = "Edit Bank Account";
                $scope.btn = "Update";
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