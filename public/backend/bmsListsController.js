'use strict';
app.controller('bloodGroupCtrl', ['$scope', 'Data', '$rootScope','Flash','$timeout', function ($scope, Data, $rootScope,Flash,$timeout) {

        $scope.manageBloodGroup = function () {
            Data.get('bms_lists/manageBloodGroup').then(function (response) {
                $scope.bloodGrpRow = response.records;
            });
        };
        $scope.initialModal = function (id, name, index) {
            $scope.heading = 'Blood Group';
            $scope.blood_group_id = id;
            $scope.blood_group = name;
            $scope.index = index;
        }
        $scope.doBloodGroupAction = function () {
            $scope.errorMsg = '';
            if ($scope.blood_group_id === 0) //for create
            {
                Data.post('bms_lists/createBloodGroup', {
                    blood_group: $scope.blood_group}).then(function (response) {
                  
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.bloodGrpRow.push({'blood_group': $scope.blood_group,'blood_group_id':response.lastinsertid});
                        $('#bloodGroupModal').modal('toggle');
                        $scope.success("Blood group details created successfully");
                    }
                });
            } else {//for update
                Data.post('bms_lists/updateBloodGroup', {
                    blood_group: $scope.blood_group, blood_group_id: $scope.blood_group_id}).then(function (response) {
                    console.log(response);
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.bloodGrpRow.splice($scope.index, 1);
                        $scope.bloodGrpRow.splice($scope.index, 0, {
                            blood_group: $scope.blood_group, blood_group_id: $scope.blood_group_id});
                        $('#bloodGroupModal').modal('toggle');
                         $scope.success("Blood group details updated successfully");
                    }
                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
    }]);



app.controller('statesCtrl', ['$scope', 'Data', '$rootScope','Flash','$timeout', function ($scope, Data, $rootScope,Flash,$timeout) {
        $scope.noOfRows = 1;
        $scope.itemsPerPage = 4;
        $scope.manageStates = function () {
            Data.get('bms_lists/manageStates').then(function (response) {
                $scope.statesRow = response.records;
            });
        };
        $scope.initialModal = function (id, name, country, index, index1) {

            $scope.heading = 'States';
            $scope.id = id;
            $scope.name = name;
            $scope.statesForm.index = index * ($scope.noOfRows - 1) + (index1 + 1);
            $scope.country = country;


        }
        $scope.doStatesAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('bms_lists/createStates', {
                    name: $scope.name}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.statesRow.push({'name': $scope.name});
                        $('#statesModal').modal('toggle');
                         $scope.statesRow.push({'name': $scope.name,'id':$scope.statesRow.length+1});
                         $scope.success("State details created successfully");
                    }
                });
            } else {      //for update
                Data.post('bms_lists/updateStates', {
                    name: $scope.name, id: $scope.id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.statesRow.splice($scope.statesForm.index - 1, 1);
                        $scope.statesRow.splice($scope.statesForm.index - 1, 0, {
                            name: $scope.name, id: $scope.id, country_name: $scope.country});
                        $('#statesModal').modal('toggle');
                         $scope.success("State details updated successfully");
                    }
                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);

app.controller('citiesCtrl', ['$scope', 'Data', '$rootScope','Flash','$timeout', function ($scope, Data, $rootScope,Flash,$timeout) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.manageCities = function () {
            Data.get('bms_lists/manageCities').then(function (response) {
                $scope.citiesRow = response.records;

            });
        };
        $scope.initialModal = function (id, name, country, state, index, index1) {

            $scope.heading = 'City';
            $scope.id = id;
            $scope.name = name;
            $scope.country = country;
            $scope.state = state;
            $scope.index = index * ($scope.noOfRows - 1) + (index1 + 1);
        }
        $scope.doCitiesAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('bms_lists/createCities', {
                    name: $scope.name}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.citiesRow.push({'name': $scope.name});
                        $('#cityModal').modal('toggle');
                        $scope.success("City details created successfully");
                    }
                });
            } else {//for update

                Data.post('bms_lists/updatecities', {
                    name: $scope.name, id: $scope.id}).then(function (response) {

                    if (!response.success)
                    {

                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.citiesRow.splice($scope.index - 1, 1);
                        $scope.citiesRow.splice($scope.index - 1, 0, {
                            name: $scope.name, id: $scope.id, country_name: $scope.country, state_name: $scope.state});
                        $('#cityModal').modal('toggle');
                         $scope.success("City details updated successfully");
                    }
                });
            }
        }
       $scope.success = function(message) {
               Flash.create('success', message);
           };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        

    }]);

