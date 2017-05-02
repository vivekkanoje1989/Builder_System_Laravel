app.controller('customerCtrl', ['$scope', 'Data', '$rootScope', '$timeout', 'toaster', 'Upload','$state', function ($scope, Data, $rootScope, $timeout, toaster, Upload,$state) {

        $scope.itemsPerPage = 4;
        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.manageCustomer = function () {
            Data.get('customer-data/customerData').then(function (response) {
                $scope.customerDataRow = response.result;
            });
        };
        $scope.getcustomerdata = function (custId)
        {
            Data.post('customer-data/getcustomerData', {'id': custId}).then(function (response) {
                $scope.customerRow = response.result;
                $scope.customerData = angular.copy($scope.customerRow);
                $scope.image = $scope.customerData.image_file;
                $scope.$broadcast("myEvent", {source_id: $scope.customerData.source_id});
                $scope.subsource_id = $scope.customerData.subsource_id;

            });
        };
        $scope.updateCustomer = function (customerData, emp_photo_url)
        {
            $scope.sbtBtn = true;
            if (typeof emp_photo_url === 'undefined' || typeof emp_photo_url === 'string') {
                emp_photo_url = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            }
            var url = getUrl + '/customer-data/update';
            var data = {'id':customerData.id,'title_id': customerData.title_id, 'first_name': customerData.first_name, 'middle_name': customerData.middle_name,
                'last_name': customerData.last_name, gender_id: customerData.gender_id,
                'monthly_income': customerData.monthly_income, 'profession_id': customerData.profession_id, 'pan_number': customerData.pan_number,
                'aadhar_number': customerData.aadhar_number, 'birth_date': customerData.birth_date,
                'marriage_date': customerData.marriage_date, source_id: customerData.source_id, subsource_id: customerData.subsource_id,
                source_description: customerData.source_description, sms_privacy_status: customerData.sms_privacy_status,
                email_privacy_status: customerData.email_privacy_status, emp_photo_url: emp_photo_url};

            emp_photo_url.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            emp_photo_url.upload.then(function (response) {
                console.log(response);
               $scope.errormsg = response.errormsg;
                $timeout(function () {
                      toaster.pop('success', 'Customer data', 'Record successfully updated');
                    
                    $state.go(getUrl + '.customerDataIndex');
                });
            }, function (response) {
                if (response.status !== 200) {
                    $scope.err_msg = "Please Select image for upload";
                }
            });
        }
    }]);        