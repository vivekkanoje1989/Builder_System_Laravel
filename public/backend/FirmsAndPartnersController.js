app.controller('companyCtrl', ['$scope', 'Data', 'Upload', 'toaster', '$state', '$parse', '$timeout', '$window', 'SweetAlert','$modal', function ($scope, Data, Upload, toaster, $state, $parse, $timeout, $window, SweetAlert,$modal) {

        $scope.noOfRows = 1;
        $scope.itemsPerPage = 30;
        $scope.CompanyData = [];
        $scope.stationary = [];
        $scope.stationaryDetails = [];
        $scope.stationaryDetails1 = [];
        $scope.estimate_letterhead_file_preview = [];
        $scope.editPage = {};
        $scope.documents = [];
        $scope.documentData = [];
        $scope.exportData = '';
        $scope.firmBtn = false;
        $scope.stationaryBtn = false;
        $scope.companyDocTab = true;

        $scope.manageCompany = function () {
            Data.get('manage-companies/manageCompany').then(function (response) {
                if(response.status){
                $scope.CompanyRow = response.result;
                $scope.exportData = response.exportData;
                $scope.deleteBtn = response.delete;
                 } else {
                    $scope.hideloader();
                    $scope.totalCount = 0;
                    $scope.disableBtn = true;
                }
            });
        };
        
            $scope.showHelpFirmandPartners= function () {
            $scope.optionModal = $modal.open({
                template: '<div class="modal-header" ng-mouseleave="close()"><h3 class="modal-title" style="text-align:center;">Welcome to the BMS Help Center<i class="fa fa-close" style="float:right; color: #ccc;" ng-click="closeModal()"></i></h3></div><div class="modal-body">Firm and Partners</div><div class="modal-footer"> <button ng-click="closeModal()" class="btn btn-primary" style="float:right;">Close</button></div>',
                controller: [
                    '$scope', '$modalInstance', function ($scope, $modalInstance) {
                        $scope.closeModal = function () {
                            $modalInstance.dismiss();
                        };
                    }
                ]
            });
        }
        

        $scope.orderByField = function (keyname) {
            $scope.sortKey = keyname;
            $scope.reverseSort = !$scope.reverseSort;
        }

        $scope.searchDetails = {};
        $scope.searchData = {};

        $scope.manageCountry = function () {
            Data.post('manage-companies/manageCountry').then(function (response) {
                $scope.countryRow = response.records;
            });
        };
        $scope.manageStates = function (country_id) {

            Data.post('manage-companies/manageStates', {country_id: country_id}).then(function (response) {
                $scope.statesRow = response.records;
            });
        };

        $scope.manageCompanies = function () {
            Data.get('manage-companies/manageCompanies').then(function (response) {
                $scope.companyType = response.result;
                console.log($scope.companyType)
            });
        };

        $scope.manageStateCode = function (state_id) {
            alert(state_id)
            for (var i = 0; i < $scope.statesRow.length; i++) {
                
                if ($scope.statesRow[i]['id'] == state_id) {
                   
                    $scope.CompanyData.state_code = $scope.statesRow[i]['state_code'];
                } 
            }

        }
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

        $scope.deleteCompany = function (id, index) {
            Data.post('manage-companies/deleteCompany', {
                'id': id}).then(function (response) {
//                toaster.pop('success', 'Firms and partners', 'Company deleted successfully');
//                $scope.CompanyRow.splice(index, 1);
                $("tr#" + id + "").remove();
            });
        }

        $scope.$on("deleteRecords", function (event, args) {
            $scope.deleteCompany(args['id'], args['index']);
        });


        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

        $scope.companiesExportToxls = function () {
            $scope.getexcel = window.location = "/manage-companies/companiesExportToxls";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        }

        $scope.clearData = function () {
            $scope.stationary = {};
            $scope.documentData = {};
//            $scope.stationaryDetails1 = [];
        }

        /*push client the stationary info*/
        $scope.stationaries = function (stationaryData, estimateLogoFile, companyid)
        {
            $scope.stationaryBtn = true;
            if ($scope.stationaryid == 0) {
                if (typeof estimateLogoFile == 'undefined' || typeof estimateLogoFile == 'number' || typeof estimateLogoFile == 'string') {
                    estimateLogoFile = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
                }
                var url = '/manage-companies/stationary';
                var data = {
                    'stationary': stationaryData, 'companyid': companyid,
                    'estimateLogoFile': {'estimateLogoFile': estimateLogoFile}}
            } else {

                if (typeof estimateLogoFile == 'undefined' || typeof estimateLogoFile == 'number' || typeof estimateLogoFile == 'string') {
                    estimateLogoFile = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
                }
                var url = '/manage-companies/updateStationary';
                var data = {'id': $scope.id,
                    'stationary': stationaryData,
                    'FirmLogo': {'estimateLogoFile': estimateLogoFile}}
            }

            estimateLogoFile.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            estimateLogoFile.upload.then(function (response) {
                $scope.stationaryBtn = false;
                if (response.data.status) {
                    if ($scope.stationaryid == 0) {
                        
                        toaster.pop('success', 'Manage Stationary', 'Record successfully created');
                        $scope.stationaryDetails.push({'stationary_set_name': response.data.records.stationary_set_name, 'stationaryId': response.data.lastInsertedId, 'estimate_letterhead_file': response.data.records.estimate_letterhead_file, 'receipt_letterhead_file': response.data.records.receipt_letterhead_file, 'rubber_stamp_file': response.data.records.rubber_stamp_file, 'estimate_logo_file': response.data.records.estimate_logo_file, 'demandletter_letterhead_file': response.data.records.demandletter_letterhead_file, 'demandletter_logo_file': response.data.records.demandletter_logo_file, 'receipt_logo_file': response.data.records.receipt_logo_file});

                    } else {
                        toaster.pop('success', 'Manage Stationary', 'Record successfully Updated');
                        $scope.stationaryDetails.splice($scope.index, 1);
                        $scope.stationaryDetails.splice($scope.index,0, {'stationary_set_name': response.data.records.stationary_set_name, 'stationaryId': $scope.id, 'estimate_letterhead_file': response.data.records.estimate_letterhead_file, 'receipt_letterhead_file': response.data.records.receipt_letterhead_file, 'rubber_stamp_file': response.data.records.rubber_stamp_file, 'estimate_logo_file': response.data.records.estimate_logo_file, 'demandletter_letterhead_file': response.data.records.demandletter_letterhead_file, 'demandletter_logo_file': response.data.records.demandletter_logo_file, 'receipt_logo_file': response.data.records.receipt_logo_file});

//                        $state.reload();
                        $timeout(function () {
                            $('.modal-backdrop').hide();
                            $('#stationaryTab a').trigger("click");
                        }, 300);
                    }
                    $('#stationaryModal').modal('hide');
                } else {

                    $scope.stationaryBtn = false;
                    $scope.errorMsg = response.data.errormsg;
                }
            }, function (response) {
                $scope.hideloader();
                if (response.status !== 200) {
                    $scope.err_msg = "Please Select image for upload";
                }
            });

        }

        $scope.documentDetails = function (documentData, documentFile, companyid)
        {
            if ($scope.docid == 0) {
                var url = '/manage-companies/addDocument';
                var data = {
                    'documents': documentData, 'companyid': companyid,
                    'documentFile': {'documentFile': documentFile}}
            } else {
                if (typeof documentFile === 'undefined') {
                    documentFile = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
                }
                var url = '/manage-companies/updateDocuments';
                var data = {'id': $scope.id,
                    'documents': documentData,
                    'documentFile': {'documentFile': documentFile}}
            }

            documentFile.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            documentFile.upload.then(function (response) {
                console.log($scope.documents);
                $scope.firmBtn = false;
                if (response.data.status) {
                    if ($scope.docid == 0) {
                        toaster.pop('success', 'Manage Documents', 'Record successfully created');

                        $scope.documents.push({'document_name': response.data.records.document_name, 'documentId': response.data.lastinsertid, 'documentFile': response.data.records.document_file});

                    } else {
                        console.log(response);
                        toaster.pop('success', 'Manage Documents', 'Record successfully Updated');
                        $scope.documents.splice($scope.index, 1);
                        $scope.documents.splice($scope.index, 0, {'documentId': $scope.docid, 'document_name': response.data.records.document_name, 'id': $scope.docid, 'documentFile': response.data.records.document_file});
//                        $state.reload();
                        $timeout(function () {
                            $('.modal-backdrop').hide();
                            $('#documentTab a').trigger("click");
                        }, 300);
                    }
                    $('#documentModal').modal('hide');

                } else {

                    $scope.firmBtn = false;
                    $scope.errorMsg = response.data.errormsg;
                }
            }, function (response) {
                $scope.hideloader();
                if (response.status !== 200) {
                    $scope.err_msg = "Please Select image for upload";
                }
            });

        }

        $scope.loadCompanyData = function (companyId)
        {

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
                $scope.CompanyData.office_address = response.result.office_address;
                $scope.CompanyData.tan_number = response.result.tan_number;
                $scope.CompanyData.marketing_name = response.result.marketing_name;
                $scope.CompanyData.company_register_no = response.result.company_register_no;
                $scope.CompanyData.pin_code = response.result.pin_code;
                $scope.company_type = response.result.type_of_company;
                $scope.country = parseInt(response.result.country_id);
                $scope.manageStates($scope.country);
                $timeout(function () {
                    $scope.state = response.result.state_id;
                    $("#state_id").val(response.result.state_id);
                    $scope.CompanyData.state_code = response.result.state_code;
                }, 1500);
                $scope.fevicon = response.result.fevicon;
                $scope.CompanyData.pin_code = response.result.pin_code;
                $scope.CompanyData.contact_person = response.result.contact_person;
                $scope.firm_logo = response.result.firm_logo;
                $scope.documents = [];
                angular.forEach(response.documents, function (value, key) {
                    $scope.documents.push({'document_name': value.document_name,
                        'documentFile': value.document_file, 'documentId': value.id})
                });
                if (response.stationary.length === 0)
                {
                    $scope.stationary = [{id: '1'}];
                }

                angular.forEach(response.stationary, function (value, key) {
                    $scope.stationaryDetails.push({'stationaryId': value.id, 'stationary_set_name': value.stationary_set_name, 'estimate_letterhead_file': value.estimate_letterhead_file, 'receipt_letterhead_file': value.receipt_letterhead_file, 'receipt_logo_file': value.receipt_logo_file, 'rubber_stamp_file': value.rubber_stamp_file, 'estimate_logo_file': value.estimate_logo_file, 'demandletter_letterhead_file': value.demandletter_letterhead_file, 'demandletter_logo_file': value.demandletter_logo_file})

                });

            });
        }

        $scope.editdocument = function (docid, list, index, isexitsDocument) {
            $scope.documentData = [];
            $scope.documentData = list;
            $scope.index = index;
            $scope.documentId = list.documentId;
            $scope.docid = docid;
            $scope.document_file_preview = [];
            if (list.documentFile != '') {
                $scope.documentFile = list.documentFile;
            }
            if (isexitsDocument == 1) {
                $scope.modalHeading = 'Add Document'
                $scope.modalBtn = 'Add'
            } else {
                $scope.modalHeading = 'Edit Document'
                $scope.modalBtn = 'Update'
            }
        }


        $scope.editStationary = function (stationaryid, list, index, isexitsStationary) {
            $scope.isexitsStationary = isexitsStationary;
            $scope.stationary = list;
            $scope.stationaryId = list.stationaryId;
            $scope.stationaryid = stationaryid;

            $scope.estimate_letterhead_file_preview = [];
            $scope.receipt_letterhead_file_preview = [];
            $scope.rubber_stamp_file_preview = [];
            $scope.index = index;
            if (isexitsStationary == 1) {
                $scope.modalHeading = 'Add Stationary'
                $scope.modalBtn = 'Add'
            } else {
                $scope.modalHeading = 'Edit Stationary'
                $scope.modalBtn = 'Update'
            }
            if (list.estimate_letterhead_file != '') {
                $scope.estimate_letterhead_file = list.estimate_letterhead_file;
            }
            if (list.receipt_letterhead_file != '') {
                $scope.receipt_letterhead_file = list.receipt_letterhead_file;
            }
            if (list.receipt_logo_file != '') {
                $scope.receipt_logo_file = list.receipt_logo_file;
            }
            if (list.rubber_stamp_file != '') {
                $scope.rubber_stamp_file = list.rubber_stamp_file;
            }
            if (list.demandletter_letterhead_file != '') {
                $scope.demandletter_letterhead_file = list.demandletter_letterhead_file;
            }
            if (list.estimate_logo_file != '') {
                $scope.estimate_logo_file = list.estimate_logo_file;
            }
            if (list.demandletter_logo_file != '') {
                $scope.demandletter_logo_file = list.demandletter_logo_file;
            }
            $scope.subId = list.id;
            $scope.index = index;
        }


        $scope.docompanyscreateAction = function (FirmLogo, Fevicon, CompanyData)
        {
            $scope.firmBtn = true;
            $scope.errorMsg = '';
            $scope.allimages = '';
            if ($scope.id == 0) {
                if (typeof FirmLogo === 'undefined') {
                    FirmLogo = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
                }
                if (typeof Fevicon === 'undefined') {
                    Fevicon = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
                }
                var url = '/manage-companies/';
                var data = {
                    'CompanyData': CompanyData,
                    'Fevicon': {'Fevicon': Fevicon},
                    'FirmLogo': {'FirmLogo': FirmLogo}}
            } else {
                if (typeof FirmLogo === 'undefined') {
                    FirmLogo = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
                }
                if (typeof Fevicon === 'undefined') {
                    Fevicon = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
                }
                var url = '/manage-companies/updateCompany';
                var data = {
                    
                    'id': $scope.id,
                    'CompanyData': CompanyData,
                    'Fevicon': {'Fevicon': Fevicon},
                    'FirmLogo': {'FirmLogo': FirmLogo}}
            }

            FirmLogo.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            FirmLogo.upload.then(function (response) {
                $scope.companyId = response.data.id;
                if (response.data.status) {
//                    $scope.companyDocTab = false;
                    $timeout(function () {
                        if ($scope.id == 0) {
                            toaster.pop('success', 'Manage Companies', 'Record successfully created');
                        } else {
                            toaster.pop('success', 'Manage Companies', 'Record Updated created');
                        }
                    }, 1500);
                    $timeout(function () {
                        $('#documentTab a').trigger("click");
                    }, 1000);

                } else {
                    var obj = response.data.message;
                    var selector = [];
                    for (var key in obj) {
                        var model = $parse(key);// Get the model
                        model.assign($scope, obj[key][0]);// Assigns a value to it
                        selector.push(key);
                    }
                    $scope.firmBtn = false;
                    $scope.errorMsg = response.data.errormsg;
                }
            }, function (response) {
                $scope.hideloader();
                if (response.status !== 200) {
                    $scope.err_msg = "Please Select image for upload";
                }
            });
        }

        $scope.Stationary = [];
        $scope.documents = [];
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