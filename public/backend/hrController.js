app.controller('hrController', ['$rootScope', '$scope', '$state', 'Data', 'Upload', '$timeout', '$parse', '$stateParams', 'toaster', function ($rootScope, $scope, $state, Data, Upload, $timeout, $parse, $stateParams, toaster) {
        $scope.pageHeading = 'Create User';
        $scope.buttonLabel = 'Create';
        $scope.userData = {};
        $scope.userContact = {};
        $scope.userEducation = {};
        $scope.userJobData = {};
        $scope.userStatus = {};
        $scope.userPersonalData = {};
        $scope.designationList = [];
        $scope.invalidImage = '';
        $scope.contact = true;
        $scope.listUsers = [];
        var today = new Date();
        today.setYear(today.getFullYear() - 20);
        $scope.maxDates = new Date(today.getFullYear(), today.getMonth(), today.getDate());
        $scope.currentPin = false;
        $scope.isDisabled = false;
        $scope.roleData = {};
        $scope.userData.gender_id = $scope.userData.title_id = $scope.userData.blood_group_id =
                $scope.userData.physic_status = $scope.userData.marital_status = $scope.userData.highest_education_id =
                $scope.userData.current_country_id = $scope.userData.current_state_id = $scope.userData.current_city_id =
                $scope.userData.permenent_country_id = $scope.userData.permenent_state_id = $scope.userData.permenent_city_id = "";
        $scope.userData.employee_status = "1";
        $scope.userData.personal_mobile1 = $scope.userData.office_mobile_no = $scope.userData.personal_mobile2 = $scope.userData.personal_landline_no = "+91-";
        $scope.disableCreateButton = false;
        $scope.btnExport = true;
        $scope.dnExcelSheet = false;
        $scope.report_name;

        $scope.flagForChange = 0;
        $scope.itemsPerPage = 30;
        $scope.pageNumber = 1;
        $rootScope.menuId = [];
        $rootScope.roleMenuList = [];
        $scope.currentPage = 30;
        $scope.noOfRows = 1;
        $rootScope.imageUrl = "";
        $scope.userData.high_security_password_type = 0;
        $scope.userData.current_country_id = $scope.userData.permenent_country_id = 101;
        var date = new Date($scope.userData.date_of_birth);
        $scope.userData.date_of_birth = ((date.getFullYear() - 100) + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
        $scope.userData.date_of_birth = ("1990-01-01");
        $rootScope.menuId = [];
        $rootScope.roleMenuList = [];
        $scope.searchDetails = {};
        $scope.searchData = {};

        $scope.filterDetails = function (search) {
//            angular.forEach(search, function (key, value) {
//                var data = value.length;
//                if (data !== 0) {
            if (search.joining_date != undefined) {
                var today = new Date(search.joining_date);
                search.joining_date = (today.getFullYear() + '-' + ("0" + (today.getMonth() + 1)).slice(-2) + '-' + today.getDate());
            }
            if (search.login_date_time != undefined) {
                var loginDate = new Date(search.login_date_time);
                search.login_date_time = (loginDate.getDate() + '-' + ("0" + (loginDate.getMonth() + 1)).slice(-2) + '-' + loginDate.getFullYear());
            }
            $scope.searchData = search;

//                }
//            });
        }
        $scope.removeFilterData = function (keyvalue) {
            delete $scope.searchData[keyvalue];
            $scope.filterDetails($scope.searchData);
        }
        $scope.closeModal = function () {
            $scope.searchData = {};
        }

        $scope.validateMobileNumber = function (value) {
            var regex = /^(\+\d{1,4}-)\d{10}$/;
            if (!regex.test(value)) {
                $scope.errMobile = "Mobile number should be 10 digits and pattern should be for ex. +91-9999999999";
                $scope.applyClassMobile = 'ng-active';
            } else {
                $scope.errMobile = "";
                $scope.applyClassMobile = 'ng-inactive';
            }
        };
        $scope.validateLandlineNumber = function (value) {
            var validLandline = value;
            if (validLandline != '') {
                if (validLandline === "1234567890" || validLandline === "0000000000" || validLandline[0] === "0") {
                    $scope.errLandline = "Invalid Landline number";
                    $scope.applyClass = 'ng-active';
                    $scope.userContactForm.$valid = false;
                } else {
                    $scope.errLandline = "";
                    $scope.applyClass = 'ng-inactive';
                }
            } else {
                $scope.errLandline = "";
                $scope.applyClass = 'ng-inactive';
            }
        };

        $scope.checkDepartment = function (id) {
            if (id == 1) {

                if ($scope.userData.department_id.length === 0) {
                    $scope.emptyDepartmentId = true;
                    $scope.applyClassDepartment = 'ng-active';
                } else {
                    $scope.emptyDepartmentId = false;
                    $scope.applyClassDepartment = 'ng-inactive';
                }
            } else {
                if ($scope.userJobData.department_id.length === 0) {
                    $scope.emptyDepartmentId = true;
                    $scope.applyClassDepartment = 'ng-active';
                } else {
                    $scope.emptyDepartmentId = false;
                    $scope.applyClassDepartment = 'ng-inactive';
                }
            }
        };
        $scope.checkDepartmentId = function (id) {
            if ($scope.searchDetails.departmentName.length === 0) {
                $scope.emptyDepartmentId = true;
                $scope.applyClassDepartment = 'ng-active';
            } else {
                $scope.emptyDepartmentId = false;
                $scope.applyClassDepartment = 'ng-inactive';
            }
        };
        $scope.checkImageExtension = function (employeePhoto) {
            if (typeof employeePhoto !== 'undefined' || typeof employeePhoto !== 'object') {
                var ext = employeePhoto.name.match(/\.(.+)$/)[1];
                if (angular.lowercase(ext) === 'jpg' || angular.lowercase(ext) === 'jpeg' || angular.lowercase(ext) === 'png' || angular.lowercase(ext) === 'bmp' || angular.lowercase(ext) === 'gif' || angular.lowercase(ext) === 'svg') {
                    $scope.invalidImage = "";
                } else {
                    $(".imageFile").val("");
                    $scope.invalidImage = "Invalid file format. File type should be jpg or jpeg or png or bmp format only.";
                    $scope.usereducationForm.$valid = false;
                }
            }
        };

        $scope.validateMobile = function (mobNo, label) {
            var mobNoSplit = mobNo.split('-')[1];
            var firstDigit = mobNoSplit.substring(0, 1);

            var model = $parse(label);

            if (mobNoSplit === "0000000000") {
                model.assign($scope, "Mobile number should be 10 digits and pattern should be for ex. +91-9999999999");
                $scope.applyClassMobile = 'ng-active';
            } else if (firstDigit === "0") {
                model.assign($scope, "First digit of mobile number should not be 0");
                $scope.applyClassMobile = 'ng-active';
            } else {
                model.assign($scope, "");
                $scope.errPersonalMobile = "";
                $scope.applyClassMobile = 'ng-inactive';
            }
        }

        $scope.validatePMobile = function (mobNoSplit) {

            var firstDigit = mobNoSplit.substring(0, 1);

            if (firstDigit == "0") {
                $scope.errPersonalMobile = "First digit of mobile number should not be 0";
                $scope.applyClassPMobile = 'ng-active';
//                $scope.userContactForm.$valid = false;
                $scope.contact = false;

            }
            if (mobNoSplit == "0000000000") {

                $scope.errPersonalMobile = "Invalid mobile number";
                $scope.applyClassMobile = 'ng-active';
                $scope.contact = false;
//                $scope.userContactForm = false;
            } else if (mobNoSplit == "1234567890") {
                $scope.errPersonalMobile = "Invalid mobile number";
                $scope.applyClassPMobile = 'ng-active';
                $scope.contact = false;
            } else
            {
                $scope.errPersonalMobile = "";
                $scope.applyClassPMobile = 'ng-inactive';
                $scope.contact = true;
            }


        }

        $scope.copyToUsername = function (value) {
            if (typeof value !== "undefined") {
                $scope.userData.username = value.split('-')[1];
            }
        };
        $scope.roleType = function (empId) {
            Data.post('master-hr/checkRole', {empId: empId}).then(function (response) {
                if (response.role_id !== 0) {
                    $scope.roleData.roleType = 1; //role predefined 
                    $timeout(function () {
                        $scope.roleData.roleId = angular.copy(response.role_id);
                    }, 500);
                } else {
                    $scope.roleData.roleType = 0; //custom
                }
            });
        };
        $scope.checkUniqueEmpId = function (employeeId, recordId) {
            Data.post('master-hr/checkUniqueEmpId', {employeeId: employeeId, recordId: recordId}).then(function (response) {
                if (!response.success) {
                    $scope.duplicateEmpId = response.message;
                } else {
                    $scope.duplicateEmpId = '';
                }
            });
        };
//        $scope.getStepDiv = function (stepId, empId)
//        {
//            $scope.stepId = stepId;
//            if (empId != 0) {
//                $(".user_steps").each(function (index) {
//                    $(this).addClass('complete');
//                    $(this).removeClass('active')
//                });
//                $(".wizardstep" + stepId).addClass('active');
//                $(".wizardstep" + stepId).removeClass('complete');
//
//                $(".step-pane").css('display', 'none');
//                $("#wizardstep" + stepId).css('display', 'block');
//            } else {
//                if (stepId == 1)
//                {
//                    $scope.stepId = 1;
//                    $("#wizardstep1").css('display', 'block');
//                    $("#wizardstep1").addClass('active');
//                }
//            }
//        }

        $scope.createUser = function (enteredData, empId) {
            var userData = {};
            userData = angular.fromJson(angular.toJson(enteredData));
            if ($scope.employeeId === 0)
            {
                var date = new Date(enteredData.birth_date);

                enteredData.date_of_birth = (date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());

                if (enteredData.marital_status == 2) {
                    if (enteredData.marriage_date) {
                        var date = new Date(enteredData.marriage_date);
                        enteredData.marriage_date = (date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
                    }
                }
                var url = 'master-hr/storeEmployeeData';
                var data = {userData: enteredData, empId: empId};
                var successMsg = "Record successfully created.";
            } else {
                if (enteredData.birth_date == "NaN-aN-NaN" || enteredData.birth_date == '') {
                    enteredData.date_of_birth = '0000-00-00';
                } else {
                    var date = new Date(enteredData.birth_date);
                    enteredData.date_of_birth = (date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
                }
                if (enteredData.marital_status == 2) {
                    if (enteredData.marriage_date) {
                        var date = new Date(enteredData.marriage_date);
                        enteredData.marriage_date = (date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
                    }
                } else {
                    enteredData.marriage_date = '0000-00-00';
                }

                var url = 'master-hr/update';
                var successMsg = "Record successfully updated.";
                var data = {userData: enteredData, empId: empId};

            }
            Data.post(url, {
                data
            }).then(function (response) {
                if ($scope.employeeId == 0) {
                    $scope.userStatus.employee_id = response.empId;
                    toaster.pop('success', 'Create User', "Personal Information Saved Successfully");
                    $scope.employeeId = response.empId;
                    $rootScope.employeeId = response.empId;
                } else {
                    if (empId != 0) {
                        $scope.steps.first_name = 1;
                    }
                    toaster.pop('success', 'Edit User', "Personal Information Updated Successfully");

                }
                $("#wiredstep2").addClass('active');
                $(".wiredstep2").removeClass('complete');
                $("#wiredstep1").addClass('ng-hide');
                $("#wiredstep1").removeClass('active');
                $("#wiredstep2").removeClass('ng-hide');
                $("#wiredstep1").css('display', 'none');
                $("#wiredstep2").css('display', 'block');
                $(".wiredstep2").addClass("active");
                $(".wiredstep1").removeClass("active");
                $(".wiredstep1").addClass('complete');

            });
        };

        $scope.manageUsers = function (id, action) {
            $scope.modal = {};
            $scope.showloader();
            $scope.userStatus = {};
            $scope.userId = id;
            $scope.employeeId = id;
            $rootScope.employeeId = id;
            Data.post('master-hr/manageUsers', {
                empId: id
            }).then(function (response) {
                if (response.success) {
                    $scope.flagForChange = 0;
                    if (action == "index") {
                        $scope.listUsers = response.records.data;
                        $scope.listUsersLength = response.records.total;

                    } else if (action == "edit") {
                        if (id !== 0) {
                            $scope.Total = 1;
                            var blood_group_id = response.records.data[0].blood_group_id == '' ? 0 : 1;
                            var first_name = response.records.data[0].first_name == '' ? 0 : 1;
                            var personal_email1 = response.records.data[0].personal_email1 == '' ? 0 : 1;
                            var highest_education_id = response.records.data[0].highest_education_id == '' ? 0 : 1;
                            var department_id = response.records.data[0].department_id == '' ? 0 : 1;
                            if (department_id == 1) {
                                var username = response.records.data[0].username === '' ? 0 : 1;
                            } else {
                                var username = 0;
                            }
                            if (blood_group_id == 0) {
                                var first_name = 0;
                                var personal_email1 = 0;
                                var highest_education_id = 0;
                                var department_id = 0;
                                var username = 0;
                            }
                            $scope.Total = $scope.Total + first_name + personal_email1 + highest_education_id + department_id + username;

                            if ($scope.Total < 6) {
                                $("#step" + $scope.Total).addClass('active');
                                $("#step" + $scope.Total).removeClass('complete');
                            } else {
                                $("#step5").addClass('active');
                                $("#step5").removeClass('complete');
                            }


                            $rootScope.steps = {first_name: first_name, personal_email1: personal_email1,
                                highest_education_id: highest_education_id, deptId: department_id,
                                username: username
                            };
                            $scope.getStepDiv(1, $rootScope.steps, 2, 1);
                            if (response.records.data[0].current_address != '') {
                                if (response.records.data[0].current_address == response.records.data[0].permenent_address && response.records.data[0].current_city_id == response.records.data[0].permenent_city_id && response.records.data[0].current_country_id == response.records.data[0].permenent_country_id && response.records.data[0].current_pin == response.records.data[0].permenent_pin && response.records.data[0].current_state_id == response.records.data[0].permenent_state_id)
                                {
                                    $scope.copyContent = true;
                                }
                            }
                            $scope.pageHeading = 'Edit User';
                            $scope.buttonLabel = 'Update';
                            $scope.userPersonalData.title_id = response.records.data[0].title_id;
                            $scope.userPersonalData.first_name = response.records.data[0].first_name;
                            $scope.userPersonalData.middle_name = response.records.data[0].middle_name;
                            $scope.userPersonalData.last_name = response.records.data[0].last_name;
                            $scope.userPersonalData.gender_id = response.records.data[0].gender_id;
                            if (response.records.data[0].physic_status == '') {
                                $scope.userPersonalData.physic_status = '';
                            } else {
                                $scope.userPersonalData.physic_status = response.records.data[0].physic_status;
                            }
                            if (response.records.data[0].blood_group_id == '') {
                                $scope.userPersonalData.blood_group_id = '';
                            } else {
                                $scope.userPersonalData.blood_group_id = response.records.data[0].blood_group_id;
                            }
                            if (response.records.data[0].marital_status == '') {
                                $scope.userPersonalData.marital_status = '';
                            } else {
                                $scope.userPersonalData.marital_status = response.records.data[0].marital_status;
                            }


                            $scope.fullName = $scope.userPersonalData.first_name + ' ' + $scope.userPersonalData.last_name;
                            if (response.records.data[0].date_of_birth == '0000-00-00') {
                                $scope.userPersonalData.birth_date = '';
                            } else {
                                $scope.userPersonalData.birth_date = response.records.data[0].date_of_birth;
                            }

                            if (response.records.data[0].marriage_date == '0000-00-00' || response.records.data[0].marriage_date == 'NaN-aN-NaN') {
                                $scope.userPersonalData.marriage_date = '';
                            } else {
                                $scope.userPersonalData.marriage_date = response.records.data[0].marriage_date;
                            }
                            $scope.userContact.personal_email1 = response.records.data[0].personal_email1;
                            if (response.records.data[0].office_email_id == 'null')
                            {
                                $scope.userContact.office_email_id = '';
                            } else
                            {
                                $scope.userContact.office_email_id = response.records.data[0].office_email_id;
                            }

                            if (response.records.data[0].personal_email2 == 'null')
                            {
                                $scope.userContact.personal_email2 = '';
                            } else
                            {
                                $scope.userContact.personal_email2 = response.records.data[0].personal_email2;
                            }



                            if (response.records.data[0].personal_landline_calling_code == null || response.records.data[0].personal_landline_calling_code == 0) {
                                $scope.userContact.personal_landline_calling_code = '+91-';
                            } else {
                                $scope.userContact.personal_landline_calling_code = '+' + response.records.data[0].personal_landline_calling_code + '-';
                            }

                            if (response.records.data[0].personal_landline_no == "" || isNaN(response.records.data[0].personal_landline_no) || response.records.data[0].personal_landline_no == null)
                            {
                                $scope.userContact.personal_landline_no = '';
                            } else {
                                $scope.userContact.personal_landline_no = response.records.data[0].personal_landline_no;
                            }

                            if (response.records.data[0].personal_mobile1_calling_code == null || response.records.data[0].personal_mobile1_calling_code == 0) {
                                $scope.userContact.personal_mobile1_calling_code = '+91-';
                            } else {

                                $scope.userContact.personal_mobile1_calling_code = '+' + response.records.data[0].personal_mobile1_calling_code + '-';
                            }

                            if (response.records.data[0].personal_mobile1 == "" || isNaN(response.records.data[0].personal_mobile1) || response.records.data[0].personal_mobile1 == null) {
                                $scope.userContact.personal_mobile1 = '';
                            } else {
                                $scope.userContact.personal_mobile1 = response.records.data[0].personal_mobile1;
                            }

                            if (response.records.data[0].personal_mobile2_calling_code == null || response.records.data[0].personal_mobile2_calling_code == 0) {
                                $scope.userContact.personal_mobile2_calling_code = '+91-';
                            } else {

                                $scope.userContact.personal_mobile2_calling_code = '+' + response.records.data[0].personal_mobile2_calling_code + '-';
                            }

                            if (response.records.data[0].personal_mobile2 == "" || isNaN(response.records.data[0].personal_mobile2) || response.records.data[0].personal_mobile2 == null) {
                                $scope.userContact.personal_mobile2 = '';
                            } else {
                                $scope.userContact.personal_mobile2 = response.records.data[0].personal_mobile2;
                            }

                            if (response.records.data[0].office_mobile_calling_code == null || response.records.data[0].office_mobile_calling_code == '') {
                                $scope.userContact.office_mobile_calling_code = '+91-';
                            } else {
                                $scope.userContact.office_mobile_calling_code = '+' + response.records.data[0].office_mobile_calling_code + '-';
                            }
                            if (response.records.data[0].office_mobile_no == "" || isNaN(response.records.data[0].office_mobile_no) || response.records.data[0].office_mobile_no == null) {
                                $scope.userContact.office_mobile_no = '';
                            } else {
                                $scope.userContact.office_mobile_no = response.records.data[0].office_mobile_no;
                            }
//                            if ($scope.userJobData.designation_id != '') {
                            $scope.userStatus.username = response.records.data[0].personal_mobile1;
//                            }
                            //$scope.userContact.personal_email2 = response.records.data[0].personal_email2;
                            $scope.userContact.current_address = response.records.data[0].current_address;

                            if (response.records.data[0].current_country_id == null || response.records.data[0].current_country_id == "") {
                                $scope.userContact.current_country_id = '101';
                            } else {
                                $scope.userContact.current_country_id = response.records.data[0].current_country_id;
                            }
                            var current_state = response.records.data[0].current_state_id;
                            var current_city = response.records.data[0].current_city_id;
                            Data.post('getStates', {
                                data: {countryId: $scope.userContact.current_country_id},
                            }).then(function (response) {
                                if (!response.success) {
                                    $scope.errorMsg = response.message;
                                } else {
                                    $scope.stateList = response.records;
                                    Data.post('getCities', {
                                        data: {stateId: current_state},
                                    }).then(function (result) {
                                        if (!result.success) {
                                            $scope.errorMsg = result.message;
                                        } else {
                                            $scope.cityList = result.records;
                                            $timeout(function () {
                                                $scope.userContact.current_state_id = current_state;
                                                $scope.userContact.current_city_id = current_city;

                                            }, 500);
                                        }
                                    });
                                }
                            });
                            if (response.records.data[0].current_pin == 0) {
                                $scope.userContact.current_pin = '';
                            } else {
                                $scope.userContact.current_pin = response.records.data[0].current_pin;
                            }
                            $scope.userContact.permenent_address = response.records.data[0].permenent_address;
                            if (response.records.data[0].permenent_country_id != '') {
                                $scope.userContact.permenent_country_id = response.records.data[0].permenent_country_id;
                                var permenent_state = response.records.data[0].permenent_state_id;
                                var permenent_city = response.records.data[0].permenent_city_id;

                                Data.post('getStates', {
                                    data: {countryId: $scope.userContact.permenent_country_id},
                                }).then(function (result) {
                                    if (!response.success) {
                                        $scope.errorMsg = result.message;
                                    } else {
                                        $scope.stateTwoList = result.records;
                                        Data.post('getCities', {
                                            data: {stateId: permenent_state},
                                        }).then(function (cityresult) {
                                            if (!result.success) {
                                                $scope.errorMsg = cityresult.message;
                                            } else {
                                                $scope.cityTwoList = cityresult.records;
                                                $timeout(function () {
                                                    $scope.userContact.permenent_state_id = permenent_state;
                                                    $scope.userContact.permenent_city_id = permenent_city;
                                                }, 500);
                                            }
                                        });
                                    }
                                });
                                if (response.records.data[0].permenent_pin == 0) {
                                    $scope.userContact.permenent_pin = '';
                                } else {
                                    $scope.userContact.permenent_pin = response.records.data[0].permenent_pin;
                                }
                            }
                            if (response.records.data[0].highest_education_id == 0 || response.records.data[0].highest_education_id == '') {
                                $scope.userEducation.highest_education_id = '';
                            } else {
                                $scope.userEducation.highest_education_id = response.records.data[0].highest_education_id;
                            }

                            if (response.records.data[0].education_details == 'null') {
                                $scope.userEducation.education_details = '';
                            } else {
                                $scope.userEducation.education_details = response.records.data[0].education_details;
                            }

                            $scope.imgUrl = response.records.data[0].employee_photo_file_name;
                            $scope.userJobData.designation_id = response.records.data[0].designation_id;
                            $scope.userJobData.reporting_to_id = response.records.data[0].reporting_to_id;

                            if (response.records.data[0].joining_date == '0000-00-00') {

                                $scope.userJobData.joining_date = '';
                            } else {
                                $scope.userJobData.joining_date = response.records.data[0].joining_date;
                            }
                            $scope.userJobData.team_lead_id = response.records.data[0].team_lead_id;
                            $scope.userJobData.designation_id = response.records.data[0].designation_id;
                            $scope.userJobData.designation_id = response.records.data[0].designation_id;
                            var deptId = response.records.data[0].department_id;
                            Data.post('master-hr/getDepartmentsToEdit', {
                                data: {deptId: deptId},
                                async: false,
                            }).then(function (response) {
                                if (!response.success) {
                                    $scope.errorMsg = response.message;
                                } else {
                                    $scope.userJobData.department_id = response.records;
                                }
                            });
                            $scope.userStatus.employee_status = response.records.data[0].employee_status;
                            if (response.records.data[0].employee_id == 0) {
                                $scope.userStatus.employee_id = '';
                            } else {
                                $scope.userStatus.employee_id = response.records.data[0].employee_id;
                            }
                            $scope.userStatus.high_security_password_type = response.records.data[0].high_security_password_type;

                            if ($scope.userStatus.high_security_password_type == 1) {
                                $scope.userStatus.high_security_password = response.records.data[0].high_security_password;
                            } else {
                                $scope.userStatus.high_security_password = '';
                            }
//                            $scope.userStatus.username = response.records.data[0].username;
                            $scope.userStatus.show_on_homepage = response.records.data[0].show_on_homepage;
                        }
                    } else {

                        $scope.modal.empId = id;
                        $scope.modal.firstName = response.records.data[0].first_name;
                        $scope.modal.lastName = response.records.data[0].last_name;
                        $scope.modal.userName = response.records.data[0].username;
                    }
                } else {
                    $scope.errorMsg = response.message;
                }

                if (id == '0') {
                    $scope.userContact.personal_mobile1_calling_code = '+91-';
                    $scope.userContact.office_mobile_calling_code = '+91-';
                    $scope.userContact.personal_mobile2_calling_code = '+91-';
                    $scope.userContact.personal_landline_calling_code = '+91-';
                    $scope.userContact.current_country_id = '101';
                    $scope.userJobData.department_id = '';
                    Data.post('getStates', {
                        data: {countryId: $scope.userContact.current_country_id},
                    }).then(function (response) {
                        //   console.log(response)
                        if (!response.success) {
                            $scope.errorMsg = response.message;
                        } else {
                            $scope.stateList = response.records;
                            $timeout(function () {
                                $("#permenent_state_id").val($scope.userContact.current_state_id);
                                $("#permenent_city_id").val($scope.userContact.current_city_id);
                                $scope.userContact.permenent_state_id = angular.copy($scope.userContact.current_state_id);
                                $scope.userContact.permenent_city_id = angular.copy($scope.userContact.current_city_id);
                            }, 500);
                        }
                    });
                }
                $scope.hideloader();
            });
        };


        $scope.pageChanged = function (pageNo, functionName, id) {
            $scope.flagForChange++;
            $scope.action = 'index';
            $scope.emId = '';
            if ($scope.flagForChange == 1)
            {
                if (($scope.filterData && Object.keys($scope.filterData).length > 0) || ($scope.maxBudget > 0)) {
                    $scope.getFilteredData($scope.filterData, $scope.minBudget, $scope.maxBudget, pageNo, $scope.itemsPerPage);
                } else {
                    $scope[functionName](id, $scope.action, pageNo, $scope.itemsPerPage);
                }
            }
            $scope.pageNumber = pageNo;
        }


//        $scope.pageChanged = function (pageNo, functionName, id) {
//            $scope.action = 'index';
//            $scope[functionName](id, $scope.action, id, pageNo, $scope.itemsPerPage);
//            $scope.pageNumber = pageNo;
//        };
//        $scope.filterData = {};
//        $scope.data = {};
//
//        $scope.filteredData = function (data, page, noOfRecords) {
//
//            $scope.showloader();
//            page = noOfRecords * (page - 1);
//            Data.post('cloudcallinglogs/filteredData', {filterData: data, getProcName: $scope.getProcName, pageNumber: page, itemPerPage: noOfRecords, isTeamType: $scope.type}).then(function (response) {
//                if (response.success)
//                {
//                    $scope.listUsers = response.records.data;
//                    $scope.listUsersLength = response.totalCount;
//
//                } else
//                {
//                    $scope.listUsers = '';
//                    $scope.listUsersLength = 0;
//                }
//                $('#showFilterModal').modal('hide');
//                $scope.showFilterData = $scope.filterData;
//                $scope.hideloader();
//                $scope.flagForChange = 0;
//                return false;
//
//            });
//        }

        $scope.removeDataFromFilter = function (keyvalue)
        {
            delete $scope.filterData[keyvalue];
            $scope.filteredData($scope.filterData, 1, 30);
        }

        $scope.manageQuickUsers = function () {
            $scope.userData.personal_mobile1_calling_code = '+91';
            $scope.userData.office_mobile_calling_code = '+91';
            $scope.userData.personal_mobile1 = '';
            $scope.userData.office_mobile_no = '';
        }

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

//        $scope.changePassword = function (id, username) {
//
//            Data.post('master-hr/changePassword', {
//                empId: id, username: username
//            }).then(function (response) {
//                if (response.success) {
//                    $("#myModal").modal("toggle");
//                    $scope.successMsg = response.message;
//                } else {
//                    $scope.errorMsg = response.message;
//                }
//            });
//        }

        $scope.wrongpwd = false;
        $scope.changePassword = function (adata) {
            Data.post('master-hr/changePassword', {
                data: adata,
            }).then(function (response) {
                if (response.success) {
                    $scope.successMsg = response.message;
                    $scope.wrongpwd = false;
                    $scope.step1 = false;
                    $("#passwordClosebtn").trigger('click');
                } else {
                    $scope.errorMsg = response.message;
                    $scope.wrongpwd = true;
                }
            });
        }

//        $scope.userPermissions = function (moduleType, id) {
//            Data.post('master-hr/getMenuLists', {
//                data: {id: id, moduleType: moduleType},
//            }).then(function (response) {
//                if (response.success) {
//                    $scope.menuItems = response.getMenu;
//                    $scope.totalPermissions = response.totalPermissions;
//                } else {
//                    $scope.errorMsg = response.message;
//                }
//            });
//        }


        $scope.userPermissions = function (moduleType, id) {
            if (id == '0') {
                var getData = {moduleType: moduleType};
            } else {
                var getData = {id: id, moduleType: moduleType}
            }
            Data.post('master-hr/getMenuLists', {
                data: getData,
            }).then(function (response) {
                if (response.success) {
                    $scope.menuItems = response.getMenu;
                    var array = $.map(response.menuId, function (value, index) {
                        return [value];
                    });
                    $rootScope.menuId = array;

                    $scope.totalPermissions = response.totalPermissions;
                    $scope.empName = response.empName;
                    $scope.role_name = response.role_name;
                } else {
                    $scope.errorMsg = response.message;
                }
            });
        }

        /*$scope.userPermissions = function (moduleType, id) {
         Data.post('master-hr/getMenuLists', {
         data: {id: id, moduleType: moduleType},
         }).then(function (response) {
         if (response.success) {
         $scope.menuItems = response.getMenu;
         $scope.totalPermissions = response.totalPermissions;
         } else {
         $scope.errorMsg = response.message;
         }
         });
         }*/
        $scope.showPermissions = function () { //permission wise employees

            Data.get('master-hr/getMenuListsForEmployee').then(function (response) {
                if (response.success) {
                    $scope.menuItems = response.getMenu;
                } else {
                    $scope.errorMsg = response.message;
                }
            });
        }
        $scope.removeEmpID = function (empId, parentId, submenuId, allChild2Id, allChild3Id) {

            Data.post('master-hr/removeEmpID',
                    {empId: empId, parentId: parentId, submenuId: submenuId, allChild2Id: allChild2Id, allChild3Id: allChild3Id}).then(function (response) {
                if (!response.success) {
                    toaster.pop('error', '', 'Something went wrong');
                } else {
                    toaster.pop('success', '', 'Employee removed successfully');
                }
            });
        }

        $scope.updatePermissions = function (empId, roleId) {
            Data.post('master-hr/updatePermissions', {
                data: {empId: empId, roleId: roleId},
            }).then(function (response) {
                if (response.success) {
                    $scope.menuItems = response.employeeSubmenus;

                } else {
                    $scope.errorMsg = response.message;
                }
            });
            $state.transitionTo($state.current, $stateParams, {
                reload: true, //reload current page
                inherit: false, //if set to true, the previous param values are inherited
                notify: true //reinitialise object
            });
        }

        $scope.accessControl = function (moduleType, empId, checkboxid, parentId, submenuId, allChild2Id, allChild3Id) {
            var isChecked = $("#" + checkboxid).prop("checked");
            var obj = $("#" + checkboxid);
            var level = $("#" + checkboxid).attr("data-level");
//            console.log(submenuId);
            if (isChecked)
            {
                if (level === "first") {
                    $(obj.parent().parent().find('input[type=checkbox][data-level="second"], input[type=checkbox][data-level="third"]')).prop('checked', true);
                    $(obj.parent().parent().find('input[type=checkbox][data-level="second"],input[type=checkbox][data-level="third"]')).each(function () {
                        var str = $(this).attr('id');
                        var afterUnderscore = str.substr(str.indexOf("_") + 1);
                        submenuId.push(parseInt(afterUnderscore));
                        $scope.parentId = parentId;

                    });
                } else if (level === "second") {
                    var flag = [];
                    $($(obj.parent().parent().parent().find('li input[type=checkbox][data-level="second"]'))).each(function () {//for loop thr' data-level second, check if all data-level=second checkbox is checked then check data-level=first checkbox
                        if ($(this).is(':checked'))
                            flag.push(true);
                        else
                            flag.push(false);
                    });
                    if ($.inArray(false, flag) === 1)
                        $(obj.parent().parent().parent().parent().find('input[type=checkbox][data-level="first"]')).prop('checked', true);
                    if ($.inArray(false, flag) === -1)
                        $(obj.parent().parent().parent().parent().find('input[type=checkbox][data-level="first"]')).prop('checked', true);

                    $(obj.parent().parent().find('input[type=checkbox][data-level="third"]')).prop('checked', true);
                    $(obj.parent().parent().find('input[type=checkbox][data-level="third"]')).each(function () {
                        var str = $(this).attr('id');
                        var afterUnderscore = str.substr(str.indexOf("_") + 1);
                        submenuId.push(parseInt(afterUnderscore));
                    });
                    $scope.parentId = parentId;
//                    if ($.inArray(true, flag) === -1) {
//                        $scope.parentId = parentId;
//                        console.log(parentId);
//                    } else {
//                        $scope.parentId[0] = parentId[1];
//                        console.log($scope.parentId);
//                    }
//                    
//                     console.log(parentId);
//                    console.log(submenuId);
                } else if (level === "third") {
                    var flag = [];
                    $($(obj.parent().parent().parent().find('li input[type=checkbox][data-level="third"]'))).each(function () {
                        if ($(this).is(':checked'))
                            flag.push(true);
                        else
                            flag.push(false);
                    });
//                   
//                    if ($.inArray(false, flag) === 1)
//                        $(obj.parent().parent().parent().parent().find('input[type=checkbox][data-level="second"]')).prop('checked', true);
//                        $(obj.parent().parent().parent().parent().parent().find('input[type=checkbox][data-level="first"]')).prop('checked', true);
                    if ($.inArray(false, flag) === -1)
                        $(obj.parent().parent().parent().parent().find('input[type=checkbox][data-level="second"]')).prop('checked', true);
                    $scope.parentId = parentId;
                }
            } else
            {
                if (level === "first") {
                    $(obj.parent().parent().find('input[type=checkbox][data-level="second"]')).prop('checked', false);
                    $(obj.parent().parent().find('input[type=checkbox][data-level="third"]')).prop('checked', false);

                    $(obj.parent().parent().find('input[type=checkbox][data-level="second"]')).each(function () {
                        var str = $(this).attr('id');
                        var afterUnderscore = str.substr(str.indexOf("_") + 1);
                        submenuId.push(parseInt(afterUnderscore));

                    });
                    $(obj.parent().parent().find('input[type=checkbox][data-level="third"]')).each(function () {
                        var str = $(this).attr('id');
                        var afterUnderscore = str.substr(str.indexOf("_") + 1);
                        submenuId.push(parseInt(afterUnderscore));

                    });
                    $scope.parentId = parentId;


                } else if (level === "second") {
                    var flag = [];
                    $($(obj.parent().parent().parent().find('li input[type=checkbox][data-level="second"]'))).each(function () {
                        if ($(this).is(':checked'))
                            flag.push(true);
                        else
                            flag.push(false);
                    });

                    if ($.inArray(true, flag) === -1)
                        $(obj.parent().parent().parent().parent().find('input[type=checkbox][data-level="first"]')).prop('checked', false);

                    $(obj.parent().parent().find('input[type=checkbox][data-level="third"]')).prop('checked', false);
                    $(obj.parent().find('input[type=checkbox][data-level="third"]')).each(function () {
                        var str = $(this).attr('id');
                        var afterUnderscore = str.substr(str.indexOf("_") + 1);
                        submenuId.push(parseInt(afterUnderscore));

                    });

                    if ($.inArray(true, flag) === -1) {
                        $scope.parentId = parentId;
                    } else {
                        $scope.parentId[0] = parentId[1];
                    }


                } else if (level === "third") {
                    var flag = [];
                    $($(obj.parent().parent().parent().find('li input[type=checkbox][data-level="third"]'))).each(function () {
                        if ($(this).is(':checked'))
                            flag.push(true);
                        else
                            flag.push(false);
                    });
                    if ($.inArray(true, flag) === -1)
                        $(obj.parent().parent().parent().parent().find('input[type=checkbox][data-level="second"]')).prop('checked', false);


                    if ($.inArray(true, flag) === -1) {
                        $scope.parentId[0] = parentId[1];
                    } else {
                        $scope.parentId[0] = '';
                    }

                }

            }
            Data.post('master-hr/accessControl', {
                data: {empId: empId, parentId: $scope.parentId, submenuId: submenuId, isChecked: isChecked, moduleType: moduleType, allChild2Id: allChild2Id, allChild3Id: allChild3Id}
            }).then(function (response) {
                if (response) {
                    $scope.totalPermissions = response.totalPermissions;
                } else {
                    $scope.errorMsg = response.message;
                }
            });
        }
        /****************** Roles *********************/
        $scope.manageRoles = function () {
            Data.get('master-hr/getRoles').then(function (response) {
                if (response.success) {
                    $scope.roleList = response.list;
                } else {
                    $scope.errorMsg = response.message;
                }
            });
        }

        $scope.createRole = function (RoleData) {
            Data.post('master-hr/createUserRole', {
                data: {role_name: RoleData.role_name, masterRole: $rootScope.roleMenuList.menuId}
            }).then(function (response) {
                if (response.success) {
                    toaster.pop('success', 'Role permissions', 'Record created successfully');
                    $state.go('manageRoles');
                } else {
                    toaster.pop('error', 'Create Role', 'something wrong');
                }
            });
        }
        $scope.updateRole = function (RoleData, roleId, role_name) {
            Data.post('master-hr/updateUserRole', {
                data: {roleId: roleId, masterRole: $rootScope.roleMenuList.menuId, role_name: role_name}
            }).then(function (response) {
                if (response.success) {
                    toaster.pop('success', 'Role Permissions', 'Record updated successfully');
                    $state.go('manageRoles');
                } else {
                    toaster.pop('error', 'Create Role', 'something wrong');
                }
            });
        }

        $scope.addRolePermissions = function (moduleType, checkboxid, parentId, submenuId) {

            var isChecked = $("#" + checkboxid).prop("checked");
            var obj = $("#" + checkboxid);
            var level = $("#" + checkboxid).attr("data-level");

            if (isChecked) {
                $scope.totalPermissions = $scope.totalPermissions + 1;
                if (level === "first") {
                    $(obj.parent().parent().find('input[type=checkbox][data-level="second"], input[type=checkbox][data-level="third"]')).prop('checked', true);
                    $(obj.parent().parent().find('input[type=checkbox][data-level="second"],input[type=checkbox][data-level="third"]')).each(function () {
                        var str = $(this).attr('id');
                        var afterUnderscore = str.substr(str.indexOf("_") + 1);
                        submenuId.push(parseInt(afterUnderscore));
                    });
                } else if (level === "second") {
                    var flag = [];
                    $($(obj.parent().parent().parent().find('li input[type=checkbox][data-level="second"]'))).each(function () {//for loop thr' data-level second, check if all data-level=second checkbox is checked then check data-level=first checkbox
                        if ($(this).is(':checked'))
                            flag.push(true);
                        else
                            flag.push(false);
                    });
                    if ($.inArray(false, flag) === -1)
                        $(obj.parent().parent().parent().parent().find('input[type=checkbox][data-level="first"]')).prop('checked', true);

                    $(obj.parent().parent().find('input[type=checkbox][data-level="third"]')).prop('checked', true);
                    $(obj.parent().parent().find('input[type=checkbox][data-level="third"]')).each(function () {
                        var str = $(this).attr('id');
                        var afterUnderscore = str.substr(str.indexOf("_") + 1);
                        submenuId.push(parseInt(afterUnderscore));
                    });
                } else if (level === "third") {
                    var flag = [];
                    $($(obj.parent().parent().parent().find('li input[type=checkbox][data-level="third"]'))).each(function () {
                        if ($(this).is(':checked'))
                            flag.push(true);
                        else
                            flag.push(false);
                    });
                    if ($.inArray(false, flag) === -1)
                        $(obj.parent().parent().parent().parent().find('input[type=checkbox][data-level="second"]')).prop('checked', true);
                }

                if (parentId.length > 0) {
                    parentId.map(function (num) {
                        var digit = num.toString()[0];
                        if (digit !== 0) {
                            num = '0' + num;
                        }
                        $rootScope.menuId.push(num);
                    });
                } else {
                    var digit = parentId.toString()[0];
                    if (digit !== 0) {
                        parentId = '0' + parentId;
                    }
                    $rootScope.menuId.push(parentId[0]);
                }
                if (submenuId.length > 0) {
                    submenuId.map(function (num) {
                        var digit = num.toString()[0];
                        if (digit !== 0) {
                            num = '0' + num;
                        }
                        $rootScope.menuId.push(num);
                    });
                } else {
                    var digit = submenuId.toString()[0];
                    if (digit !== 0) {
                        submenuId = '0' + submenuId;
                    }
                    $rootScope.menuId.push(submenuId[0]);
                }
            } else {
                $scope.totalPermissions = $scope.totalPermissions - 1;
                if (level === "first") {
                    $(obj.parent().parent().find('input[type=checkbox][data-level="second"]')).prop('checked', false);
                    $(obj.parent().parent().find('input[type=checkbox][data-level="third"]')).prop('checked', false);
                    $(obj.parent().parent().find('input[type=checkbox][data-level="second"]')).each(function () {
                        var str = $(this).attr('id');
                        var afterUnderscore = str.substr(str.indexOf("_") + 1);
                        submenuId.push(parseInt(afterUnderscore));

                    });
                    $(obj.parent().parent().find('input[type=checkbox][data-level="third"]')).each(function () {
                        var str = $(this).attr('id');
                        var afterUnderscore = str.substr(str.indexOf("_") + 1);
                        submenuId.push(parseInt(afterUnderscore));
                    });
                } else if (level === "second") {
                    var flag = [];
                    $($(obj.parent().parent().parent().find('li input[type=checkbox][data-level="second"]'))).each(function () {
                        if ($(this).is(':checked'))
                            flag.push(true);
                        else
                            flag.push(false);
                    });
                    if ($.inArray(true, flag) === -1)
                        $(obj.parent().parent().parent().parent().find('input[type=checkbox][data-level="first"]')).prop('checked', false);

                    $(obj.parent().parent().find('input[type=checkbox][data-level="third"]')).prop('checked', false);
                    $(obj.parent().find('input[type=checkbox][data-level="third"]')).each(function () {
                        var str = $(this).attr('id');
                        var afterUnderscore = str.substr(str.indexOf("_") + 1);
                        submenuId.push(parseInt(afterUnderscore));
                    });
                } else if (level === "third") {
                    var flag = [];
                    $($(obj.parent().parent().parent().find('li input[type=checkbox][data-level="third"]'))).each(function () {
                        if ($(this).is(':checked'))
                            flag.push(true);
                        else
                            flag.push(false);
                    });
                    if ($.inArray(true, flag) === -1)
                        $(obj.parent().parent().parent().parent().find('input[type=checkbox][data-level="second"]')).prop('checked', false);
                }

                if (submenuId.length == 1) {
                    var digit = submenuId.toString()[0];
                    if (digit !== 0) {
                        $rootScope.menuId.splice($rootScope.menuId.indexOf(0 + submenuId), 1);
                    } else
                        $rootScope.menuId.splice($rootScope.menuId.indexOf(submenuId), 1);
                } else {
                    submenuId.map(function (num) {
                        var digit = num.toString()[0];
                        if (digit !== 0) {
                            num = '0' + num;
                        }
                        position = $.inArray(num, $rootScope.menuId);
                        if (position != -1) {
                            $rootScope.menuId.splice(position, 1);
                        }
                    });
                    parentIdPosition = $.inArray(parentId[0], $rootScope.menuId);
                    $rootScope.menuId.splice(parentIdPosition, 1);
                }
            }
            $rootScope.menuId = $rootScope.menuId.filter(function (item, index, inputArray) {

                return inputArray.indexOf(item) == index;
            });
            $rootScope.roleMenuList = {menuId: $rootScope.menuId};
        }
        /****************** Roles *********************/
        /****************** Organization Chart *********************/
        $scope.showchartdata = function () {
            google.charts.load('current', {packages: ["orgchart"]});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Name');
                data.addColumn('string', 'Manager');
                data.addColumn('string', 'ToolTip');
                Data.get('master-hr/getChartData', {
                    data: {},
                    async: false,
                }).then(function (response) {
                    var arr = new Array();
                    var datalength = Object.keys(response).length;
                    for (var i = 0; i < datalength; i++)
                    {
                        arr.push([{v: "'" + response[i]['v'] + "'", f: response[i]['f']}, "'" + response[i]['teamId'] + "'", response[i]['designation_id']]);
                    }
                    data.addRows(arr);
                    // Create the chart.
                    var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
                    // Draw the chart, setting the allowHtml option to true for the tooltips.
                    chart.draw(data, {allowHtml: true});
                });
            }
        }
        /****************** Organization Chart *********************/

        /****************** Rohit *********************/
//        $scope.getProfile = function () {
//            Data.post('master-hr/getProfileInfo').then(function (response) {
//                console.log(response);
//                $scope.passwordValidation = false;
//                $scope.profileData = response.records;
//                $scope.profileData.employee_photo_file_name = '';
//                $scope.password_confirmation;
//                $scope.flagProfilePhoto = response.flagProfilePhoto;
//                $scope.profilePhoto = response.profilePhoto;
//            });
//        }

        $scope.getProfile = function () {

            Data.post('master-hr/getProfileInfo',
                    {

                    })
                    .then(function (response) {
                        $scope.profileData = response.records;
                        $scope.profileData.employee_photo_file_name = '';
                        $scope.password_confirmation;
                        $scope.flag_profile_photo = response.flag_profile_photo;
                        $scope.old_profile_photo = response.old_profile_photo;
                    });


        }

        $scope.updateProfile = function (profileData)
        {
            if (typeof profileData.employee_photo_file_name == "undefined" || typeof profileData.employee_photo_file_name == "string") {
                profileData.employee_photo_file_name = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            }
            var url = '/master-hr/updateProfileInfo';
            var data = {data: profileData};

            profileData.employee_photo_file_name.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            })
            profileData.employee_photo_file_name.upload.then(function (response)
            {

                if (response.success == false) {
                    toaster.pop('error', 'Profile', 'Please upload profile photo');
                } else {
                    $rootScope.imageUrl = response.data.photo;
                    toaster.pop('success', 'Profile', 'Profile updated successfully');
                }
            });

        }

        $scope.updatePassword = function (profileData)
        {
            Data.post('master-hr/updatePassword', {
                data: profileData,
            }).then(function (response) {
                if (!response.success) {
                    toaster.pop('error', 'Profile', 'Something went wrong please try again later');
                } else
                {
                    toaster.pop('success', 'Profile', 'Password has been changed as well as Mail and sms has been sent to you.');
                    $state.go('dashboard');
                }
            });

        }

        $scope.changePasswordFlagFun = function (changePasswordflag)
        {
            $scope.profileData.oldPassword = "";
            $scope.profileData.password = "";
            $scope.profileData.password_confirmation = "";

            if (changePasswordflag == true)
                $scope.passwordValidation = true;
            else
                $scope.passwordValidation = false;
        }

        $scope.quickEmployee = function (quickEmp)
        {
            var date = new Date(quickEmp.joining_date);
            quickEmp.joining_date = (date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
            $scope.isDisabled = true;
            Data.post('master-hr/createquickuser',
                    {
                        data: quickEmp
                    })
                    .then(function (response)
                    {

                        if (!response.success)
                        {
                            $scope.isDisabled = false;
                            var obj = response.message;
                            var selector = [];
                            for (var key in obj) {
                                var model = $parse(key);// Get the model
                                model.assign($scope, obj[key][0]);// Assigns a value to it
                                selector.push(key);
                            }
                            toaster.pop('error', 'Manage Users', 'Something went wrong. try again later');

                            $scope.errorMsg = response.errormsg;
                        } else
                        {
                            $scope.isDisabled = true;
                            toaster.pop('success', 'Manage Users', 'Employee registration successfully');
                            $state.go('userIndex');
                        }
                    });
        };


        /****************** archana *********************/

        $scope.changePermanentAddress = function () {

            var copyContent = $("#copyContent").is(":checked");

            if (copyContent) {
                $scope.userContact.permenent_address = angular.copy($scope.userContact.current_address);
                $scope.userContact.permenent_country_id = angular.copy($scope.userContact.current_country_id);
                $scope.userContact.permenent_pin = angular.copy($scope.userContact.current_pin);

                Data.post('getStates', {
                    data: {countryId: $scope.userContact.current_country_id},
                }).then(function (response) {
                    if (!response.success) {
                        $scope.errorMsg = response.message;
                    } else {
                        $scope.stateTwoList = response.records;
                        Data.post('getCities', {
                            data: {stateId: $scope.userContact.current_state_id},
                        }).then(function (response) {
                            if (!response.success) {
                                $scope.errorMsg = response.message;
                            } else {
                                $scope.cityTwoList = response.records;
                            }
                            $timeout(function () {
                                // $("#permenent_state_id").val($scope.userContact.current_state_id);
                                // $("#permenent_city_id").val($scope.userContact.current_city_id);
                                $scope.userContact.permenent_state_id = $scope.userContact.current_state_id;
                                $scope.userContact.permenent_city_id = $scope.userContact.current_city_id;
                            }, 500);
                        });
                    }
                });
            }

        }

        $scope.openDatepicker = function ($event) {
            $event.preventDefault();
            $event.stopPropagation();
            $scope.opened = true;
            var date_of_birth = ($scope.maxDates.getFullYear() + '-' + ("0" + ($scope.maxDates.getMonth() + 1)).slice(-2) + '-' + $scope.maxDates.getDate());
            $scope.userData.birth_date = date_of_birth;

        };

        $scope.createEducationForm = function (userEducation, employee_photo_file_name, emp_id)
        {

            userEducation = angular.fromJson(angular.toJson(userEducation));
            if (emp_id > 0) {
                emp_id = emp_id;
                $scope.steps.highest_education_id = '1';
            } else {
                emp_id = $rootScope.employeeId;
            }

            //console.log(userEducation);
            if (typeof employee_photo_file_name == "undefined" || typeof employee_photo_file_name == "string") {
                employee_photo_file_name = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            }
            var url = 'master-hr/createEducationForm';
            var data = {userEducation: userEducation, employeeId: emp_id, employee_photo_file_name: employee_photo_file_name};
            var successMsg = "Record successfully created.";
            employee_photo_file_name.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            employee_photo_file_name.upload.then(function (response) {

                // console.log(response);
                $("#wiredstep4").addClass('active');
                $("#wiredstep3").addClass('ng-hide');
                $("#wiredstep3").removeClass('active');
                $("#wiredstep4").removeClass('ng-hide');
                $("#wiredstep3").css('display', 'none');
                $("#wiredstep4").css('display', 'block');
                $(".wiredstep4").removeClass('complete');

                $(".wiredstep4").addClass("active");
                $(".wiredstep3").removeClass("active");
                $(".wiredstep3").addClass('complete');

                if (emp_id > 0) {
                    toaster.pop('success', 'Employee Details', "Educational & Other Details Updated Successfully");
                } else {
                    toaster.pop('success', 'Employee Details', "Educational & Other Details Saved Successfully");
                }

            }, function (response) {
                if (response.status !== 200) {
                    $scope.errorMsg = "Something went wrong.";
                }
            }, function (evt, response) {
                //employeePhoto.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            });
        }
        $scope.createContactForm = function (userContact, empId) {

            if (empId > 0) {
                empId = empId;
                $scope.steps.personal_email1 = 1;
            } else {
                empId = $rootScope.employeeId;
            }

            userContact = angular.fromJson(angular.toJson(userContact));
            Data.post('master-hr/manageContact', {
                userContact: userContact, employeeId: empId
            }).then(function (response) {
                //console.log(response);
                $("#wiredstep3").addClass('active');
                $("#wiredstep2").addClass('ng-hide');
                $("#wiredstep2").removeClass('active');
                $("#wiredstep3").removeClass('ng-hide');
                $("#wiredstep2").css('display', 'none');
                $("#wiredstep3").css('display', 'block');
                $(".wiredstep3").removeClass('complete');
                $(".wiredstep3").addClass('active');
                $(".wiredstep2").addClass('complete');
                $(".wiredstep3").removeClass('complete');
                $(".wiredstep2").removeClass('active');

                if ($scope.userContact.personal_mobile1 == 'null' || $scope.userContact.personal_mobile1 == '' || $scope.userContact.personal_mobile1 == 0)
                {
                    $scope.userStatus.username = $scope.userContact.office_mobile_no;
                } else
                {
                    $scope.userStatus.username = $scope.userContact.personal_mobile1;
                }

                if (empId > 0) {
                    toaster.pop('success', 'Employee Details', "Contact Information Updated Successfully");
                } else {
                    toaster.pop('success', 'Employee Details', "Personal Information Saved Successfully");
                }


            });
        }


        $scope.createJobForm = function (userJobData, empId) {

            if (empId > 0) {
                empId = empId;
                $scope.steps.deptId = '1';
            } else {
                empId = $rootScope.employeeId;
            }

            var date = new Date(userJobData.joining_date);
            userJobData.joining_date = (date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
            userJobData = angular.fromJson(angular.toJson(userJobData));
            Data.post('master-hr/manageJobForm', {
                userJobData: userJobData, employeeId: empId
            }).then(function (response) {

                $("#wiredstep5").addClass('active');
                $("#wiredstep4").addClass('ng-hide');
                $("#wiredstep4").removeClass('active');
                $("#wiredstep5").removeClass('ng-hide');
                $("#wiredstep4").css('display', 'none');
                $("#wiredstep5").css('display', 'block');
                $(".wiredstep5").addClass("active");
                $(".wiredstep4").removeClass("active");
                $(".wiredstep4").addClass('complete');


                if (empId > 0) {
                    toaster.pop('success', 'Employee Details', "Educational & Other Details Updated Successfully");

                } else {
                    toaster.pop('success', 'Employee Details', "Educational & Other Details Saved Successfully");
                }
            });
        }




        $scope.previous = function (pre, current)
        {
            $("#wiredstep" + pre).addClass('active');
            $("#wiredstep" + current).addClass('ng-hide');
            $("#wiredstep" + current).removeClass('active');
            $("#wiredstep" + pre).removeClass('ng-hide');
            $("#wiredstep" + current).css('display', 'none');
            $("#wiredstep" + pre).css('display', 'block');
            $(".wiredstep" + pre).addClass('active');
            $(".wiredstep" + current).removeClass('active');
            $(".wiredstep" + pre).removeClass('complete');
            $(".wiredstep" + current).addClass('complete');

            if (pre == 1) {
                if ($scope.userPersonalData.birth_date == '0000-00-00' || $scope.userPersonalData.birth_date == 'NaN-aN-NaN') {
                    $scope.userPersonalData.birth_date = '';
                }
                if ($scope.userData.birth_date === null)
                {
                    $scope.userData.birth_date = new Date();
                }

                if ($scope.userPersonalData.marriage_date == '0000-00-00' || $scope.userPersonalData.marriage_date == 'NaN-aN-NaN') {
                    $scope.userPersonalData.marriage_date = '';
                }
                if ($scope.userData.marriage_date === null)
                {
                    $scope.userData.marriage_date = new Date();
                }
            }
            if (pre == 4) {
                if ($scope.userJobData.joining_date == '0000-00-00' || $scope.userJobData.joining_date == 'NaN-aN-NaN') {
                    $scope.userJobData.joining_date = '';
                }
            }
        }

        $scope.createEmp = function ()
        {
            var variable = null;
            $scope.userData.date_of_birth = variable;

        }


        $scope.createStatusForm = function (userStatus, empId)
        {
            if (empId > 0) {
                empId = empId;
                $scope.steps.username = '1';
            } else {
                empId = $rootScope.employeeId;
            }
            var createStatus = $("#employeeId").val();
            userStatus = angular.fromJson(angular.toJson(userStatus));
            Data.post('master-hr/manageStatusForm', {
                userStatus: userStatus, employeeId: empId, createStatus: createStatus
            }).then(function (response) {
                if (empId > 0) {
                    toaster.pop('success', 'Employee Details', "Employee Status Details Updated Successfully");
                } else {
                    toaster.pop('success', 'Employee Details', "Employee Status Details Saved Successfully");
                }
                $(".btn-submit-last").attr('disabled', true);
                $state.go('userIndex');
            });
        }

        $scope.checkEmployeeId = function (employee_id) {
            var emp_id = $("#employeeId").val();
            var employeeId = (typeof emp_id === "undefined" || emp_id === "0") ? "0" : emp_id;
            return Data.post('checkUniqueEmployeeId', {
                data: {employee_id: employee_id, id: employeeId},
            }).then(function (response) {
                if (response.success) {
                    $scope.errEmployeeId = "";
                    $scope.applyClassEmployeeId = 'ng-inactive';
                } else {
                    $scope.errEmployeeId = "Employee Id already exists";
                    $scope.applyClassEmployeeId = 'ng-active';
                    $scope.userStatusForm.$valid = false;
                }
            });
        };
//        $scope.getEmpId = function (empId)
//        {
//            if (empId != 0) {
//                $scope.userId = empId;
//            } else {
//                Data.get('master-hr/getEmpId').then(function (response) {
//                    $scope.userData.employee_id = response;
//                });
//            }
//        }
        $scope.getStepDiv = function (stepId, steps, uniqueId, classCheck)
        {
            if (classCheck == 1) {
                if (uniqueId == 1) {
                    $("#wiredstep1").addClass('ng-hide');
                    $("#wiredstep2").addClass('ng-hide');
                    $("#wiredstep3").addClass('ng-hide');
                    $("#wiredstep4").addClass('ng-hide');
                    $("#wiredstep5").addClass('ng-hide');
                    $(".wiredstep1").removeClass('active');
                    $(".wiredstep2").removeClass('active');
                    $(".wiredstep3").removeClass('active');
                    $(".wiredstep4").removeClass('active');
                    $(".wiredstep5").removeClass('active');

                    if (steps.first_name == 1) {
                        $(".wiredstep1").addClass('complete');
                    }
                    if (steps.personal_email1 == 1) {
                        $(".wiredstep2").addClass('complete');
                    }
                    if (steps.highest_education_id == 1) {
                        $(".wiredstep3").addClass('complete');
                    }
                    if (steps.deptId == 1) {
                        $(".wiredstep4").addClass('complete');
                    }
                    if (steps.show_on_homepage == 1) {
                        $(".wiredstep5").addClass('complete');
                    }

                    $(".wiredstep" + stepId).addClass('active');
                    $(".wiredstep" + stepId).removeClass('complete');
                    $("#wiredstep" + stepId).css('display', 'block');
                    $("#wiredstep" + stepId).removeClass('ng-hide');


                } else {
                    $scope.position = 1;
                    angular.forEach(steps, function (key, value) {
                        $scope.position = key + $scope.position;
                    });
                    if ($scope.position == 6) {
                        $scope.position = 5;
                    }
//                alert(".wiredstep" + $scope.position);
//                classs = ".wiredstep" + $scope.position;
                    $("#wiredstep" + $scope.position).removeClass('ng-hide');
                    $("#wiredstep" + $scope.position).css('display', 'block');
//                $(classs).addClass('active');
                    $(".wiredstep" + $scope.position).removeClass('complete');

                }
            }
        }

        $scope.manageOtherPermission = function (permission, employee_id) {
            Data.post('master-hr/manageOtherPermission', {data: permission, employee_id: employee_id})
                    .then(function (response)
                    {
                        console.log(response)
                    });
        };
        $scope.getOtherPermission = function (employee_id) {
            $scope.permission = {};
            Data.post('master-hr/getOtherPermission', {employee_id: employee_id})
                    .then(function (response)
                    {
                        $scope.customer_contact_number = response.result.customer_contact_number;
                        $scope.customer_email = response.result.customer_email;
                    });
        };
    }]);

app.controller('teamLeadCtrl', function ($scope, Data) {
    $scope.teamLeads = [];
    Data.get('master-hr/getTeamLead/' + $("#empId").val()).then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.teamLeads = response.records;
        }
    });
});

app.controller('teamLeadCtrlforQuick', function ($scope, Data) {
    $scope.teamLeads = [];
    Data.get('master-hr/getTeamLeadForQuick/').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.teamLeadsforQuick = response.records;

        }
    });
});

app.directive("limitTo", [function () {
        return {
            restrict: "A",
            link: function (scope, elem, attrs) {
                var limit = parseInt(attrs.limitTo);
                angular.element(elem).on("keypress", function (e) {

                    if (this.value.length == limit)
                        e.preventDefault();
                });
            }
        }
    }]);
app.filter('highlight', function () {

    function escapeRegexp(queryToEscape) {

        return queryToEscape.replace('/([.?*+^$[\]\\(){}|-])/g', '\\$1');
    }

    return function (obj, query) {
        return query && obj ? obj.toString().replace(new RegExp(escapeRegexp(query), 'gi'), '<span class="ui-select-highlight">$&</span>') : obj;
    };
});
app.filter('split', function () {
    return function (input, splitChar, splitIndex) {
        // do some bounds checking here to ensure it has that index
        return input.split(splitChar)[splitIndex];
    }
});