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
//$scope.userData.dt = $scope.userData.joining_date = $filter('date')(new Date(), 'yyyy-MM-dd');
    $scope.userData.employee_status = "1";
    $scope.userData.personal_mobile_no1 = $scope.userData.office_mobile_no = "+91-";
    $scope.departments = [];
//    $scope.status = true;
    $scope.checkboxSelected = function () {
        if ($scope.copyContent) {  // when checked
            $scope.userData.permenent_address = angular.copy($scope.userData.current_address);
            $scope.userData.permenent_country_id = angular.copy($scope.userData.current_country_id);
            $scope.userData.permenent_state_id = angular.copy($scope.userData.current_state_id);
            $scope.userData.permenent_city_id = angular.copy($scope.userData.current_city_id);
            $scope.userData.permenent_pin = angular.copy($scope.userData.current_pin);
        } else {
            $scope.userData.permenent_country_id = $scope.userData.permenent_state_id = $scope.userData.permenent_city_id = $scope.userData.permenent_pin = "";
        }
    };

    $scope.createUser = function (userData, employeePhoto) {
        console.log(userData);
        console.log(employeePhoto);
        userData.emp_photo_url = employeePhoto.name;
        
        var date = new Date($scope.userData.date_of_birth);
        $scope.userData.date_of_birth = (date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate());
        
        var date = new Date($scope.userData.joining_date);
        $scope.userData.joining_date = (date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate());
        
        Data.post('master-hr', {
            data: {userData: userData, employeePhoto: employeePhoto},
        }).then(function (response,evt) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                employeePhoto.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            }
        });
        
        
        /*employeePhoto.upload = Upload.upload({
            url: 'master-hr/uploadFile',
            data: {employeePhoto: employeePhoto},
        });
        employeePhoto.upload.then(function (response) {
            $timeout(function () {
                employeePhoto.result = response.data;
            });
        }, function (response) {
            if (response.status > 0)
                $scope.errorMsg = response.status + ': ' + response.data;
        }, function (evt) {
            // Math.min is to fix IE which reports 200% sometimes
            employeePhoto.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
        }); */
    };

    $scope.checkImageExtension = function(employeePhoto){
        if(typeof employeePhoto !== 'undefined'){
            var ext = employeePhoto.name.match(/\.(.+)$/)[1];
            if(angular.lowercase(ext) ==='jpg' || angular.lowercase(ext) ==='jpeg' || angular.lowercase(ext) ==='png' || angular.lowercase(ext) ==='bmp'){
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
    
    /*$scope.uploadPic = function (file) {
        console.log(file);
        var ext = file.name.match(/\.(.+)$/)[1];
        if(angular.lowercase(ext) ==='jpg' || angular.lowercase(ext) ==='jpeg' || angular.lowercase(ext) ==='png' || angular.lowercase(ext) ==='bmp'){
            file.upload = Upload.upload({
                url: 'master-hr/uploadFile',
                data: {file: file},
            });
            file.upload.then(function (response) {
                $timeout(function () {
                    file.result = response.data;
                });
            }, function (response) {
                if (response.status > 0)
                    $scope.errorMsg = response.status + ': ' + response.data;
            }, function (evt) {
                // Math.min is to fix IE which reports 200% sometimes
                file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            });
        }  
        else{
            document.getElementById("emp_photo_url").value = "";
            $scope.errorMsg = "Invalid file format. Image should be jpg or jpeg or png or bmp format only.";
        }
    }*/
}]);

/*app.directive('validFile', function() {
  return {
    link: function(scope, elem, attr, ctrl) {
      function bindEvent(element, type, handler) {
        if (element.addEventListener) {
          element.addEventListener(type, handler, false);
        } else {
          element.attachEvent('on' + type, handler);
        }
      }
      var ext = this.files[0].name.match(/\.(.+)$/)[1];
      console.log(ext);
      bindEvent(elem[0], 'change', function() {
        if(angular.lowercase(ext) ==='jpg' || angular.lowercase(ext) ==='jpeg' || angular.lowercase(ext) ==='png' || angular.lowercase(ext) ==='bmp' ){
            alert("Valid File Format");
        }  
        //alert('File size:' + this.files[0].name.match(/\.(.+)$/)[1]);
      });
    }
  }
});*/
