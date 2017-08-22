app.controller('emailconfigCtrl', ['$scope', 'Data', '$rootScope', '$timeout', 'toaster', '$state', function ($scope, Data, $rootScope, $timeout, toaster, $state)
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
    
    $scope.manageEmailConfig = function (id)
    {
        $scope.pageHeading = "Edit Email Account";
        Data.post('email-config/manageEmails', {id: id}).then(function (response) {
            if (id === 'index'){ // index
                $scope.listmails = response.records;
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