app.controller('countryCtrl', ['$scope', 'Data', '$rootScope','Flash','$timeout', function ($scope, Data, $rootScope,Flash,$timeout) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.manageCountry = function () {
            Data.get('bms_lists/manageCountry').then(function (response) {
                $scope.countryRow = response.records;

            });
        };
        $scope.initialModal = function (id, name, index, index1,phonecode,sortname) {

            $scope.heading = 'Country';
            $scope.id = id;
            $scope.name = name;
            $scope.index = index * ($scope.noOfRows - 1) + (index1 + 1);
            $scope.phonecode = phonecode;
            $scope.sortname = sortname;
           
        }
        $scope.doCountryAction = function () {
            $scope.errorMsg = '';

            if ($scope.id === 0) //for create
            {
                Data.post('bms_lists/createCountry', {
                    name: $scope.name,phonecode:$scope.phonecode,sortname:$scope.sortname}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.countryRow.push({'name': $scope.name,'id':response.lastinsertid,'sortname':$scope.sortname,'phonecode':$scope.phonecode});
                        $('#countryModal').modal('toggle');
                        $scope.success("Country details created successfully");
                    }
                });
            } else { //for update

                Data.post('bms_lists/updateCountry', {
                    name: $scope.name, id: $scope.id,'sortname':$scope.sortname,'phonecode':$scope.phonecode}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.countryRow.splice($scope.index - 1, 1);
                        $scope.countryRow.splice($scope.index - 1, 0, {
                            name: $scope.name, id: $scope.id, name: $scope.name,'sortname':$scope.sortname,'phonecode':$scope.phonecode});

                        $('#countryModal').modal('toggle');
                        $scope.success("Country details updated successfully");
                    }
                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);

app.controller('locationCtrl', ['$scope', 'Data', '$rootScope','Flash','$timeout', function ($scope, Data, $rootScope,Flash,$timeout) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.manageLocation = function () {
            Data.get('bms_lists/manageLocation').then(function (response) {
                $scope.locationRow = response.records;

            });
        };
        $scope.initialModal = function (id, name, index, index1) {

            $scope.heading = 'Location';
            $scope.id = id;
            $scope.name = name;
            $scope.index = index * ($scope.noOfRows - 1) + (index1 + 1);
        }
        $scope.doLocationAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('bms_lists/createLocation', {
                    location_type: $scope.name}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.locationRow.push({'location_type': $scope.name,id:response.lastinsertid});
                        $('#LocationModal').modal('toggle');
                        $scope.success("Location details created successfully");
                    }
                });
            } else { //for update

                Data.post('bms_lists/updateLocation', {
                    location_type: $scope.name, id: $scope.id}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.locationRow.splice($scope.index - 1, 1);
                        $scope.locationRow.splice($scope.index - 1, 0, {
                            location_type: $scope.name, id: $scope.id});
                        $('#LocationModal').modal('toggle');
                         $scope.success("Location details Updated successfully");
                    }
                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);

app.controller('highestEducationCtrl', ['$scope', 'Data', '$rootScope','Flash','$timeout', function ($scope, Data, $rootScope,Flash,$timeout) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.manageHighestEducation = function () {
            Data.get('bms_lists/manageHighestEducation').then(function (response) {
                $scope.educationRow = response.records;

            });
        };
        $scope.initialModal = function (id, education_title, index) {

            $scope.heading = 'Highest Education';
            $scope.education_id = id;
            $scope.education_title = education_title;
            $scope.index = index;
        }
        $scope.doHighestEducationAction = function () {
            $scope.errorMsg = '';
            if ($scope.education_id === 0) //for create
            {
                Data.post('bms_lists/createHighestEducation', {
                    education_title: $scope.education_title}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.educationRow.push({'education_title': $scope.education_title, 'education_id': $scope.educationRow.length});
                        $('#highesteducModal').modal('toggle');
                         $scope.success("Education details Created successfully"); 
                    }
                });
            } else { //for update

                Data.post('bms_lists/updateHighestEducation', {
                    education_title: $scope.education_title, education_id: $scope.education_id}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.educationRow.splice($scope.index, 1);
                        $scope.educationRow.splice($scope.index, 0, {
                            education_title: $scope.education_title, education_id: $scope.education_id});
                        $('#highesteducModal').modal('toggle');
                        $scope.success("Education details updated successfully"); 
                    }
                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        
    }]);


