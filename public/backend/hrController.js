/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';
app.controller('hrController', ['$rootScope', '$scope', '$state', 'Data', '$filter', 'Upload', '$timeout', function ($rootScope, $scope, $state, Data, $filter, Upload, $timeout) {
    $scope.pageHeading = 'Create User';

    $scope.userData = {};
    $scope.listUsers = [];
    $scope.userData.gender = $scope.userData.title = $scope.userData.blood_group_id =
    $scope.userData.physic_status_id = $scope.userData.marital_status = $scope.userData.highest_education_id =
    $scope.userData.current_country_id = $scope.userData.current_state_id = $scope.userData.current_city_id =
    $scope.userData.permenent_country_id = $scope.userData.permenent_state_id = $scope.userData.permenent_city_id = "";
    $scope.userData.employee_status = "1";
    $scope.userData.personal_mobile_no1 = $scope.userData.office_mobile_no = $scope.userData.personal_mobile_no2 = $scope.userData.landline_no = "+91-";
    $scope.disableCreateButton = false;
    $scope.currentPage =  $scope.itemsPerPage = 4;
    $scope.noOfRows = 1;
   
    $scope.validateMobileNumber = function (value) {
        var regex = /^(\+\d{1,4}-)\d{10}$/;
        if(!regex.test(value)){
            $scope.errMobile = "Mobile number should be 10 digits and pattern should be for ex. +91-9999999999";
        }
        else{
            $scope.errMobile = "";
        }    
    };
    $scope.validateLandlineNumber = function (value) {
        var regex = /^(\+\d{1,4}-\d{1,4}-)\d{6}$/;
        if(!regex.test(value)){
            $scope.errLandline = "Landline number should be 12 digits and pattern should be for ex. +91-1234-999999";
        }
        else{
            $scope.errLandline = "";
        }    
    };
    
    /*$scope.checkTitle = function () {
        if ($scope.userData.title === "Mrs.")
        {
            $scope.userData.marital_status = "2";
            $("#marital_status").prop("disabled","disabled");
        }
        else{
            $scope.userData.marital_status = "1";
            $("#marital_status").removeAttr("disabled");
        }
    }*/

    $scope.checkboxSelected = function (copy) {
        if (copy) {  // when checked
            $scope.userData.permenent_country_id = $scope.userData.permenent_state_id = $scope.userData.permenent_city_id = "";
            $scope.userData.permenent_address = angular.copy($scope.userData.current_address);
            $scope.userData.permenent_country_id = angular.copy($scope.userData.current_country_id);
            $scope.userData.permenent_pin = angular.copy($scope.userData.current_pin);

            Data.post('getStates', {
                data: {countryId: $scope.userData.current_country_id},
            }).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.stateList = response.records;
      
                    Data.post('getCities', {
                        data: {stateId: $scope.userData.current_state_id},
                    }).then(function (response) {
                        if (!response.success) {
                            $scope.errorMsg = response.message;
                        } else {
                            $scope.cityList = response.records;
                            $timeout(function () {
                                
                                $scope.userData.permenent_state_id = angular.copy($scope.userData.current_state_id);
                                $scope.userData.permenent_city_id = angular.copy($scope.userData.current_city_id);
                            }, 100);
                        }
                    });
                }
            });
        } else {
            $scope.userData.permenent_address = $scope.userData.permenent_country_id = $scope.userData.permenent_state_id = $scope.userData.permenent_city_id = $scope.userData.permenent_pin = "";
        }
    };

    $scope.createUser = function (enteredData, employeePhoto, empId) {
        var userData = {};
        if(empId === 0)
        {
            userData = angular.fromJson(angular.toJson(enteredData));
            var date = new Date($scope.userData.date_of_birth);
            $scope.userData.date_of_birth = (date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate());

            var date = new Date($scope.userData.joining_date);
            $scope.userData.joining_date = (date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate());

            employeePhoto.upload = Upload.upload({
                url: 'admin/master-hr',
                headers: {enctype: 'multipart/form-data'},
                data: {userData: userData, emp_photo_url: employeePhoto},
            });
            employeePhoto.upload.then(function (response) {
                console.log(response);
                $timeout(function () {console.log("3"+response.data.success);
                    if (!response.data.success) {
                        var obj = response.data.message;
                        var arr = Object.keys(obj).map(function(k) { return obj[k] });
                        var err = [];
                        console.log(arr);
                        var j = 0;
                        for (var i = 0; i < arr.length; i++) {
                          err.push(arr[j++].toString());
                        }                 
                        $scope.errorMsg = err;
                    } else
                    {
                        $scope.disableCreateButton = true;
                        employeePhoto.result = response.data;
                        $rootScope.alert('success', "Employee registeration successfully.");
                        $('.alert-delay').delay(3000).fadeOut("slow");
                        $timeout(function () {
                            $state.go('admin.userIndex');
                        }, 1000);
                    }
                });
            }, function (response) {
                if (response.status !== 200) {console.log(response.status);
                    $scope.errorMsg = "Something went wrong. Check your internet connection";
                }
            }, function (evt, response) {
        //            employeePhoto.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            });
        }
        else{
            userData = angular.fromJson(angular.toJson(enteredData));
            var date = new Date($scope.userData.date_of_birth);
            $scope.userData.date_of_birth = (date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate());
            var date = new Date($scope.userData.joining_date);
            $scope.userData.joining_date = (date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate());
        
            employeePhoto.upload = Upload.upload({              
                url: 'admin/master-hr/' + empId,
                headers: {enctype: 'multipart/form-data'},
                data: {_method: 'PUT',userData: userData, emp_photo_url: employeePhoto, empId: empId},
            });
            employeePhoto.upload.then(function (response) {
                console.log(response);
                $timeout(function () {
                    if (!response.data.success) {
                        var obj = response.data.message;
                        var arr = Object.keys(obj).map(function(k) { return obj[k] });
                        var err = [];
                        var j = 0;
                        for (var i = 0; i < arr.length; i++) {
                          err.push(arr[j++].toString());
                        }                 
                        $scope.errorMsg = err;
                    } else
                    {
                        $scope.disableCreateButton = true;
                        employeePhoto.result = response.data;
                        $rootScope.alert('success', "Employee registeration updated successfully.");
                        $('.alert-delay').delay(3000).fadeOut("slow");
                        $timeout(function () {
                            $state.go('admin.userIndex');
                        }, 1000);
                    }
                });
            }, function (response) {
                if (response.status !== 200) {
                    $scope.errorMsg = "Something went wrong. Check your internet connection";
                }
            }, function (evt, response) {
            });
        }
    };

    $scope.checkImageExtension = function (employeePhoto) {
        if (typeof employeePhoto !== 'undefined') {
            var ext = employeePhoto.name.match(/\.(.+)$/)[1];
            if (angular.lowercase(ext) === 'jpg' || angular.lowercase(ext) === 'jpeg' || angular.lowercase(ext) === 'png' || angular.lowercase(ext) === 'bmp' || angular.lowercase(ext) === 'gif' || angular.lowercase(ext) === 'svg') {
                $scope.errorMsg = "";
                $scope.altName = employeePhoto.name;
            } else {
                document.getElementById("emp_photo_url").value = "";
                $scope.errorMsg = "Invalid file format. Image should be jpg or jpeg or png or bmp format only.";
            }
        }
    };

//    $scope.checkDepartment = function () {
//        if ($scope.userData.department_id.length === 0) {
//            $scope.emptyDepartmentId = true;
//        } else {
//            $scope.emptyDepartmentId = false;
//        }
//    };

    $scope.manageUsers = function (id,action) { //edit/index page
        $scope.modal = {};
        Data.post('master-hr/manageUsers',{
            empId: id,
        }).then(function (response) {
            if (response.success) {
                if(action === 'index'){
                    $scope.listUsers = response.records.data;
                    $scope.listUsersLength = response.records.total;
                }
                else if(action === 'edit'){
                    if(id !== '0'){
                        $scope.pageHeading = 'Edit User';
                        $scope.buttonLabel = 'Update';
                        $scope.userData = angular.copy(response.records.data[0]);
                        $scope.userData.password = '';
                        var personal_mobile_no1_code = '+' + response.records.data[0].mobile1_calling_code + '-';
                        var office_mobile_no_code = '+' + response.records.data[0].office_mobile_calling_code + '-';
                        $scope.userData.personal_mobile_no1 = personal_mobile_no1_code + angular.copy(response.records.data[0].personal_mobile_no1);
                        $scope.userData.office_mobile_no = office_mobile_no_code + angular.copy(response.records.data[0].office_mobile_no);
                        if (response.records.data[0].mobile2_calling_code !== null) {
                            var personal_mobile_no2_code = '+' + response.records.data[0].mobile2_calling_code + '-';
                            $scope.userData.personal_mobile_no2 = personal_mobile_no2_code + angular.copy(response.records.data[0].personal_mobile_no2);
                        }
                        if (response.records.data[0].landline_no !== null) {
                            var landlineNo = response.records.data[0].landline_calling_code + '-';
                            $scope.userData.landline_no = landlineNo + angular.copy(response.records.data[0].landline_no);
                        }
                        var current_country = response.records.data[0].current_country_id;
                        var current_state = response.records.data[0].current_state_id;

                        Data.post('getStates', {
                            data: {countryId: current_country},
                        }).then(function (response) {
                            if (!response.success) {
                                $scope.errorMsg = response.message;
                            } else {
                                $scope.stateList = response.records;
                                Data.post('getCities', {
                                    data: {stateId: current_state},
                                }).then(function (response) {
                                    if (!response.success) {
                                        $scope.errorMsg = response.message;
                                    } else {
                                        $scope.cityList = response.records;
                                        $timeout(function () {
                                            $scope.userData.permenent_state_id = angular.copy($scope.userData.current_state_id);
                                            $scope.userData.permenent_city_id = angular.copy($scope.userData.current_city_id);
                                        }, 500);
                                    }
                                });
                            }
                        });
                        $scope.img_url = response.records.data[0].emp_photo_url;
                        var deptId = response.records.data[0].department_id;
                        Data.post('master-hr/getDepartmentsToEdit', {
                            data: {deptId: deptId},
                            async:false,
                        }).then(function (response) {
                            if (!response.success) {
                                $scope.errorMsg = response.message;
                            } else {
                                $scope.userData.department_id = response.records; 
                            }
                        });
                    }
                }
                else{
                    $scope.modal.empId = id;
                    $scope.modal.firstName = response.records.data[0].first_name;
                    $scope.modal.lastName = response.records.data[0].last_name;
                    $scope.modal.userName = response.records.data[0].username;
                }
            } else {
                $scope.errorMsg = response.message;
            }
        });
    };

    $scope.pageChangeHandler = function(num) {
        $scope.noOfRows = num;
        $scope.currentPage = num * $scope.itemsPerPage;
    };
    /*$scope.getEmployeeDetails = function (id,action) { //edit and change password popup page
        $scope.modal = {};
        Data.post('master-hr/manageUsers', {
            empId: id,
        }).then(function (response) {
            if (response.success) {
                if(action === 'edit' )
                $scope.modal.empId = id;
                $scope.modal.firstName = response.records.data[0].first_name;
                $scope.modal.lastName = response.records.data[0].last_name;
                $scope.modal.userName = response.records.data[0].username;

            } else {
                $scope.errorMsg = response.message;
            }
        });
    };*/

    $scope.changePassword = function (id) {
        Data.post('master-hr/changePassword', {
            empId: id,
        }).then(function (response) {
            console.log(response);
            if (response.success) {
                $scope.successMsg = response.message;
            } else {
                $scope.errorMsg = response.message;
            }
        });
    }
    
}]);