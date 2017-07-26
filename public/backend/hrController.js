app.controller('hrController', ['$rootScope', '$scope', '$state', 'Data', 'Upload', '$timeout', '$parse', '$stateParams', 'toaster', function ($rootScope, $scope, $state, Data, Upload, $timeout, $parse, $stateParams, toaster) {
        $scope.pageHeading = 'Create User';
        $scope.buttonLabel = 'Create';
        $scope.userData = {};
        $scope.roleData = {};
        $scope.listUsers = [];
        $scope.userData.department_id = [];
        $scope.userData.gender_id = $scope.userData.title_id = $scope.userData.blood_group_id =
                $scope.userData.physic_status = $scope.userData.marital_status = $scope.userData.highest_education_id =
                $scope.userData.current_state_id = $scope.userData.current_city_id =
                $scope.userData.permenent_state_id = $scope.userData.permenent_city_id = "";
        $scope.userData.employee_status = "1";
        $scope.userData.personal_mobile1 = $scope.userData.office_mobile_no = $scope.userData.personal_mobile2 = $scope.userData.personal_landline_no = "+91-";
        $scope.disableCreateButton = false;
        $scope.currentPage = $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $rootScope.imageURL = "";
        $scope.userData.high_security_password_type = 0;
        $scope.userData.current_country_id = $scope.userData.permenent_country_id = 101;
        var date = new Date($scope.userData.date_of_birth);
        $scope.userData.date_of_birth = ((date.getFullYear() - 100) + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
        $scope.userData.date_of_birth = ("1990-01-01");

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
            var regex = /^(\+\d{1,4}-\d{1,4})\d{6}$/;
            if (!regex.test(value)) {
                $scope.errLandline = "Landline number should be 12 digits and pattern should be for ex. +91-1234999999";
                $scope.applyClass = 'ng-active';
            } else {
                $scope.errLandline = "";
                $scope.applyClass = 'ng-inactive';
            }
        };
        $scope.checkDepartment = function () {
            if ($scope.userData.department_id.length === 0) {
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
                    $scope.altName = employeePhoto.name;
                } else {
                    $(".imageFile").val("");
                    $scope.invalidImage = "Invalid file format. Image should be jpg or jpeg or png or bmp format only.";
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
        $scope.getStepDiv = function (stepId, empId)
        {
            $scope.stepId = stepId;
            if (empId != 0) {
                $(".user_steps").each(function (index) {
                    $(this).addClass('complete');
                    $(this).removeClass('active')
                });
                $(".wizardstep" + stepId).addClass('active');
                $(".wizardstep" + stepId).removeClass('complete');

                $(".step-pane").css('display', 'none');
                $("#wizardstep" + stepId).css('display', 'block');
            } else {
                if (stepId == 1)
                {
                    $scope.stepId = 1;
                    $("#wizardstep1").css('display', 'block');
                    $("#wizardstep1").addClass('active');
                }
            }
        }

        $scope.createUser = function (enteredData, employeePhoto, empId) {
            var userData = {};
            userData = angular.fromJson(angular.toJson(enteredData));
            var date = new Date($scope.userData.date_of_birth);
            $scope.userData.date_of_birth = ((date.getFullYear() - 100) + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
            alert($scope.userData.date_of_birth);

            var date = new Date($scope.userData.joining_date);
            $scope.userData.joining_date = (date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());

            if (empId === 0)
            {
                var url = '/master-hr/';
                var data = {userData: userData, employee_photo_file_name: employeePhoto, empId: empId};
                var successMsg = "Record created successfully.";
            } else {
                var url = '/master-hr/' + empId;
                var successMsg = "Record updated successfully.";
                if (typeof employeePhoto === 'string') {
                    employeePhoto = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
                }
                var data = {_method: 'PUT', userData: userData, employee_photo_file_name: employeePhoto, empId: empId};
            }

            employeePhoto.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            employeePhoto.upload.then(function (response) {
                $timeout(function () {
                    if (!response.data.success) {
                        var obj = response.data.message;
                        $('.errMsg').text('');
                        for (var key in obj) {
                            var model = $parse(key);// Get the model
                            model.assign($scope, obj[key][0]);// Assigns a value to it
                        }
                    } else {
                        $scope.disableCreateButton = true;
                        employeePhoto.result = response.data;
                        toaster.pop('success', 'Employee Details', successMsg);
                        $timeout(function () {
                            $state.go('userIndex');
                        }, 1000);
                    }
                });
            }, function (response) {
                if (response.status !== 200) {
                    $scope.errorMsg = "Something went wrong.";
                }
            }, function (evt, response) {
                //employeePhoto.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            });
        };

        $scope.manageUsers = function (id, action) { //edit/index action
            $scope.modal = {};
            Data.post('master-hr/manageUsers', {
                empId: id,
            }).then(function (response) {
                if (response.success) {
                    if (action === 'index') {
                        $scope.listUsers = response.records.data;
                        $scope.listUsersLength = response.records.total;
                    } else if (action === 'edit') {
                        if (id !== '0') {
                            if (response.records.data[0].current_address == response.records.data[0].permenent_address && response.records.data[0].current_city_id == response.records.data[0].permenent_city_id && response.records.data[0].current_country_id == response.records.data[0].permenent_country_id && response.records.data[0].current_pin == response.records.data[0].permenent_pin && response.records.data[0].current_state_id == response.records.data[0].permenent_state_id)
                            {
                                $scope.copyContent = true;
                            }
                            $scope.pageHeading = 'Edit User';
                            $scope.buttonLabel = 'Update';
                            $scope.userData = angular.copy(response.records.data[0]);
                            $scope.userData.password = '';
                            if ($scope.userData.marriage_date == "0000-00-00") {
                                $scope.userData.marriage_date = "";
                            }
                            var personal_mobile_no1_code = '+' + response.records.data[0].personal_mobile1_calling_code + '-';
                            var office_mobile_no_code = '+' + response.records.data[0].office_mobile_calling_code + '-';
                            $scope.userData.personal_mobile1 = personal_mobile_no1_code + angular.copy(response.records.data[0].personal_mobile1);
                            $scope.userData.office_mobile_no = office_mobile_no_code + angular.copy(response.records.data[0].office_mobile_no);
                            if (response.records.data[0].personal_mobile2_calling_code !== null) {
                                var personal_mobile_no2_code = '+' + response.records.data[0].personal_mobile2_calling_code + '-';
                                $scope.userData.personal_mobile2 = personal_mobile_no2_code + angular.copy(response.records.data[0].personal_mobile2);
                            } else {
                                $scope.userData.personal_mobile2 = "+91-";
                            }

                            if (response.records.data[0].personal_landline_calling_code == 0) {
                                $scope.userData.personal_landline_no = "+91-";
                            } else if (response.records.data[0].personal_landline_calling_code !== null) {
                                var landlineNo = '+' + response.records.data[0].personal_landline_calling_code + '-';
                                var landLineNumber = "" + response.records.data[0].personal_landline_no;
                                $scope.userData.personal_landline_no = landlineNo + landLineNumber;
                            }
                            if (response.records.data[0].office_email_id === null || response.records.data[0].office_email_id === '') {
                                $scope.userData.office_email_id = '';
                            } else
                                $scope.userData.office_email_id = response.records.data[0].office_email_id;
                            if (response.records.data[0].personal_email2 === null || response.records.data[0].personal_email2 === '') {
                                $scope.userData.personal_email2 = '';
                            } else
                                $scope.userData.personal_email2 = response.records.data[0].personal_email2;
                            $scope.userData.passwordOld = response.records.data[0].password;
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
                            $scope.imgUrl = response.records.data[0].employee_photo_file_name;
                            var deptId = response.records.data[0].department_id;
                            Data.post('master-hr/getDepartmentsToEdit', {
                                data: {deptId: deptId},
                                async: false,
                            }).then(function (response) {
                                if (!response.success) {
                                    $scope.errorMsg = response.message;
                                } else {
                                    $scope.userData.department_id = response.records;
                                }
                            });
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
            });
        };

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

        $scope.changePassword = function (id, username) {

            Data.post('master-hr/changePassword', {
                empId: id, username: username
            }).then(function (response) {
                if (response.success) {
                    $("#myModal").modal("toggle");
                    $scope.successMsg = response.message;
                } else {
                    $scope.errorMsg = response.message;
                }
            });
        }
        $scope.userPermissions = function (moduleType, id) {
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
        $scope.accessControl = function (moduleType, empId, checkboxid, parentId, submenuId) {
            var isChecked = $("#" + checkboxid).prop("checked");
            var obj = $("#" + checkboxid);
            var level = $("#" + checkboxid).attr("data-level");

            if (isChecked)
            {
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
            }
            Data.post('master-hr/accessControl', {
                data: {empId: empId, parentId: parentId, submenuId: submenuId, isChecked: isChecked, moduleType: moduleType}
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
                        arr.push([{v: "'" + response[i]['v'] + "'", f: "'" + response[i]['f']}, "'" + response[i]['teamId'] + "'", response[i]['designation_id']]);
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
        $scope.getProfile = function () {
            Data.post('master-hr/getProfileInfo').then(function (response) {
                $scope.passwordValidation = false;
                $scope.profileData = response.records;
                $scope.profileData.employee_photo_file_name = '';
                $scope.password_confirmation;
                $scope.flagProfilePhoto = response.flagProfilePhoto;
                $scope.profilePhoto = response.profilePhoto;
            });
        }

        $scope.updateProfile = function (profileData)
        {
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
                    toaster.pop('success', 'Profile', 'Profile updated successfully');
                }
                $rootScope.imageURL = response.data.profilePhoto;
            }, function (response) {});
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
//        $scope.quickEmployee = function (quickEmp)
//        {
//            Data.post('master-hr/createQuickUser', {data: quickEmp}).then(function (response) {
//                if (!response.success) {
//                    toaster.pop('error', 'Manage Users', 'Something went wrong. try again later');
//                    $scope.errorMsg = response.errormsg;
//                } else {
//                    toaster.pop('success', 'Manage Users', 'Record created successfully.');
//                    $state.go('userIndex');
//                }
//            });
//        }
        $scope.quickEmployee = function (quickEmp)
        {
          
            var date = new Date(quickEmp.joining_date);
            quickEmp.joining_date = (date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
            $scope.isDisabled = true;
            Data.post('master-hr/createQuickUser',
                    {
                        data: quickEmp
                    })
                    .then(function (response)
                    {
                        if (!response.success)
                        {
                            toaster.pop('error', 'Manage Users', 'Something went wrong. try again later');
                            $scope.isDisabled = false;
                            $scope.errorMsg = response.errormsg;
                        } else
                        {
                            $scope.isDisabled = true;
                            toaster.pop('success', 'Manage Users', 'Employee registeration successfully');
                            $state.go('userIndex');
                        }
                    });
        };


        /****************** Rohit *********************/
    }]);