app.controller('manageDepartmentCtrl', ['$scope', 'Data', '$rootScope','Flash','$timeout', function ($scope, Data, $rootScope,Flash,$timeout) {

        $scope.manageDepartment = function () {
            Data.get('bms_lists/manageDepartment').then(function (response) {
                $scope.departmentRow = response.records;

            });
        };
        $scope.initialModal = function (id, department_name, index) {

            $scope.heading = 'Department';
            $scope.id = id;
            $scope.department_name = department_name;
            $scope.index = index;
        }
        $scope.dodepartmentAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('bms_lists/createDepartment', {
                    department_name: $scope.department_name}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.departmentRow.push({'department_name': $scope.department_name,'id':response.lastinsertid});
                        $('#departmentModal').modal('toggle');
                        $scope.success("Department details created successfully"); 
                    }
                });
            } else { //for update

                Data.post('bms_lists/updateDepartment', {
                    department_name: $scope.department_name, id: $scope.id}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.departmentRow.splice($scope.index, 1);
                        $scope.departmentRow.splice($scope.index, 0, {
                            department_name: $scope.department_name, id: $scope.id});
                        $('#departmentModal').modal('toggle');
                        $scope.success("Department details updated successfully"); 
                    }
                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);



app.controller('manageProfessionCtrl', ['$scope', 'Data', '$rootScope','Flash','$timeout', function ($scope, Data, $rootScope,Flash,$timeout) {

        $scope.manageProfession = function () {
            Data.get('bms_lists/manageProfession').then(function (response) {
                $scope.professionRow = response.records;

            });
        };
        $scope.initialModal = function (id, profession, index) {

            $scope.heading = 'Profession';
            $scope.id = id;
            $scope.profession = profession;
            $scope.index = index;

        }
        $scope.doprofessionAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('bms_lists/createProfession', {
                    profession: $scope.profession}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {

                        $scope.professionRow.push({'profession': $scope.profession, 'id': $scope.professionRow.length + 1});
                        $('#professionModal').modal('toggle');
                        $scope.success("Profession details created successfully"); 
                    }

                });
            } else { //for update

                Data.post('bms_lists/updateProfession', {
                    profession: $scope.profession, id: $scope.id}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.professionRow.splice($scope.index, 1);
                        $scope.professionRow.splice($scope.index, 0, {
                            profession: $scope.profession, id: $scope.id});
                        $('#professionModal').modal('toggle');
                        $scope.success("Profession details updated successfully"); 
                    }
                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        
    }]);

