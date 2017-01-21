'use strict';
app.controller('adminController', function ($rootScope, $scope, $location, $http, $state, Data, $window) {
    
    $scope.registration = {};    
    $scope.errorMsg = '';
      
    /*$scope.$watch(Auth.isLoggedIn, function (value, oldValue) 
    {
        if(!value && oldValue) {
          console.log("Disconnect");
        }
        if(value) {
            console.log("Connect");
            if($rootScope.authenticated === true){
                $http.get('admin/getMenuItems').then(function (response) {
                    $scope.siteMenu = response.data;
                    }, function (error) {
                        alert('Error');
                }); 
            }
        }
    }, true);*/
    
    $scope.login = function (loginData) {
        Data.post('authenticate', {
            contentType: "application/json",
            dataType: "json",
            data: loginData,
            headers : {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.success){
                $state.reload();
                $state.go('admin.dashboard');
                return false;                
            }
            else{
                $scope.errorMsg = response.message;     
            }  
        });
    };
    $scope.logout = function (logoutData) {
        Data.post('logout', {
            data: logoutData
        }).then(function (response) {
            if(response.success){
                $rootScope.authenticated = false;
                $state.go('login');
            }
            else{           
                $scope.errorMsg = response.message;
            }
        });
    }
    $scope.signUp = function (registerationData) {
        Data.post('saveRegister', {
            data: registerationData
        }).then(function (response) {
            if(!response.success){
                $scope.errorMsg = response.message;
            }
            else{                
                $state.go('login');
                $state.reload();
            }
        });
    };
    $scope.sendResetLink = function (sendEmailData) {  
        Data.post('password/email',{
            data: sendEmailData
        }).then(function (response) {
            if(!response.success){
                $scope.errorMsg = response.message;
            }
            else{            
                 $scope.successMsg = response.message;
            }
        });
    }
    $scope.resetPassword = function (resetData) {  
        Data.post('password/reset',{
            data: resetData
        }).then(function (response) {
            if(!response.success){
                $scope.errorMsg = response.message;
            }
            else{
                $state.go('admin.dashboard');
            }
        });
    }
});
app.controller('titleCtrl', function ($scope, Data) {
    Data.get('getTitle').then(function (response) {
        if(!response.success){
            $scope.errorMsg = response.message;
        }
        else{
           $scope.titles = response.records;
        }
    });
});
app.controller('genderCtrl', function ($scope, Data) {
    Data.get('getGender').then(function (response) {
        if(!response.success){
            $scope.errorMsg = response.message;
        }
        else{
           $scope.genders = response.records;
        }
    });
});
app.controller('bloodGroupCtrl', function ($scope, Data) {
    Data.get('getBloodGroup').then(function (response) {
        if(!response.success){
            $scope.errorMsg = response.message;
        }
        else{
           $scope.bloodGroups = response.records;
        }
    });
});
app.controller('departmentCtrl', function ($scope, Data) {
    Data.get('getDepartments').then(function (response) {
        if(!response.success){
            $scope.errorMsg = response.message;
        }
        else{
           $scope.departments = response.records;
        }
    });
});
app.controller('educationListCtrl', function ($scope, Data) {
    Data.get('getEducationList').then(function (response) {
        if(!response.success){
            $scope.errorMsg = response.message;
        }
        else{
           $scope.educationList = response.records;
        }
    });
}); 
app.controller('countryListCtrl', function ($scope, Data) {
    Data.get('getCountries').then(function (response) {
        if(!response.success){
            $scope.errorMsg = response.message;
        }
        else{
           $scope.countryList = response.records;
        }
    });
}); 
app.controller('stateListCtrl', function ($scope, Data) {
    Data.get('getStates').then(function (response) {
        if(!response.success){
            $scope.errorMsg = response.message;
        }
        else{
           $scope.stateList = response.records;
        }
    });
}); 
app.controller('cityListCtrl', function ($scope, Data) {
    Data.get('getCities').then(function (response) {
        if(!response.success){
            $scope.errorMsg = response.message;
        }
        else{
           $scope.cityList = response.records;
        }
    });
});

//$(document).ready(function() {
//    $(document).on("contextmenu",function(e){
//       return false;
//    }); 
//});