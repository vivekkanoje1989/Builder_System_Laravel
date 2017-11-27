app.controller('userDocumentController', ['$scope', 'Data', 'Upload', 'toaster', '$window', '$parse', '$modal','$timeout', function ($scope, Data, Upload, toaster, $window, $parse, $modal,$timeout) {

        $scope.action = 'Submit';
        $scope.id = 0;
        $scope.getEmployees = function () {
            Data.get('getUsers').then(function (response) {
                $scope.employeeRow = response.records;
            });
        };
        $scope.getUserDocumentsLists = function (employee_id)
        {
            $scope.errorMsgg = '';
            if (typeof employee_id == 'undefined') {
                $scope.showDiv = false;
            } else {
                $scope.showDiv = true;

                Data.post('user-document/userDocumentLists', {'employee_id': employee_id}).then(function (response) {
                    $scope.documentRow = response.result;
                });
            }
        };

        $scope.showHelpUserDocument = function () {
            $scope.optionModal = $modal.open({
                template: '<div class="modal-header" ng-mouseleave="close()"><h3 class="modal-title" style="text-align:center;">Welcome to the BMS Help Center<i class="fa fa-close" style="float:right; color: #ccc;" ng-click="closeModal()"></i></h3></div><div class="modal-body">User Documents</div><div class="modal-footer"> <button ng-click="closeModal()" class="btn btn-primary" style="float:right;">Close</button></div>',
                controller: [
                    '$scope', '$modalInstance', function ($scope, $modalInstance) {
                        $scope.closeModal = function () {
                            $modalInstance.dismiss();
                        };
                    }
                ]
            });
        }

        $scope.updateDocument = function (list, index)
        {
            $scope.errorMsgg = '';
            $scope.action = 'Update';
            $scope.id = list.id;
            $scope.userData.document_number = list.document_number;
            $scope.document_url = list.document_url;
            $scope.userData.document_id = list.user_documents.id;
            $scope.index = index;
        }
        
        $scope.createUserDocuments = function (documentUrl, userData)
        {
            $scope.userdisables = false;

            if (typeof documentUrl === 'undefined') {
                documentUrl = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            }
            $scope.empId = userData.employee_id;
            if ($scope.id == 0) {
                var url = '/user-document/';
                var data = {
                    'employee_id': userData.employee_id, 'document_id': userData.document_id, 'document_number': userData.document_number, 'documentUrl': {'documentUrl': documentUrl}}
            } else {
                var url = '/user-document/edit';
                var data = {
                    'id': $scope.id, 'employee_id': userData.employee_id, 'document_id': userData.document_id, 'document_number': userData.document_number, 'documentUrl': {'documentUrl': documentUrl}}
            }
            documentUrl.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            documentUrl.upload.then(function (response) {
                if (response.data.success)
                {
                    $timeout(function () {
                        $scope.userdisables = false;
                    }, 2000);
                    if ($scope.documentRow == undefined)
                    {
                        $scope.documentRow = [];
                    }
                    var user_documents = {'id': userData.document_id, 'document_name': response.data.doc}
                    if ($scope.id == 0) {
                        $scope.documentRow.push({'document_id': userData.document_id, 'document_number': userData.document_number, 'document_url': response.data.document_url, 'id': response.data.lastinsertid, 'user_documents': user_documents})
                        $scope.action = 'Submit';
                    } else {
                        $scope.documentRow.splice($scope.index, 1);
                        $scope.documentRow.splice($scope.index, 0, {'id': $scope.id, 'document_id': userData.document_id, 'document_number': userData.document_number, 'document_url': response.data.document_url, 'user_documents': user_documents})
                        $scope.action = 'Submit';
                    }
                    $scope.userData = {'document_id': '', 'document_number': ''};
                    $scope.id = '0';
                    $scope.document_url = '';
                    $scope.userForm.$setPristine();
                    $scope.userForm.$setUntouched(true);
                    $scope.sbtBtn = false;
                    $scope.userForm.$submitted = false;
                    $scope.userData.employee_id = $scope.empId;
                    $scope.errorMsgg = '';


                } else {

                    $timeout(function () {
                        $scope.userdisables = false;
                    }, 2000);

                    var obj = response.data.message;
                    var selector = [];
                    for (var key in obj) {
                        var model = $parse(key);// Get the model
                        model.assign($scope, obj[key][0]);// Assigns a value to it
                        selector.push(key);
                    }
                    $scope.errorMsgg = response.data.errorMsgg;
                }
            }, function (response) {
                if (response.success !== 200) {
                    $scope.err_msg = "Please Select image for upload";
                }
            });
        };
        $scope.removeImg = function (imgname, id)
        {
            if (window.confirm("Are you sure want to remove this image?")) {

                Data.post('user-document/removeImage', {id: id, document: $scope.document_url}).then(function (response) {
                    if (!response.success)
                    {
                        toaster.pop('success', 'Document Image', 'Image remove successfully.');
                    } else
                    {
                        toaster.pop('success', 'Document Image', 'Image remove successfully.');
                    }
                });
            }
        }
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