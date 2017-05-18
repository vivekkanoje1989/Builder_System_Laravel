'use strict';
app.controller('cloudtelephonyController',['$scope', 'Data','$filter','Upload','$window','$timeout','$state','$rootScope', function($scope, Data, $filter,Upload, $window,$timeout,$state,$rootScope) {
$scope.pageHeading = 'Virtual Number';
$scope.registrationData = {};
$scope.registrationData.client = "";  
$scope.registrationData.incoming_call_status = '1';
$scope.registrationData.outbound_call_status = '0';
$scope.registrationData.incoming_pulse_duration = '60';
$scope.registrationData.outbound_pulse_duration = '60';
$scope.registrationData.rent_duration = '1';
$scope.registrationData.default_number = false;
$scope.registrationData.id = '';
//$scope.cvn_id ='';
$scope.registrationNumber = function (registrationData) {
        console.log(registrationData);
        var date = new Date($scope.registrationData.activation_date);
        $scope.registrationData.activation_date = (date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate());
        $scope.submitted = true;
        //alert($scope.registrationData.joining_date);
        Data.post('cloudtelephony', {
            data: {registrationData: registrationData},
        }).then(function (response,evt) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                
                $scope.registrationData = {};
                $scope.registrationData.incoming_call_status = '1';
                $scope.registrationData.outbound_call_status = '0';
                $scope.registrationData.incoming_pulse_duration = '60';
                $scope.registrationData.outbound_pulse_duration = '60';
                $scope.registrationData.rent_duration = '1';
                $scope.step1 = false;
                $rootScope.alert('success', response.message);
                $('.alert-delay').delay(1000).fadeOut("slow");
                $timeout(function () {
                    $state.go(getUrl+'.numbersIndex');
                }, 1000);
                
                
            }
        });
       
    };
    
    
    $scope.createExtNumber = function (extData1,welcomeTuneAudio,mscwelcomeTuneAudio,ct_settings_id) {
        console.log(extData1);
        $scope.submitted = true;
            extData1.ct_settings_id = ct_settings_id;
            //alert(extData1.id);return false;
            if(extData1.id === '0')
            {       
                var url = getUrl+'/extensionmenu';
                var data = {extData1: extData1, welcomeTuneAudio: welcomeTuneAudio, mscwelcomeTuneAudio: mscwelcomeTuneAudio};
                welcomeTuneAudio.upload = Upload.upload({
                    url: url,
                    headers: {enctype: 'multipart/form-data'},
                    data: data
                }).then(function (response,evt) {
                    $timeout(function () {
                        $scope.manageextLists(extData1.ct_settings_id,'view');
                        
                        $scope.extData1 = {};
                        $scope.extData1.msc_facility_status='0';
                        $scope.extData1.msc_employee_type ='0';
                        $scope.step2 = false;

                        $('.alert-delay').delay(1000).fadeOut("slow");
                        $state.go(getUrl+'.extensionMenu');
                    });
                });
            }else{
                var url = getUrl+'/extensionmenu/' + extData1.id;
                var data = {_method: 'PUT', extData1: extData1, welcomeTuneAudio: welcomeTuneAudio, mscwelcomeTuneAudio: mscwelcomeTuneAudio};
                welcomeTuneAudio.upload = Upload.upload({
                    url: url,
                    headers: {enctype: 'multipart/form-data'},
                    data: data
                }).then(function (response,evt) {
                    $timeout(function () {
                        $scope.manageextLists(extData1.ct_settings_id,'view');
                        $scope.extData1 = {};
                        $scope.extData1.msc_facility_status='0';
                        $scope.extData1.msc_employee_type ='0';
                        $scope.step2 = false;

                        $('.alert-delay').delay(1000).fadeOut("slow");
                        $state.go(getUrl+'.extensionMenu');
                    });
                });
        }
           
       
}
    
    
    $scope.updateVirtualNumber = function (vnumberData,welcomeTuneAudio,holdTuneAudio) {
        console.log(vnumberData);
        console.log(welcomeTuneAudio);
        console.log(holdTuneAudio);
        $scope.submitted = true;
            var url = getUrl+'/virtualnumber';
            var data = {vnumberData: vnumberData, welcomeTuneAudio: welcomeTuneAudio, holdTuneAudio:holdTuneAudio};
            welcomeTuneAudio.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            }).then(function (response,evt) {
                $timeout(function () {
                    if(vnumberData.menu_status == false){
                        $state.go(getUrl+'.existingUpdate',{'id':vnumberData.id});
                    }else{
                        $state.go(getUrl+'.extensionMenu',{'id':vnumberData.id});
                    }
            });
            
    });
  }
 
  
  $scope.updateExisting = function (vnumberData,welcomeTuneAudio,holdTuneAudio) {
        console.log(vnumberData);
        console.log(welcomeTuneAudio);
        console.log(holdTuneAudio);

        $scope.submitted = true;
            //alert(vnumberData.id);return false;
            var url = getUrl+'/virtualnumber/'+vnumberData.id;
            var data = {_method: 'PUT',vnumberData: vnumberData, welcomeTuneAudio: welcomeTuneAudio, holdTuneAudio:holdTuneAudio};
            welcomeTuneAudio.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            }).then(function (response,evt) {
                $timeout(function () {
                    if(response.data.success == true)
                    $state.go(getUrl+'.virtualnumberslist');    
            });
            
    });
}
    
    $scope.outboundStatus = function() {
        if($scope.registrationData.outbound_call_status == '0'){
            $scope.registrationData.outbound_call_status = '1';
            $scope.registrationData.default_number = true;
        }else{
            $scope.registrationData.outbound_call_status = '0';
            $scope.registrationData.default_number = false;
        }
    };
    
    $scope.menuStatus = function() {
        if($scope.registrationData.welcome_tune_type_id <= '1'){
            $scope.registrationData.menu_status = false;
        }
    };
    
    
    $scope.manageLists = function (id,action) { //edit/index page
        
        Data.post('cloudtelephony/manageLists',{
            id: id,
        }).then(function (response) {
            if (response.success) {
                if(action === 'index'){
                    $scope.listNumbers = response.records.data;
                    $scope.listNumbersLength = response.records.total;
                    $scope.currentPage = 1;
                    $scope.itemsPerPage = 50;
                }
                else if(action === 'edit'){
                    if(id !== '0'){
                        $scope.pageHeading = 'Edit Number';
                        $timeout(function () {
                            //alert(response.records.data[0]['default_number']);return false;
                            if(response.records.data[0]['default_number'] == 1){
                                response.records.data[0]['default_number'] = true;
                            }else{
                                response.records.data[0]['default_number'] = false;
                            }
                            $scope.registrationData = angular.copy(response.records.data[0]);
                        }, 500);
                    }
                }else{
                    $scope.registrationData.id = id;
                }
            } else {
                $scope.errorMsg = response.message;
            }
        });
    };
    
    $scope.managevLists = function (id,action) { //edit/index page
        //$("#wiredstep1").show();
       // $("#wiredstep1").addClass('active');
        Data.post('virtualnumber/manageLists',{
            id: id,
            action:action
        }).then(function (response) {
            if (response.success) {
                if(action === 'index'){
                    $scope.listNumbers = response.records.data;
                    $scope.listNumbersLength = response.records.total;
                    $scope.currentPage = 1;
                    $scope.itemsPerPage = 50;
                }
                else if(action === 'edit'){
                    if(id !== '0'){
                        $scope.pageHeading = 'Edit Virtual Number';
                        
                        $timeout(function () {
                            
                            if(response.records.data[0]['default_number'] == 1){
                                response.records.data[0]['default_number'] = true;
                            }else{
                                response.records.data[0]['default_number'] = false;
                            }
                            if(response.records.data[0]['missed_call_insert_enquiry'] == 1){
                                response.records.data[0]['missed_call_insert_enquiry'] = true;
                            }else{
                                response.records.data[0]['missed_call_insert_enquiry'] = false;
                            }
                            if(response.records.data[0]['menu_status'] == 1){
                                response.records.data[0]['menu_status'] = true;
                            }else{
                                response.records.data[0]['menu_status'] = false;
                            }
                            
                            var srcurl = s3Path+"/caller_tunes/";//"https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/caller_tunes/";
                            
                            $scope.registrationData = angular.copy(response.records.data[0]);
                            if($scope.registrationData.welcome_tune_type_id == 3){
                                $scope.welcome_url = srcurl+$scope.registrationData.welcome_tune;
                                document.getElementById('welcomeaudio').src = $scope.welcome_url;
                            }
                            if($scope.registrationData.hold_tune_type_id == 3){
                                $scope.hold_url = srcurl+$scope.registrationData.hold_tune;
                                document.getElementById('holdaudio').src = $scope.hold_url;
                            }
                            
                            if($scope.registrationData.nwh_welcome_tune_type_id == 3){
                                $scope.nwh_url = srcurl+$scope.registrationData.nwh_welcome_tune;
                                document.getElementById('nwhaudio').src = $scope.nwh_url;
                            }
                            Data.post('virtualnumber/getEmployeelist',{
                                ids: response.records.data[0]['employees'],
                            }).then(function (response) {
                                console.log(response.records);
                                $scope.registrationData.employees1 = response.records;
                            });
                            Data.post('virtualnumber/getEmployeelist',{
                                ids: response.records.data[0]['msc_default_employee_id'],
                            }).then(function (response) {
                                console.log(response.records);
                                $scope.registrationData.msc_default_employee_id = response.records;
                            });
                        }, 500);
                    }
                }else if(action === 'existingedit'){
                    $scope.registrationData = angular.copy(response.records.data[0]);
                    var srcurl = s3Path+"/caller_tunes/";//"https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/caller_tunes/";
                            
                    $scope.registrationData = angular.copy(response.records.data[0]);
                    if($scope.registrationData.ec_welcome_tune_type_id == 3){
                        $scope.welcome_url = srcurl+$scope.registrationData.ec_welcome_tune;
                        document.getElementById('ecwelcomeaudio').src = $scope.welcome_url;
                    }
                    if($scope.registrationData.hold_tune_type_id == 3){
                        $scope.hold_url = srcurl+$scope.registrationData.ec_hold_tune;
                        document.getElementById('echoldaudio').src = $scope.hold_url;
                    }
                }else{
                    $scope.registrationData.id = id;
                }
            } else {
                $scope.errorMsg = response.message;
            }
        });
    };
    
    
    $scope.manageextLists = function (id,action) { 
        Data.post('extensionmenu/manageextLists',{
            id:id,
        }).then(function (response) {
            if (response.success) {
                console.log(response);
                if(action === 'view'){
                    $scope.listNumbers = response.records.data;
                    $scope.listNumbersLength = response.records.total;
                    $scope.virtualno = response.records.virtualno;
                    $scope.currentPage = 1;
                    $scope.itemsPerPage = 10;
                    
                }
            } else {
                $scope.errorMsg = response.message;
            }
        });
    };
    
    
    $scope.manageextUpdate = function (id,action) { 
        Data.post('extensionmenu/manageextUpdate',{
            id:id,
        }).then(function (response) {
            if (response.success) {
                console.log(response);
                if(action === 'edit'){
                      $scope.extData1 = angular.copy(response.records.data[0]);
                      
                      var srcurl = s3Path+"/caller_tunes/";//"https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/caller_tunes/";
                      if($scope.extData1.welcome_tune_type_id == 3){
                            $scope.welcome_url = srcurl+$scope.extData1.welcome_tune;
                            document.getElementById('welcomeaudio').src = $scope.welcome_url;
                        }
                        if($scope.extData1.hold_tune_type_id == 3){
                            $scope.hold_url = srcurl+$scope.extData1.hold_tune;
                            document.getElementById('holdaudio').src = $scope.hold_url;
                        }

                        if($scope.extData1.msc_welcome_tune_type_id == 3){
                            $scope.msc_url = srcurl+$scope.extData1.msc_welcome_tune;
                            document.getElementById('mscaudio').src = $scope.msc_url;
                        }
                            
                      Data.post('extensionmenu/getEmployeelist',{
                            ids: response.records.data[0]['employees'],
                        }).then(function (response) {
                            console.log(response.records);
                            $scope.extData1.employees1 = response.records;
                            
                        });

                    
                }
            } else {
                $scope.errorMsg = response.message;
            }
        });
    };
    
    
    
    
    $scope.getsubsource = function(source_id){
        $scope.enquirysubsources = {};
        Data.post('virtualnumber/getSubsources',{
            source_id: source_id,
        }).then(function (response) {
            console.log(response.records);
            $scope.enquirysubsources = response.records;
        });
    }
    
    
    
    $scope.cttunetype = function() {
    Data.get('getCttunetype').then(function (response) {
        if(!response.success){
            $scope.errorMsg = response.message;
        }
        else{
           $scope.ct_tune_types = response.records;
        }
    });
    };
    
    $scope.cttunetype1 = function() {
    Data.get('getCttunetype').then(function (response) {
        if(!response.success){
            $scope.errorMsg = response.message;
        }
        else{
           $scope.ct_tune_types1 = response.records;
        }
    });
    };
    
    $scope.cttunetype2 = function() {
    Data.get('getCttunetype').then(function (response) {
        if(!response.success){
            $scope.errorMsg = response.message;
        }
        else{
           $scope.ct_tune_types2 = response.records;
        }
    });
    };
    
    $scope.ct_forwarding_types = function() {
    Data.get('getCtforwardingtypes').then(function (response) {
        if(!response.success){
            $scope.errorMsg = response.message;
        }
        else{
           $scope.ct_forwarding_types = response.records;
        }
    });
    };
    
    $scope.emplist = function() {
    Data.get('getEmployees').then(function (response) {
        if(!response.success){
            $scope.errorMsg = response.message;
        }
        else{
           $scope.employees1 = response.records;
        }
    });
    }
    
}]);


 