app.controller('lostReasonsController', ['$rootScope', '$scope', '$state', 'Data', '$timeout', '$parse', 'Flash',function ($rootScope, $scope, $state, Data, $timeout, $parse,Flash) {
        $scope.heading = 'Create Lost Reason';
        $scope.manageLostReasons = function () {
            $scope.modal = {};
            Data.post('bmslists/manageLostReasons').then(function (response) {
                $scope.listLostReasons = response.records;
            });
        };
        $scope.initialModal = function (id, reason, status, index) {
            $scope.actionModal = id;
            $scope.modal_title = 'Lost Reason';
            $scope.reason = reason;
            $scope.lost_reason_status = status;
            $scope.index = index;
        };

        $scope.doLostReasonsAction = function ()
        {
            if ($scope.actionModal === 0)
            { //create
                Data.post('bmslists/createLostReasons', {
                    Data: {reason: $scope.reason, lost_reason_status: $scope.lost_reason_status, }
                }).then(function (response) {
                    if (response.success) {
                        $scope.listLostReasons.push({'id': response.records, 'reason': $scope.reason, lost_reason_status: $scope.lost_reason_status});
                        $('#lostReasonModal').modal('toggle');
                        $scope.success("Lost reason details created successfully"); 
                    }
                });
            } else
            { //update
                Data.post('bmslists/updateLostReasons', {
                    Data: {reason: $scope.reason, lost_reason_status: $scope.lost_reason_status, id: $scope.actionModal, }
                }).then(function (response) {
                    if (response.success) {

                        $scope.listLostReasons.splice($scope.index, 1);
                        $scope.listLostReasons.splice($scope.index, 0, {
                            reason: $scope.reason, lost_reason_status: $scope.lost_reason_status, id: $scope.actionModal});

                        $('#lostReasonModal').modal('toggle');
                        $scope.success("Lost reason details updated successfully"); 

                    }
                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
    }]);


app.controller('blockstagesCtrl', ['$scope', 'Data', '$rootScope','Flash','$timeout', function ($scope, Data, $rootScope,Flash,$timeout) {

        $scope.blockStages = function () {
            Data.post('bms_lists/manageBlockStages').then(function (response) {
                $scope.BlockStageRow = response.records;
                
            });
        };
        $scope.initialModal = function (id, blockStage, index) {

            $scope.heading = 'Block Stages';
            $scope.id = id;
            $scope.block_stages = blockStage;
            $scope.index = index;

        }
        $scope.doblockstagesAction = function () {
          
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('bms_lists/createBlockStages', {
                    block_stages: $scope.block_stages}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#blockstagesModal').modal('toggle');
                        $scope.BlockStageRow.push({'block_stages': $scope.block_stages, 'id': $scope.BlockStageRow.length + 1});
                       
                            $scope.success("Block stage details created successfully"); 

                    }
                });
            } else { //for update

                Data.post('bms_lists/updateBlockStage', {
                    block_stages: $scope.block_stages, id: $scope.id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.BlockStageRow.splice($scope.index, 1);
                        $scope.BlockStageRow.splice($scope.index, 0, {
                            block_stages: $scope.block_stages, id: $scope.id});
                        $('#blockstagesModal').modal('toggle');
                         $scope.success("Block stage details updated successfully"); 
                    }
                });
            }
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        $scope.success = function(message) {
               Flash.create('success', message);
           };
        
    }]);


app.controller('enquirysourceCtrl', ['$scope', 'Data', '$rootScope','Flash','$timeout', function ($scope, Data, $rootScope,Flash,$timeout) {

        $scope.manageEnquirySource = function () {
            Data.post('bms_lists/manageEnquirySource').then(function (response) {
                $scope.EnquirySourceRow = response.records;
            });
        };

        $scope.getSubSource = function (source_id) {
            Data.post('bms_lists/manageSubEnquirySource', {"source_id": source_id}).then(function (response) {

                $scope.SubEnquirySourceRow = response.records;
            });
        }
        $scope.sourceinitialModal = function () {

            $scope.heading = 'Source';

        }
        $scope.initialModal = function (id, source_id, subsource, index) {

            $scope.heading = 'Sub Sources';
            $scope.subid = id;
            $scope.source_id = source_id;
            $scope.sub_source = subsource;
            $scope.index = index;
        }

        $scope.dosourceAction = function () {
            $scope.errorMsg = '';

            Data.post('bms_lists/createEnquirySource', {
                source_name: $scope.source_name}).then(function (response) {

                if (!response.success)
                {
                    $scope.errorMsg = response.errormsg;
                } else {
                    $('#sourceModal').modal('toggle');
                    $scope.EnquirySourceRow.push({'source_name': $scope.source_name, 'id': $scope.EnquirySourceRow.length + 1});
                      $scope.success("Source details created successfully"); 

                }
            });
        }
        $scope.dosubsourceAction = function () {
            $scope.errorMsg = '';
            if ($scope.subid === 0) //for create
            {
                Data.post('bms_lists/createsubEnquirySource', {
                    sub_source: $scope.sub_source, source_id: $scope.source_id}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#subsourceModal').modal('toggle');
                        $scope.SubEnquirySourceRow.push({'sub_source': $scope.sub_source, 'id': $scope.SubEnquirySourceRow.length + 1});
                        $scope.success("Sub source details created successfully"); 

                    }
                });
            } else { //for update

                Data.post('bms_lists/updateSubEnquirySource', {
                    sub_source: $scope.sub_source, source_id: $scope.source_id, id: $scope.subid}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.SubEnquirySourceRow.splice($scope.index, 1);
                        $scope.SubEnquirySourceRow.splice($scope.index, 0, {
                            sub_source: $scope.sub_source, id: $scope.subid});
                        $('#subsourceModal').modal('toggle');
                         $scope.success("Sub source details updated successfully"); 
                    }
                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        
    }]);


app.controller('discountheadingController',['$scope', 'Data', '$rootScope','Flash','$timeout', function ($scope, Data, $rootScope,Flash,$timeout) {

        $scope.manageDiscountHeading = function () {
            Data.post('bms_lists/manageDiscountHeading').then(function (response) {
                $scope.DiscountHeadingRow = response.records;
            });
        };
        $scope.initialModal = function (id, discount_name, status, index) {

            $scope.heading = 'Discount Heading';
            $scope.actionModal = id;
            $scope.discount_name = discount_name;
            $scope.status = status;
            $scope.index = index;
        }


        $scope.doDiscountHeadingAction = function () {
            $scope.errorMsg = '';
            if ($scope.actionModal === 0) //for create
            {
                Data.post('bms_lists/createDiscountHeading', {
                    discount_name: $scope.discount_name}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#discountheadingModal').modal('toggle');
                        $scope.DiscountHeadingRow.push({'discount_name': $scope.discount_name, 'id': $scope.DiscountHeadingRow.length + 1, 'status': $scope.status});
                        $scope.success("Discount heading created successfully");   
                    }
                });
            } else { //for update

                Data.post('bms_lists/updateDiscountHeading', {
                    discount_name: $scope.discount_name, status: $scope.status, id: $scope.id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.DiscountHeadingRow.splice($scope.index, 1);
                        $scope.DiscountHeadingRow.splice($scope.index, 0, {
                            discount_name: $scope.discount_name, id: $scope.id, 'status': $scope.status});
                        $('#discountheadingModal').modal('toggle');
                        $scope.success("Discount heading updated successfully");   
                    }
                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        
    }]);



app.controller('projectpaymentController', ['$scope', 'Data', '$rootScope','Flash','$timeout', function ($scope, Data, $rootScope,Flash,$timeout) {

        $scope.manageProjectPaymentStages = function () {
            Data.post('bms_lists/manageProjectPaymentStages').then(function (response) {
                $scope.ProjectPaymentStagesRow = response.records;
            });
        };
        $scope.initialModal = function (id, project_stages, index) {

            $scope.heading = 'Project payment stages';
            $scope.id = id;
            $scope.project_stages = project_stages;
            $scope.index = index;
        }


        $scope.doDiscountHeadingAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('bms_lists/createProjectPaymentStages', {
                    project_stages: $scope.project_stages}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#projectpaymentModal').modal('toggle');
                        $scope.ProjectPaymentStagesRow.push({'project_stages': $scope.project_stages, 'id': $scope.ProjectPaymentStagesRow.length + 1, 'status': $scope.status});
                       
                         $scope.success("Project payment stages created successfully");   
                    }
                });
            } else { //for update

                Data.post('bms_lists/updateProjectPaymentStages', {
                    project_stages: $scope.project_stages, id: $scope.id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.ProjectPaymentStagesRow.splice($scope.index, 1);
                        $scope.ProjectPaymentStagesRow.splice($scope.index, 0, {
                            project_stages: $scope.project_stages, id: $scope.id});
                        $('#projectpaymentModal').modal('toggle');
                        $scope.success("Project payment stages updated successfully");   
                    }
                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
       
    }]);

app.controller('projecttypesController', ['$scope', 'Data', '$rootScope','Flash','$timeout', function ($scope, Data, $rootScope,Flash,$timeout) {

        $scope.manageProjectTypes = function () {
            Data.post('bms_lists/manageProjectTypes').then(function (response) {
                
                $scope.ProjectTypesRow = response.records;
               
              
            });
        };
        $scope.initialModal = function (project_type_id, project_type_name, index) {

            $scope.heading = 'Project Types';
            $scope.project_type_id = project_type_id;
            $scope.project_type_name = project_type_name;
            $scope.index = index;
        }


        $scope.doProjectTypesAction = function () {
            $scope.errorMsg = '';
            if ($scope.project_type_id === 0) //for create
            {
                Data.post('bms_lists/createProjectTypes', {
                    project_type_name: $scope.project_type_name}).then(function (response) {
                    
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#projecttypesModal').modal('toggle');
                        $scope.ProjectTypesRow.push({'project_type_name': $scope.project_type_name, 'project_type_id': $scope.ProjectTypesRow.length + 1});
                       
                    $scope.success("Project type created successfully");   
                    }
                });
            } else { //for update

                Data.post('bms_lists/updateProjectTypes', {
                    project_type_name: $scope.project_type_name, project_type_id: $scope.project_type_id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.success("Project type updated successfully");   
                        $scope.ProjectTypesRow.splice($scope.index, 1);
                        $scope.ProjectTypesRow.splice($scope.index, 0, {
                            project_type_name: $scope.project_type_name, project_type_id: $scope.project_type_id});
                        $('#projecttypesModal').modal('toggle');
                    }
                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        
    }]);


app.controller('enquirysourceCtrl', ['$scope', 'Data', '$rootScope','Flash','$timeout', function ($scope, Data, $rootScope,Flash,$timeout) {

        $scope.manageEnquirySource = function () {
            Data.post('bms_lists/manageEnquirySource').then(function (response) {
                $scope.EnquirySourceRow = response.records;
            });
        };

        $scope.getSubSource = function (source_id) {
            Data.post('bms_lists/manageSubEnquirySource', {"source_id": source_id}).then(function (response) {

                $scope.SubEnquirySourceRow = response.records;
            });
        }
        $scope.sourceinitialModal = function () {

            $scope.heading = 'Source';

        }
        $scope.initialModal = function (id, source_id, subsource, index) {

            $scope.heading = 'Sub Sources';
            $scope.subid = id;
            $scope.source_id = source_id;
            $scope.sub_source = subsource;
            $scope.index = index;
        }

        $scope.dosourceAction = function () {
            $scope.errorMsg = '';

            Data.post('bms_lists/createEnquirySource', {
                source_name: $scope.source_name}).then(function (response) {

                if (!response.success)
                {
                    $scope.errorMsg = response.errormsg;
                } else {
                    $('#sourceModal').modal('toggle');
                    $scope.EnquirySourceRow.push({'source_name': $scope.source_name, 'id': $scope.EnquirySourceRow.length + 1});
                      $scope.success("Source details created successfully"); 

                }
            });
        }
        $scope.dosubsourceAction = function () {
            $scope.errorMsg = '';
            if ($scope.subid === 0) //for create
            {
                Data.post('bms_lists/createsubEnquirySource', {
                    sub_source: $scope.sub_source, source_id: $scope.source_id}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#subsourceModal').modal('toggle');
                        $scope.SubEnquirySourceRow.push({'sub_source': $scope.sub_source, 'id': $scope.SubEnquirySourceRow.length + 1});
                        $scope.success("Sub source details created successfully"); 

                    }
                });
            } else { //for update

                Data.post('bms_lists/updateSubEnquirySource', {
                    sub_source: $scope.sub_source, source_id: $scope.source_id, id: $scope.subid}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.SubEnquirySourceRow.splice($scope.index, 1);
                        $scope.SubEnquirySourceRow.splice($scope.index, 0, {
                            sub_source: $scope.sub_source, id: $scope.subid});
                        $('#subsourceModal').modal('toggle');
                         $scope.success("Sub source details updated successfully"); 
                    }
                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        
    }]);


app.controller('discountheadingController',['$scope', 'Data', '$rootScope','Flash','$timeout', function ($scope, Data, $rootScope,Flash,$timeout) {

        $scope.manageDiscountHeading = function () {
            Data.post('bms_lists/manageDiscountHeading').then(function (response) {
                $scope.DiscountHeadingRow = response.records;
            });
        };
        $scope.initialModal = function (id, discount_name, status, index) {

            $scope.heading = 'Discount Heading';
            $scope.actionModal = id;
            $scope.discount_name = discount_name;
            $scope.status = status;
            $scope.index = index;
        }


        $scope.doDiscountHeadingAction = function () {
            $scope.errorMsg = '';
            if ($scope.actionModal === 0) //for create
            {
                Data.post('bms_lists/createDiscountHeading', {
                    discount_name: $scope.discount_name}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#discountheadingModal').modal('toggle');
                        $scope.DiscountHeadingRow.push({'discount_name': $scope.discount_name, 'id': $scope.DiscountHeadingRow.length + 1, 'status': $scope.status});
                        $scope.success("Discount heading created successfully");   
                    }
                });
            } else { //for update

                Data.post('bms_lists/updateDiscountHeading', {
                    discount_name: $scope.discount_name, status: $scope.status, id: $scope.id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.DiscountHeadingRow.splice($scope.index, 1);
                        $scope.DiscountHeadingRow.splice($scope.index, 0, {
                            discount_name: $scope.discount_name, id: $scope.id, 'status': $scope.status});
                        $('#discountheadingModal').modal('toggle');
                        $scope.success("Discount heading updated successfully");   
                    }
                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        
    }]);



app.controller('blocktypesController', ['$scope', 'Data', '$rootScope','Flash','$timeout', function ($scope, Data, $rootScope,Flash,$timeout) {

        $scope.manageBlockTypes = function () {
            Data.post('bms_lists/manageBlockTypes').then(function (response) {
                $scope.BlockTypesRow = response.records;
            });
        };
        
        $scope.getProjectNames = function(){
             Data.post('bms_lists/manageProjectTypes').then(function (response) {
                $scope.getProjectNamesRow = response.records;
             
            });
        }
        $scope.initialModal = function (id, block_name,project_type_id, index) {

            $scope.heading = 'Project block types';
            $scope.id = id;
            $scope.project_type_id = project_type_id;
            $scope.block_name = block_name;
            $scope.index = index;
        }
        $scope.doblocktypesAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('bms_lists/createBlockTypes', { block_id:$scope.block_name,
                    project_type_id: $scope.project_type_id, block_name:$scope.block_name}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#blocktypesModal').modal('toggle');
                        $scope.BlockTypesRow.push({'block_name': $scope.block_name, 'id': $scope.BlockTypesRow.length + 1,'project_id': $scope.project_type_id});
                       
                         $scope.success("Block types created successfully");   
                    }
                });
            } else { //for update

                Data.post('bms_lists/updateBlockTypes', {
                     block_id:$scope.block_name,
                    project_type_id: $scope.project_type_id, block_name:$scope.block_name,id:$scope.id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.BlockTypesRow.splice($scope.index, 1);
                        $scope.BlockTypesRow.splice($scope.index, 0, {
                            'block_name': $scope.block_name, 'id': $scope.id,'project_id': $scope.project_type_id});
                        $('#blocktypesModal').modal('toggle');
                        $scope.success("Block types updated successfully");   
                    }
                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
       
    }]);

app.controller('managePaymentHeadingCtrl', ['$scope', 'Data', '$rootScope','Flash','$timeout', function ($scope, Data, $rootScope,Flash,$timeout) {

        $scope.managePaymentHeading = function () {
            Data.post('bms_lists/managePaymentHeading').then(function (response) {
                $scope.PaymentHeadingRow = response.records;
         
                
            });
        };
        
        $scope.getProjectNames = function(){
            Data.post('bms_lists/manageProjectTypes').then(function (response) {
                $scope.getProjectNamesRow = response.records;
               
            });
        }
        $scope.initialModal = function (id, type_of_payment,project_type_id,is_tax_heading,is_date_dependent,index) {

            $scope.heading = 'Project Heading';
            if(id == 0)
            {
                $scope.is_tax_heading = 1;
                $scope.is_date_dependent = 1;
            }else
            {
                $scope.is_tax_heading = is_tax_heading;
                $scope.is_date_dependent = is_date_dependent;
            }
            $scope.id = id;
            $scope.project_type_id = project_type_id;
            $scope.type_of_payment = type_of_payment;
            $scope.index = index;
        }
        $scope.dopaymentheadingAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('bms_lists/createPaymentHeading', { type_of_payment:$scope.type_of_payment,
                    project_type_id: $scope.project_type_id,is_tax_heading:$scope.is_tax_heading,is_date_dependent:$scope.is_date_dependent}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#paymentheadingModal').modal('toggle');
                        $scope.PaymentHeadingRow.push({'type_of_payment': $scope.type_of_payment, 'id': $scope.PaymentHeadingRow.length + 1,'project_type_id': $scope.project_type_id,'is_tax_heading':$scope.is_tax_heading,'is_date_dependent':$scope.is_date_dependent});
                       
                         $scope.success("Payment heading created successfully");   
                    }
                });
            } else { //for update

                Data.post('bms_lists/updatePaymentHeading', {
                     type_of_payment:$scope.type_of_payment,
                    project_type_id: $scope.project_type_id,id:$scope.id,is_tax_heading:$scope.is_tax_heading,is_date_dependent:$scope.is_date_dependent,is_tax_heading:$scope.is_tax_heading,is_date_dependent:$scope.is_date_dependent}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.PaymentHeadingRow.splice($scope.index, 1);
                        $scope.PaymentHeadingRow.splice($scope.index, 0, {
                            'type_of_payment': $scope.type_of_payment, 'id': $scope.id,'project_type_id': $scope.project_type_id,'is_tax_heading':$scope.is_tax_heading,'is_date_dependent':$scope.is_date_dependent});
                        $('#paymentheadingModal').modal('toggle');
                        $scope.success("Payment heading updated successfully");   
                    }
                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
       
    }]);


(function() {

'use strict';

var app = angular.module('ngFlash', []);

app.run(['$rootScope', function ($rootScope) {
    return $rootScope.flashes = [];
}]);

app.directive('dynamic', ['$compile', function ($compile) {
    return {
        restrict: 'A',
        replace: true,
        link: function link(scope, ele, attrs) {
            return scope.$watch(attrs.dynamic, function (html) {
                ele.html(html);
                return $compile(ele.contents())(scope);
            });
        }
    };
}]);

app.directive('closeFlash', ['$compile', '$rootScope', 'Flash', function ($compile, $rootScope, Flash) {
    return {
        link: function link(scope, ele, attrs) {
            return ele.on('click', function () {
                var id = parseInt(attrs.closeFlash, 10);
                Flash.dismiss(id);
                $rootScope.$apply();
            });
        }
    };
}]);

app.directive('flashMessage', ['Flash', function (Flash) {
    return {
        restrict: 'E',
        scope: {
            duration: '=',
            showClose: '=',
            onDismiss: '&'
        },
        template: '<div role="alert" ng-repeat="flash in $root.flashes track by $index" id="{{flash.config.id}}" class="alert {{flash.config.class}} alert-{{flash.type}} alert-dismissible alertIn alertOut"><div type="button" class="close" ng-show="flash.showClose" close-flash="{{flash.id}}"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></div> <span dynamic="flash.text"></span> </div>',
        link: function link(scope, ele, attrs) {
            Flash.setDefaultTimeout(scope.duration);
            Flash.setShowClose(scope.showClose);
            function onDismiss(flash) {
                if (typeof scope.onDismiss !== 'function') return;
                scope.onDismiss({ flash: flash });
            }

            Flash.setOnDismiss(onDismiss);
        }
    };
}]);

app.factory('Flash', ['$rootScope', '$timeout', function ($rootScope, $timeout) {
    var dataFactory = {};
    var counter = 0;
    dataFactory.setDefaultTimeout = function (timeout) {
        if (typeof timeout !== 'number') return;
        dataFactory.defaultTimeout = timeout;
    };

    dataFactory.defaultShowClose = true;
    dataFactory.setShowClose = function (value) {
        if (typeof value !== 'boolean') return;
        dataFactory.defaultShowClose = value;
    };
    dataFactory.setOnDismiss = function (callback) {
        if (typeof callback !== 'function') return;
        dataFactory.onDismiss = callback;
    };
    dataFactory.create = function (type, text, timeout, config, showClose) {
        var $this = undefined,
            flash = undefined;
        $this = this;
        flash = {
            type: type,
            text: text,
            config: config,
            id: counter++
        };
        flash.showClose = typeof showClose !== 'undefined' ? showClose : dataFactory.defaultShowClose;
        if (dataFactory.defaultTimeout && typeof timeout === 'undefined') {
            flash.timeout = dataFactory.defaultTimeout;
        } else if (timeout) {
            flash.timeout = timeout;
        }
        $rootScope.flashes.push(flash);
        if (flash.timeout) {
            flash.timeoutObj = $timeout(function () {
                $this.dismiss(flash.id);
            }, flash.timeout);
        }
        return flash.id;
    };
    dataFactory.pause = function (index) {
        if ($rootScope.flashes[index].timeoutObj) {
            $timeout.cancel($rootScope.flashes[index].timeoutObj);
        }
    };
    dataFactory.dismiss = function (id) {
        var index = findIndexById(id);
        if (index !== -1) {
            var flash = $rootScope.flashes[index];
            dataFactory.pause(index);
            $rootScope.flashes.splice(index, 1);
            $rootScope.$digest();
            if (typeof dataFactory.onDismiss === 'function') {
                dataFactory.onDismiss(flash);
            }
        }
    };
    dataFactory.clear = function () {
        while ($rootScope.flashes.length > 0) {
            dataFactory.dismiss($rootScope.flashes[0].id);
        }
    };
    dataFactory.reset = dataFactory.clear;
    function findIndexById(id) {
        return $rootScope.flashes.map(function(flash) {
            return flash.id;
        }).indexOf(id);
    }

    return dataFactory;
}]);
})()