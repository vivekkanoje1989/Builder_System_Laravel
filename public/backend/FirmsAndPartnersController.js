app.controller('companyCtrl', ['$scope', 'Data', 'Upload', 'toaster', '$state', '$parse', '$timeout', function ($scope, Data, Upload, toaster, $state, $parse, $timeout) {

        $scope.noOfRows = 1;
        $scope.itemsPerPage = 30;
        $scope.CompanyData = [];
        $scope.stationary = [];
        $scope.stationary = {};
        $scope.stationaryDetails = [];
        $scope.editPage = {};
        $scope.document = [];
        $scope.firmBtn = false;
        $scope.manageCompany = function () {
            Data.get('manage-companies/manageCompany').then(function (response) {
                $scope.CompanyRow = response.result;
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


//        $scope.onChange = function (files) {
//            console.log(files);
//            if(files[0] == undefined) return;
//          $scope.fileExt = files[0].name.split(".").pop()
//        }

//    $scope.photoChanged = function (files, index) {
//        console.log(files);
//        if (files != null) {
//            var index = this.$index;
//          var file = files[0];           
//          $scope.fileNames[index] = files[0].name;
//          $scope.$apply();
//            if ($scope.fileReaderSupported && file.type.indexOf('image') > -1) {
//                $timeout(function () {
//                    var fileReader = new FileReader();
//                    fileReader.readAsDataURL(file);
//                    fileReader.onload = function (e) {
//                        $timeout(function () {
//                            $scope.thumbnail[index] = {dataUrl: e.target.result};
//                            console.log($scope.thumbnail[index]);
//                        });
//                    }
//                });
//            }
//        }
//    };

        $scope.clearData = function () {
            $scope.stationary = {};
        }
        /*push client the stationary info*/
        $scope.updatePage = function (data, editId)
        {
            $('#stationaryModal').modal('toggle');
            if ($scope.isexitsStationary == 1)
            {
                $scope.stationaryDetails.splice($scope.index, 1);
                $scope.stationaryDetails.splice($scope.index, 0,
                        {
                            'id': editId,
                            'stationary_set_name': data.stationary_set_name,
                            'estimate_letterhead_file': data.estimate_letterhead_file,
                            'receipt_letterhead_file': data.receipt_letterhead_file,
                            'rubber_stamp_file': data.rubber_stamp_file,
                            'estimate_logo_file': data.estimate_logo_file,
                            'demandletter_letterhead_file': data.demandletter_letterhead_file,
                            'demandletter_logo_file': data.demandletter_logo_file,
                            'receipt_logo_file': data.receipt_logo_file,
                        });
                toaster.pop('success', 'Stationary Information', 'Stationary information updated successfully');
            } else
            {
                $scope.stationaryDetails.push({

                    'id': 0,
                    'stationary_set_name': data.stationary_set_name,
                    'estimate_letterhead_file': data.estimate_letterhead_file,
                    'receipt_letterhead_file': data.receipt_letterhead_file,
                    'rubber_stamp_file': data.rubber_stamp_file,
                    'estimate_logo_file': data.estimate_logo_file,
                    'demandletter_letterhead_file': data.demandletter_letterhead_file,
                    'demandletter_logo_file': data.demandletter_logo_file,
                    'receipt_logo_file': data.receipt_logo_file,

                });
                toaster.pop('success', 'Stationary Information', 'Stationary information created successfully');

            }
            console.log($scope.stationaryDetails);
        }

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
                $scope.CompanyData.office_address = response.result.office_address;
                $scope.CompanyData.cloud_telephoney_client = response.result.cloud_telephoney_client;
                $scope.firm_logo = 'https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/Company/firmlogo/' + response.result.firm_logo;
                $scope.documents = [];
                angular.forEach(response.documents, function (value, key) {
                    $scope.documents.push({'document_name': value.document_name,
                        'documentFile': value.document_file})
                });
//                $scope.stationary = [];
                if (response.stationary.length === 0)
                {
                    $scope.stationary = [{id: '1'}];
                }

                angular.forEach(response.stationary, function (value, key) {
                    $scope.stationaryDetails.push({'stationary_set_name': value.stationary_set_name, 'estimate_letterhead_file': value.estimate_letterhead_file, 'receipt_letterhead_file': value.receipt_letterhead_file, 'receipt_logo_file': value.receipt_logo_file, 'rubber_stamp_file': value.rubber_stamp_file, 'estimate_logo_file': value.estimate_logo_file, 'demandletter_letterhead_file': value.demandletter_letterhead_file, 'demandletter_logo_file': value.demandletter_logo_file})

                });
//                 console.log( $scope.stationaryDetails);

            });
        }

        $scope.editSubPage = function (list, index, isexitsStationary) {
            $scope.isexitsStationary = isexitsStationary;
            
            $scope.stationary = list;
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
//             $scope.stationary = {};
        }

        $scope.docompanyscreateAction = function (FirmLogo, CompanyData, documents, Stationary)
        {

            $scope.firmBtn = true;
            $scope.errorMsg = '';
            $scope.allimages = '';
            if ($scope.id == 0) {
                var url = '/manage-companies/';
                var data = {
                    'CompanyData': CompanyData,
                    'FirmLogo': {'FirmLogo': FirmLogo}, 'stationary': $scope.stationaryDetails, 'documents': $scope.documents}
            } else {
                if (typeof FirmLogo === 'undefined') {
                    FirmLogo = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
                }
                var url = '/manage-companies/updateCompany';
                var data = {'id': $scope.id,
                    'CompanyData': CompanyData,
                    'FirmLogo': {'FirmLogo': FirmLogo}, 'stationary': $scope.stationaryDetails, 'documents': $scope.documents}
            }

            FirmLogo.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            FirmLogo.upload.then(function (response) {
                $scope.firmBtn = false;
                if (response.data.status) {
                    $state.go('companiesIndex');
                    $timeout(function () {
                        if ($scope.id == 0) {
                            toaster.pop('success', 'Manage Companies', 'Record successfully created');
                        } else {
                            toaster.pop('success', 'Manage Companies', 'Record Updated created');
                        }
                    }, 1500);

                } else {
                    var obj = response.data.message;
                    var selector = [];
//                    var sessionAttribute = $window.sessionStorage.getItem("sessionAttribute");
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