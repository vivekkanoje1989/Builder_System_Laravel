app.controller('hrController', ['$scope', '$state', 'Data', 'Upload', '$timeout', '$parse', '$stateParams', 'toaster', function ($scope, $state, Data, Upload, $timeout, $parse, $stateParams, toaster) {
    $scope.pageHeading = 'Create User';
    $scope.buttonLabel = 'Create';
    $scope.userData = {};
    $scope.listUsers = [];
    $scope.userData.gender_id = $scope.userData.title_id = $scope.userData.blood_group_id =
    $scope.userData.physic_status = $scope.userData.marital_status = $scope.userData.highest_education_id =
    $scope.userData.current_country_id = $scope.userData.current_state_id = $scope.userData.current_city_id =
    $scope.userData.permenent_country_id = $scope.userData.permenent_state_id = $scope.userData.permenent_city_id = "";
    $scope.userData.employee_status = "1";
    $scope.userData.personal_mobile1 = $scope.userData.office_mobile_no = $scope.userData.personal_mobile2 = $scope.userData.personal_landline_no = "+91-";
    $scope.disableCreateButton = false;
    $scope.currentPage =  $scope.itemsPerPage = 4;
    $scope.noOfRows = 1;
    
    $scope.validateMobileNumber = function (value) {
        var regex = /^(\+\d{1,4}-)\d{10}$/;
        if(!regex.test(value)){
            $scope.errMobile = "Mobile number should be 10 digits and pattern should be for ex. +91-9999999999";
            $scope.applyClassMobile = 'ng-active';
        }
        else{
            $scope.errMobile = "";
            $scope.applyClassMobile = 'ng-inactive';
        }    
    };
    $scope.validateLandlineNumber = function (value) {
        var regex = /^(\+\d{1,4}-\d{1,4})\d{6}$/;
        if(!regex.test(value)){
            $scope.errLandline = "Landline number should be 12 digits and pattern should be for ex. +91-1234-999999";
            $scope.applyClass = 'ng-active';
        }
        else{
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
    
    $scope.copyToUsername = function (value) {
        $scope.userData.username = value.split('-')[1];
    };
    /*$scope.checkTitle = function () {
        if ($scope.userData.title_id === "Mrs.")
        {
            $scope.userData.marital_status = "2";
            $("#marital_status").prop("disabled","disabled");
        }
        else{
            $scope.userData.marital_status = "1";
            $("#marital_status").removeAttr("disabled");
        }
    }*/

    $scope.createUser = function (enteredData, employeePhoto, empId) {
        var userData = {};        
        userData = angular.fromJson(angular.toJson(enteredData));
        var date = new Date($scope.userData.date_of_birth);
        $scope.userData.date_of_birth = (date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
        var date = new Date($scope.userData.joining_date);
        $scope.userData.joining_date = (date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
        
        if(empId === 0)
        {          
            var url = getUrl+'/master-hr/';
            var data = {userData: userData, employee_photo_file_name: employeePhoto, empId: empId};
            var successMsg = "Record successfully created.";
        }
        else{
            var url = getUrl+'/master-hr/' + empId;            
            var successMsg = "Record successfully updated.";  
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
                } else{
                    $scope.disableCreateButton = true;
                    employeePhoto.result = response.data;
                    toaster.pop('success', 'Employee Details', successMsg);                    
                    $timeout(function () {
                        $state.go(getUrl+'.userIndex');
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
    
    $scope.manageUsers = function (id,action) { //edit/index action
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
                        if($scope.userData.marriage_date == "0000-00-00"){
                            $scope.userData.marriage_date = "";   
                        }                            
                        var personal_mobile_no1_code = '+' + response.records.data[0].personal_mobile1_calling_code + '-';
                        var office_mobile_no_code = '+' + response.records.data[0].office_mobile_calling_code + '-';
                        $scope.userData.personal_mobile1 = personal_mobile_no1_code + angular.copy(response.records.data[0].personal_mobile1);
                        $scope.userData.office_mobile_no = office_mobile_no_code + angular.copy(response.records.data[0].office_mobile_no);
                        if (response.records.data[0].personal_mobile2_calling_code !== null) {
                            var personal_mobile_no2_code = '+' + response.records.data[0].personal_mobile2_calling_code + '-';
                            $scope.userData.personal_mobile2 = personal_mobile_no2_code + angular.copy(response.records.data[0].personal_mobile2);
                        }else{$scope.userData.personal_mobile2 = "+91-";}
                        
                        if (response.records.data[0].personal_landline_calling_code !== null) {
                            var landlineNo = '+'+response.records.data[0].personal_landline_calling_code + '-';
                            var landLineNumber=""+response.records.data[0].personal_landline_no;
                            $scope.userData.personal_landline_no = landlineNo +landLineNumber;
                        }else{$scope.userData.personal_landline_no = "+91-";}
                        if (response.records.data[0].office_email_id === null || response.records.data[0].office_email_id === '') {                                
                            $scope.userData.office_email_id = '';
                        }
                        else
                            $scope.userData.office_email_id = response.records.data[0].office_email_id;
                        if (response.records.data[0].personal_email2 === null || response.records.data[0].personal_email2 === '') {                                
                            $scope.userData.personal_email2 = '';
                        }else
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

    $scope.changePassword = function (id) {
        Data.post('master-hr/changePassword', {
            empId: id,
        }).then(function (response) {
            if (response.success) {
                $scope.successMsg = response.message;
            } else {
                $scope.errorMsg = response.message;
            }
        });
    }
    $scope.userPermissions = function(moduleType,id){
        Data.post('master-hr/getMenuLists',{
            data: {id: id, moduleType: moduleType},
        }).then(function (response) {
            if (response) {
                console.log(response);
                $scope.menuItems = response;
            } else {
                $scope.errorMsg = response.message;
            }
        });
    }
    
    $scope.updatePermissions = function(empId,roleId){
        Data.post('master-hr/updatePermissions',{
            data: {empId: empId, roleId:roleId},
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
    $scope.accessControl = function(moduleType, empId, checkboxid, parentId, submenuId){
        var isChecked = $("#"+checkboxid).prop("checked");
        var obj = $("#"+checkboxid);
        var level = $("#"+checkboxid).attr("data-level");
     
        if(isChecked)
        {
            if(level === "first"){
                $(obj.parent().parent().find('input[type=checkbox][data-level="second"], input[type=checkbox][data-level="third"]')).prop('checked', true);
                $(obj.parent().parent().find('input[type=checkbox][data-level="second"],input[type=checkbox][data-level="third"]')).each(function() {
                    var str = $( this ).attr('id');
                    var afterUnderscore = str.substr(str.indexOf("_") + 1);
                    submenuId.push(parseInt(afterUnderscore));
                });
            }else if(level === "second"){
                var flag = [];
                $($(obj.parent().parent().parent().find('li input[type=checkbox][data-level="second"]'))).each(function() {//for loop thr' data-level second, check if all data-level=second checkbox is checked then check data-level=first checkbox
                    if($( this ).is(':checked'))
                        flag.push(true);
                    else
                        flag.push(false);
                });
                if($.inArray(false, flag) === -1)
                    $(obj.parent().parent().parent().parent().find('input[type=checkbox][data-level="first"]')).prop('checked', true);
                
                $(obj.parent().parent().find('input[type=checkbox][data-level="third"]')).prop('checked', true);
                $(obj.parent().parent().find('input[type=checkbox][data-level="third"]')).each(function() {
                    var str = $( this ).attr('id');
                    var afterUnderscore = str.substr(str.indexOf("_") + 1);
                    submenuId.push(parseInt(afterUnderscore));
                });
            }
            else if(level === "third"){
                var flag = [];
                $($(obj.parent().parent().parent().find('li input[type=checkbox][data-level="third"]'))).each(function() {
                    if($( this ).is(':checked'))
                        flag.push(true);
                    else
                        flag.push(false);
                });
                if($.inArray(false, flag) === -1)
                    $(obj.parent().parent().parent().parent().find('input[type=checkbox][data-level="second"]')).prop('checked', true);
            }
        }
        else
        {
            if(level === "first"){
                $(obj.parent().parent().find('input[type=checkbox][data-level="second"]')).prop('checked', false);
                $(obj.parent().parent().find('input[type=checkbox][data-level="third"]')).prop('checked', false);
                $(obj.parent().parent().find('input[type=checkbox][data-level="second"]')).each(function() {
                    var str = $( this ).attr('id');
                    var afterUnderscore = str.substr(str.indexOf("_") + 1);
                    submenuId.push(parseInt(afterUnderscore));
                   
                });
                $( obj.parent().parent().find('input[type=checkbox][data-level="third"]')).each(function() {
                    var str = $( this ).attr('id');
                    var afterUnderscore = str.substr(str.indexOf("_") + 1);
                    submenuId.push(parseInt(afterUnderscore));
                });
            }
            else if(level === "second"){
                var flag = [];
                $($(obj.parent().parent().parent().find('li input[type=checkbox][data-level="second"]'))).each(function() {
                    if($( this ).is(':checked'))
                        flag.push(true);
                    else
                        flag.push(false);
                });
                if($.inArray(true, flag) === -1)
                    $(obj.parent().parent().parent().parent().find('input[type=checkbox][data-level="first"]')).prop('checked', false);
                
                $(obj.parent().parent().find('input[type=checkbox][data-level="third"]')).prop('checked', false);
                $( obj.parent().find('input[type=checkbox][data-level="third"]')).each(function() {
                    var str = $( this ).attr('id');
                    var afterUnderscore = str.substr(str.indexOf("_") + 1);
                    submenuId.push(parseInt(afterUnderscore));
                });
            }
            else if(level === "third"){
                var flag = [];
                $($(obj.parent().parent().parent().find('li input[type=checkbox][data-level="third"]'))).each(function() {
                    if($( this ).is(':checked'))
                        flag.push(true);
                    else
                        flag.push(false);
                });
                if($.inArray(true, flag) === -1)
                    $(obj.parent().parent().parent().parent().find('input[type=checkbox][data-level="second"]')).prop('checked', false);
            }
        }
        Data.post('master-hr/accessControl',{
            data: {empId:empId, parentId:parentId, submenuId:submenuId,isChecked:isChecked,moduleType:moduleType}
        }).then(function (response) {
            if (response) {
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
                console.log(response);
                var arr = new Array();
                var datalength = Object.keys(response).length;
                for (var i = 0; i < datalength; i++)
                {
                    arr.push([{v: "'" + response[i]['v'] + "'", f: "'" + response[i]['f'] }, "'" + response[i]['teamId'] + "'", response[i]['designation_id']]);
                }
                console.log(arr);
                data.addRows(arr);
                // Create the chart.
                var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
                // Draw the chart, setting the allowHtml option to true for the tooltips.
                chart.draw(data, {allowHtml: true});
            });
        }
    }
    /****************** Organization Chart *********************/
}]);

app.controller('teamLeadCtrl', function ($scope, Data) {
    Data.get('master-hr/getTeamLead/' + $("#empId").val()).then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.teamLeads = response.records;           
        }
    });
});    
