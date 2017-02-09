/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';
app.controller('hrController',['$scope', 'Data', '$filter', 'Upload', '$timeout', function ($scope, Data, $filter, Upload, $timeout) {
    $scope.pageHeading = 'Create User';

    $scope.userData = {};
    $scope.userData.gender = $scope.userData.title = $scope.userData.blood_group_id =
    $scope.userData.physic_status_id = $scope.userData.marital_status = $scope.userData.highest_education_id =
    $scope.userData.current_country_id = $scope.userData.current_state_id = $scope.userData.current_city_id =
    $scope.userData.permenent_country_id = $scope.userData.permenent_state_id = $scope.userData.permenent_city_id = "";
//    $scope.userData.date_of_birth = $scope.userData.joining_date = $filter('date')(new Date(), 'yyyy-MM-dd');
    $scope.userData.employee_status = "1";
    $scope.userData.personal_mobile_no1 = $scope.userData.office_mobile_no = "+91-";
    $scope.departments = [];
    $scope.checkboxSelected = function (copy) {
        if (copy) {  // when checked
            $scope.userData.permenent_address = angular.copy($scope.userData.current_address);
            $scope.userData.permenent_country_id = angular.copy($scope.userData.current_country_id);
            $scope.userData.permenent_pin = angular.copy($scope.userData.current_pin);
            Data.post('getStates',{
                data: {countryId: $scope.userData.current_country_id},
            }).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.stateList = response.records;
                    Data.post('getCities',{
                        data: {stateId: $scope.userData.current_state_id},
                    }).then(function (response) {
                        if (!response.success) {
                            $scope.errorMsg = response.message;
                        } else {
                            $scope.cityList = response.records;
                            $timeout(function() {
                                $scope.userData.permenent_state_id = angular.copy($scope.userData.current_state_id);   
                                $scope.userData.permenent_city_id = angular.copy($scope.userData.current_city_id);
                            }, 500);
                        }        
                    });
                }
            });
        } else {
            $scope.userData.permenent_address = $scope.userData.permenent_country_id = $scope.userData.permenent_state_id = $scope.userData.permenent_city_id = $scope.userData.permenent_pin = "";
        }
    };

    $scope.createUser = function (enteredData, employeePhoto) {
        var userData = {};
        userData = angular.fromJson(angular.toJson(enteredData));
        var date = new Date($scope.userData.date_of_birth);
        $scope.userData.date_of_birth = (date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate());
        
        var date = new Date($scope.userData.joining_date);
        $scope.userData.joining_date = (date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate());
       console.log(userData);
        employeePhoto.upload = Upload.upload({
            url: 'admin/master-hr',
            headers: {enctype:'multipart/form-data'},
            data: {userData:userData, emp_photo_url: employeePhoto},
        });
        employeePhoto.upload.then(function (response) {
            $timeout(function () {
                employeePhoto.result = response.data;
                if(!response.data.success){
                    $scope.errorMsg = response.message;
                }                    
            });
        }, function (response) {
            if (response.status > 0){
                $scope.errorMsg = response.status + ': ' + response.data;
            }
        }, function (evt) {
            employeePhoto.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
        }); 
    };

    $scope.checkImageExtension = function(employeePhoto){
        if(typeof employeePhoto !== 'undefined'){
            var ext = employeePhoto.name.match(/\.(.+)$/)[1];
            if(angular.lowercase(ext) ==='jpg' || angular.lowercase(ext) ==='jpeg' || angular.lowercase(ext) ==='png' || angular.lowercase(ext) ==='bmp' || angular.lowercase(ext) ==='gif'|| angular.lowercase(ext) ==='svg'){
                $scope.errorMsg = "";
            }  
            else{
                document.getElementById("emp_photo_url").value = "";
                $scope.errorMsg = "Invalid file format. Image should be jpg or jpeg or png or bmp format only.";
            }
        }
    };
    
    $scope.checkDepartment = function () {
        if($scope.userData.department_id.length === 0){
            $scope.emptyDepartmentId = true;
        }
        else{
            $scope.emptyDepartmentId = false;
        }
    };
    
}]);
