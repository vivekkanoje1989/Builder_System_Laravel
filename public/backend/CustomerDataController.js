app.controller('customerCtrl', ['$scope', 'Data', '$timeout', 'toaster', 'Upload', '$state','$parse', function ($scope, Data, $timeout, toaster, Upload, $state, $parse) {

        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.manageCustomer = function () {
            Data.get('customers/manageCustomer').then(function (response) {
                $scope.customerDataRow = response.result;
            });
        };
        
        $scope.searchDetails = {};
        $scope.searchData = {};

        $scope.filterDetails = function (search) {
//            $scope.searchDetails = {};
            $scope.searchData = search;
        }
        $scope.removeFilterData = function (keyvalue) {
            delete $scope.searchData[keyvalue];
            $scope.filterDetails($scope.searchData);
        }
        $scope.closeModal = function () {
            $scope.searchData = {};
        }
        
           $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        $scope.getcustomerdata = function (custId)
        {
            Data.post('customers/getcustomerData', {'id': custId}).then(function (response) {
                $scope.customerRow = response.result;
                $scope.customerData = angular.copy($scope.customerRow);
                $scope.image = $scope.customerData.image_file;
                $scope.$broadcast("myEvent", {source_id: $scope.customerData.source_id});
                $scope.subsource_id = $scope.customerData.subsource_id;

            });
        };
        $scope.updateCustomer = function (customerData, cust_image_file)
        {
            $scope.sbtBtn = true;
            if (typeof cust_image_file === 'undefined' || typeof cust_image_file === 'string') {
                cust_image_file = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            }
            var url = '/customers/update';
            var data = {'id': customerData.id, 'title_id': customerData.title_id, 'first_name': customerData.first_name, 'middle_name': customerData.middle_name,
                'last_name': customerData.last_name, gender_id: customerData.gender_id,
                'monthly_income': customerData.monthly_income, 'profession_id': customerData.profession_id, 'pan_number': customerData.pan_number,
                'aadhar_number': customerData.aadhar_number, 'birth_date': customerData.birth_date,
                'marriage_date': customerData.marriage_date, source_id: customerData.source_id, subsource_id: customerData.subsource_id,
                source_description: customerData.source_description, sms_privacy_status: customerData.sms_privacy_status,
                email_privacy_status: customerData.email_privacy_status, cust_image_file: cust_image_file};

            cust_image_file.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            cust_image_file.upload.then(function (response) {
                if (response.data.status) {
                    $scope.errormsg = response.errormsg;
                    $timeout(function () {
                        toaster.pop('success', 'Customer data', 'Record successfully updated');
                        $state.go('customersIndex');
                    });
                }
                var obj = response.data.message;
                var selector = [];
                for (var key in obj) {
                    var model = $parse(key);// Get the model
                    model.assign($scope, obj[key][0]);// Assigns a value to it
                    selector.push(key);
                }
            }, function (response) {
                if (response.status !== 200) {
                    $scope.err_msg = "Please Select image for upload";
                }
            });
        }
    }]);        