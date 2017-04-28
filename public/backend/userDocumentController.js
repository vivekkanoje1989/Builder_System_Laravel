app.controller('userDocumentController', ['$scope', 'Data', 'Upload', '$timeout', 'toaster', function ($scope, Data, Upload, $timeout, toaster) {

        $scope.getEmployees = function () {
            Data.get('getUsers').then(function (response) {
                $scope.employeeRow = response.records;
            });
        };
        $scope.getUserDocumentsLists = function (employee_id)
        {
            $scope.errorMsgg = '';
            if (employee_id == undefined)
            {
                $scope.showDiv = false;
            } else {
                $scope.showDiv = true;
            }
            Data.post('user-document/userDocumentLists', {'employee_id': employee_id}).then(function (response) {
                $scope.documentRow = response.result;
            });
        };
        $scope.createUserDocuments = function (documentUrl, userData)
        {
            if (typeof documentUrl === 'undefined') {
                documentUrl = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            }
            $scope.empId = userData.employee_id;
            var url = getUrl + '/user-document/';
            var data = {
                'employee_id': userData.employee_id, 'document_id': userData.document_id, 'document_number': userData.document_number, 'documentUrl': {'documentUrl': documentUrl}}

            documentUrl.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            documentUrl.upload.then(function (response) {

                if (response.data.success)
                {
                    if ($scope.documentRow == undefined)
                    {
                        $scope.documentRow = [];
                    }
                    $scope.documentRow.push({'document_id': userData.document_id, 'document_number': response.data.result.document_number, 'document_url': response.data.result.document_url, 'document_name': response.data.doc})
                    
                    $scope.userData = {};
                    $scope.userForm.$setPristine();
                    $scope.submitted = false;
                    $scope.userData.employee_id = $scope.empId;
                } else {
                    $scope.errorMsgg = response.data.errorMsgg;
                }

            }, function (response) {
                if (response.success !== 200) {
                    $scope.err_msg = "Please Select image for upload";
                }
            });
        };
        $scope.manageEmployeeDocuments = function () {
            Data.get('user-document/documents').then(function (response) {
                $scope.DocumentsRow = response.records;
            });
        };

        $scope.changeErrorMsg = function ()
        {
            $scope.errorMsgg = '';
        }

    }]);       