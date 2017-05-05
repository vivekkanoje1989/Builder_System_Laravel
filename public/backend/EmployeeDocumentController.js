app.controller('employeeDocumentsCtrl', ['$scope', 'Data', '$rootScope', '$timeout', function ($scope, Data, $rootScope, $timeout) {

        $scope.manageEmployeeDocuments = function () {
            Data.get('employee-document/employeeDocuments').then(function (response) {
                $scope.DocumentsRow = response.records;
            });
        };
        $scope.initialModal = function (id, document_name, index)
        {
            $scope.index = index;
            $scope.id = id;
            $scope.document_name = document_name;
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



    }]);
