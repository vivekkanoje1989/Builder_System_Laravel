app.controller('employeeDocumentsCtrl', ['$scope', 'Data', '$rootScope', '$timeout','toaster', function ($scope, Data, $rootScope, $timeout,toaster) {
        $scope.noOfRows = 1;
        $scope.itemsPerPage = 30;
        $scope.manageEmployeeDocuments = function () {
            Data.get('employee-document/employeeDocuments').then(function (response) {
                $scope.DocumentsRow = response.records;
                $scope.exportData = response.exportData;
            });
        };

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        $scope.searchDetails = {};
        $scope.searchData = {};

        $scope.filterDetails = function (search) {
            $scope.searchData = search;
//            $('#showFilterModal').modal('hide');
        }
        $scope.removeFilterData = function (keyvalue) {
            delete $scope.searchData[keyvalue];
            $scope.filterDetails($scope.searchData);
        }
        $scope.closeModal = function () {
            $scope.searchData = {};
        }

        $scope.initialModal = function (id, document_name, index)
        {
            $scope.index = index;
            $scope.id = id;
            $scope.document_name = document_name;
        }
        
        $scope.deleteEmployeeDocuments = function (id, index) {
            Data.post('employee-document/deleteEmployeeDocuments', {
                'id': id}).then(function (response) {
                toaster.pop('success', 'Employee Documents', 'Employee Document deleted successfully');
                $scope.DocumentsRow.splice(index, 1);
            });
        }
        
        $scope.doDocumentsAction = function ()
        {
            if ($scope.id == 0)
            {
                Data.post('employee-document', {'document_name': $scope.document_name}).then(function (response) {

                    if (response.success)
                    {
                        $scope.DocumentsRow.push({'document_name': response.result.document_name, 'id': response.lastinsertid});
                        $("#documentModal").modal("toggle");
                    } else {
                        $scope.errorMsg = response.errorMsg;
                    }
                });
            } else {
                Data.put('employee-document/' + $scope.id, {'document_name': $scope.document_name}).then(function (response) {
                    if (response.success)
                    {
                        $scope.DocumentsRow.splice($scope.index, 1);
                        $scope.DocumentsRow.splice($scope.index, 0, {'document_name': response.result.document_name, 'id': $scope.id})
                        $("#documentModal").modal("toggle");
                    } else {
                        $scope.errorMsg = response.errorMsg;
                    }
                });
            }
        }
        $scope.manageDocumentExportToExcel = function () {
            $scope.getexcel = window.location = "/employee-document/manageDocumentExportToExcel";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        }


    }]);
