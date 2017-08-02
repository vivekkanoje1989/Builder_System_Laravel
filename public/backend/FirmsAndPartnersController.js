app.controller('companyCtrl', ['$scope', 'Data', 'Upload', 'toaster', '$state', function ($scope, Data, Upload, toaster, $state) {

        $scope.noOfRows = 1;
        $scope.itemsPerPage = 30;
        $scope.firmBtn = false;
        $scope.manageCompany = function () {
            Data.get('manage-companies/manageCompany').then(function (response) {
                $scope.CompanyRow = response.result;
            });
        };
        $scope.loadCompanyData = function (companyId)
        {
            $scope.CompanyData = [];
            Data.post('manage-companies/loadCompanyData', {'id': companyId}).then(function (response) {
                $scope.companyData = response.result;
                $scope.id = response.result.id;
                $scope.CompanyData.legal_name = response.result.legal_name;
                $scope.CompanyData.punch_line = response.result.punch_line;
                $scope.CompanyData.vat_num = response.result.vat_number;
                $scope.CompanyData.pan_num = response.result.pan_number;
                $scope.CompanyData.service_tax_number = response.result.service_tax_number;
                $scope.CompanyData.firm_url = response.result.firm_url;
                $scope.CompanyData.gst_number = response.result.gst_number;
                $scope.CompanyData.firm_url = response.result.firm_url;
                $scope.CompanyData.domain_name = response.result.domain_name;
                $scope.CompanyData.main_office_addr = response.result.office_address;
                $scope.CompanyData.cloud_telephoney_client = response.result.cloud_telephoney_client;
                $scope.firm_logo = 'https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/Company/firmlogo/' + response.result.firm_logo;
                $scope.documents = [];
                angular.forEach(response.documents, function (value, key) {
                    $scope.documents.push({'document_name': value.document_name,
                        'documentFile': value.document_file})
                });
                $scope.Stationary = [];
                if (response.stationary.length === 0)
                {
                    $scope.Stationary = [{id: '1'}];
                }
                angular.forEach(response.stationary, function (value, key) {
                    $scope.Stationary.push({'stationary_set_name': value.stationary_set_name, 'estimateLetter': value.estimate_letterhead_file, 'receiptLetterhead': value.receipt_letterhead_file, 'receipt_logo_file': value.receipt_logo_file, 'rubberStamp': value.rubber_stamp_file, 'estimateLetterheadFile': value.estimate_letterhead_file, 'estimateLogo': value.estimate_logo_file, 'demandletterFile': value.demandletter_letterhead_file, 'receiptLogoFile': value.receipt_logo_file, 'demandletterLogoFile': value.demandletter_logo_file, })
                });
            });
        }
        $scope.docompanyscreateAction = function (FirmLogo, CompanyData)
        {
            $scope.showloader();
            $scope.firmBtn = true;
            $scope.errorMsg = '';
            $scope.allimages = '';
            if ($scope.id == 0) {
                var url = '/manage-companies/';
                var data = {
                    'bank_account': CompanyData.bank_account, 'legal_name': CompanyData.legal_name, 'punch_line': CompanyData.punch_line, 'pan_number': CompanyData.pan_num, 'main_office_addr': CompanyData.main_office_addr,
                    'cloud_telephoney_client': CompanyData.cloud_telephoney_client, 'gst_number': CompanyData.gst_number, 'domain_name': CompanyData.domain_name,
                    'service_tax_number': CompanyData.service_tax_number, 'sms_alice': CompanyData.sms_alice, 'vat_num': CompanyData.vat_num,
                    'FirmLogo': {'FirmLogo': FirmLogo}, 'stationary': $scope.Stationary, 'documents': $scope.documents}
            } else {
                if (typeof FirmLogo === 'undefined') {
                    FirmLogo = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
                }
                var url = '/manage-companies/updateCompany';
                var data = {'id': $scope.id,
                    'bank_account': CompanyData.bank_account, 'legal_name': CompanyData.legal_name, 'punch_line': CompanyData.punch_line, 'pan_number': CompanyData.pan_num, 'main_office_addr': CompanyData.main_office_addr,
                    'cloud_telephoney_client': CompanyData.cloud_telephoney_client, 'gst_number': CompanyData.gst_number, 'domain_name': CompanyData.domain_name,
                    'service_tax_number': CompanyData.service_tax_number, 'sms_alice': CompanyData.sms_alice, 'vat_num': CompanyData.vat_num,
                    'FirmLogo': {'FirmLogo': FirmLogo}, 'stationary': $scope.Stationary, 'documents': $scope.documents}
            }

            FirmLogo.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            FirmLogo.upload.then(function (response) {
                $scope.hideloader();
                $scope.firmBtn = false;
                if (response.status) {
                    $state.go('companiesIndex');
                    $timeout(function () {
                        if ($scope.id == 0) {
                            toaster.pop('success', 'Manage Companies', 'Record successfully created');
                        } else {
                            toaster.pop('success', 'Manage Companies', 'Record Updated created');
                        }
                    }, 1500);

                } else {
                    $scope.errorMsg = response.data.errormsg;
                }
            }, function (response) {
                 $scope.hideloader();
                if (response.status !== 200) {
                    $scope.err_msg = "Please Select image for upload";
                }
            });
        }
        $scope.Stationary = [{id: '1'}];
        $scope.documents = [{id: '1'}];
        $scope.addNewStationary = function () {
            var newItemNo = $scope.Stationary.length + 1;
            $scope.Stationary.push({'id': newItemNo});
        };
        $scope.addNewDocuments = function ()
        {
            var newItemNo = $scope.documents.length + 1;
            $scope.documents.push({'id': newItemNo});
        }
        $scope.removeChoice = function () {
            var lastItem = $scope.documents.length - 1;
            $scope.documents.splice(lastItem);
        };

    }]);

app.controller('bankAccountCtrl', ['$scope', 'Data', function ($scope, Data) {
        $scope.bankAccountRow = [];
        $scope.manageBankAccounts = function () {
            Data.get('manage-companies/manageBankAccount').then(function (response) {
                $scope.bankAccountRow = response.records;
            });
        };
    }]);