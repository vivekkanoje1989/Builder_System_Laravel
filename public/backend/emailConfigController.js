app.controller('emailconfigCtrl', ['$scope', 'Data', '$rootScope', '$timeout', 'toaster','$state', function ($scope, Data, $rootScope, $timeout, toaster,$state) {
        $scope.currentPage = $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.lstAlldepartments = [];
        $scope.manageEmailConfig = function (id)
        {
            Data.post('email-config/manageEmails', {id: id}).then(function (response) {
                if (id === 'index')
                { // index
                    $scope.listmails = response.records;
                }
                if (id > 0)
                { // Edit
                    $scope.emailData = angular.copy(response.records[0]);
                    $scope.emailData.department_id = response.departments;
                    console.log($scope.emailData.department_id);
                }
            });
        }
        $scope.testMail = function (credentials, id)
        {
            Data.post('email-config/testEmail', {email: credentials.email, password: credentials.password}).then(function (response)
            {
                if (!response.success)
                {
                    toaster.pop('error', 'Email Configuration', 'Wrong Credntials!!');
                    if (id > 0) {
                        document.getElementById("savebtn").style.display = 'none';
                    } else
                    {
                        document.getElementById("createbtn").style.display = 'none';
                    }                   
                } else
                {
                    toaster.pop('success', 'Email Configuration', 'Valid Credentials');
                    if (id > 0) {
                        document.getElementById("savebtn").style.display = 'inline';
                    } else
                    {
                        document.getElementById("createbtn").style.display = 'inline';
                    }
                }
            });
        }
        $scope.createEmail = function (emaildata, id)
        {
            if (id > 0)
            { // for update
                Data.put('email-config/' + id, {emaildata: emaildata}).then(function (response) {
                    if (!response.success) {
                        toaster.pop('error', 'Email Configuration', 'Something Went Wrong');
                    } else{
                        toaster.pop('success', 'Email Configuration', 'Account configured successfully');
                        $state.go(getUrl+'.emailConfigIndex');
                    }
                });
            } else
            { // for create
                Data.post('email-config/', {emaildata: emaildata}).then(function (response) {
                    if (!response.success){
                        toaster.pop('error', 'Email Configuration', 'Account Not created');
                    } else{
                        toaster.pop('success', 'Email Configuration', 'Account created successfully');
                        $state.go(getUrl+'.emailConfigIndex');
                    }
                });
            }
        }
    }]);

app.controller('listDepartmentCtrl', function ($scope, Data, $timeout) {
    $scope.lstdepartments = [];
    $timeout(function () {
        Data.get('email-config/getDepartments').then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.lstdepartments = response.records;
            }
        });
    }, 3000);
});

app.controller('listAllDepartmentCtrl', function ($scope, Data, $timeout) {
    $timeout(function () {
        Data.get('email-config/getDepartments').then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                //console.log(response);
                $scope.lstAlldepartments = response.records;
            }
        });
    }, 3000);
});