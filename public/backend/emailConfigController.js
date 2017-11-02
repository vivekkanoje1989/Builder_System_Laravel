app.controller('emailconfigCtrl', ['$scope', 'Data', '$rootScope', '$timeout', 'toaster', '$state' ,'$modal', function ($scope, Data, $rootScope, $timeout, toaster, $state, $modal)
{
    $scope.itemsPerPage = 30
    $scope.noOfRows = 1;
    $scope.listDepartmentOnCreate = [];
    $scope.pageHeading = "Create Email Account";
    $scope.emailData = {};
    
    $scope.checkDepartment = function () {
       if ($scope.emailData.department_id.length === 0) {
            $scope.emptyDepartmentId = true;
            $scope.applyClassDepartment = 'ng-active';
        } else {
            $scope.emptyDepartmentId = false;
            $scope.applyClassDepartment = 'ng-inactive';
        }
    }; 
    
     $scope.deleteEmailConfig = function (id, index) {
            Data.post('email-config/deleteEmailConfig', {
                'id': id}).then(function (response) {
//                toaster.pop('success', 'Email Configure', 'Email Account deleted successfully');
                $scope.listmails.splice(index, 1);
            });
        }
        
        $scope.$on("deleteRecords", function (event, args) {
            $scope.deleteEmailConfig(args['id'], args['index']);
        });
        $scope.orderByField = function (keyname) {
            $scope.sortKey = keyname;
            $scope.reverseSort = !$scope.reverseSort;
        }
        
     $scope.showHelpEmailConfig= function () {
            $scope.optionModal = $modal.open({
                template: '<div class="modal-header" ng-mouseleave="close()"><h3 class="modal-title" style="text-align:center;">Welcome to the BMS Help Center<i class="fa fa-close" style="float:right; color: #ccc;" ng-click="closeModal()"></i></h3></div><div class="modal-body">Email Configration</div><div class="modal-footer"> <button ng-click="closeModal()" class="btn btn-primary" style="float:right;">Close</button></div>',
                controller: [
                    '$scope', '$modalInstance', function ($scope, $modalInstance) {
                        $scope.closeModal = function () {
                            $modalInstance.dismiss();
                        };
                    }
                ]
            });
        }
        
        
    $scope.configEmailExportToxls = function (){
          $scope.getexcel = window.location = "email-config/configEmailExportToxls";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
    }
    
    $scope.manageEmailConfig = function (id)
    {
        $scope.pageHeading = "Edit Email Account Configuration";
        Data.post('email-config/manageEmails', {id: id}).then(function (response) {
            if (id === 'index'){ // index
                $scope.listmails = response.records;
                $scope.exportData = response.exportData;
                $scope.deleteBtn = response.delete;
            }
            if (id > 0){ // Edit
                $scope.emailData = angular.copy(response.records[0]);
                $scope.emailData.department_id = response.departments;
            }
        });
    }
    $scope.createEmail = function (emaildata, id)
    {
        if (id > 0)
        { // for update
            Data.put('email-config/' + id, {emaildata: emaildata}).then(function (response) {
                if (!response.success) {
                    toaster.pop('error', 'Email Configuration', response.message);
                } else {
                    toaster.pop('success', 'Email Configuration', response.message);
                    $state.go('emailConfigIndex');
                }
            });
        } else
        { // for create
            Data.post('email-config/', {emaildata: emaildata}).then(function (response) {
                if (!response.success) {
                    toaster.pop('error', 'Email Configuration', response.message);
                } else {
                    toaster.pop('success', 'Email Configuration', response.message);
                    $state.go('emailConfigIndex');
                }
            });
        }
    }
}]);

app.controller('listDepartmentOnUpdateCtrl', function ($scope, Data, $timeout) {
    $scope.listDepartmentOnUpdate = [];
        Data.get('email-config/getDepartments').then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.listDepartmentOnUpdate = response.records;
            }
        });
});

app.controller('listDepartmentOnCreateCtrl', function ($scope, Data, $timeout) {
    Data.get('email-config/getDepartments').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.listDepartmentOnCreate = response.records;
        }
    });
});