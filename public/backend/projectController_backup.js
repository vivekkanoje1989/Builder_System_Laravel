app.controller('projectController', ['$scope', '$state', 'Data', 'toaster', '$timeout', function ($scope, $state, Data, toaster, $timeout) {
    $scope.pageHeading = "Create Project";
    $scope.projectDetails = false;
    $scope.projectData = {};
    $scope.createProject = function(projectData){
        Data.post('projects/',{
            data: projectData,
        }).then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.projectSbtBtn = true;
                toaster.pop('success', 'Project Details', 'Project created successfully');
                $timeout(function () {
                    $state.go(getUrl + '.createProjectsIndex');
                },1000);
            }
        });
    }
}]);
app.controller('basicInfoController', ['$scope', 'Data', 'toaster', 'Upload','$timeout', function ($scope, Data, toaster, Upload, $timeout) {
    $scope.projectData = {};
    $scope.inventoryData = {};
    $scope.inventoryData.block_availablity = "1";
    //$scope.basicData = $scope.contactData = $scope.seoData = $scope.mapData = $scope.imagesData = {};
    $scope.projectData.alias_status = "0";
    $scope.projectData.project_country = $scope.projectData.project_state = $scope.projectData.project_city = "";
    $scope.getProjectDetails = function(projectId){
        Data.post('projects/showProjectDetails',{
            data: {projectId: projectId},
        }).then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                Data.post('getStates', {
                    data: {countryId: response.details.project_country},
                }).then(function (responseState) {
                    if (!responseState.success) {
                        $scope.errorMsg = responseState.message;
                    } else {
                        $scope.stateList = responseState.records;     
                        Data.post('getCities', {
                            data: {stateId: response.details.project_state},
                        }).then(function (responseCity) {
                            if (!responseCity.success) {
                                $scope.errorMsg = responseCity.message;
                            } else {
                                $scope.cityList = responseCity.records;
                                Data.post('getLocations', {
                                   data: {countryId: response.details.project_country,stateId: response.details.project_state,cityId: response.details.project_city},
                                }).then(function (response) {
                                    if (!response.success) {
                                        $scope.errorMsg = response.message;
                                    } else {
                                        $scope.locationList = response.records;
                                    }
                                });
                            }
                        });
                    }
                });
                Data.post('projects/getAmenitiesListOnEdit',{
                    data: response.details.project_amenities_list,
                    async:false,
                }).then(function (responseAList) {
                    if (!responseAList.success) {
                        $scope.errorMsg = responseAList.message;
                    } else {       
                        $scope.projectData = angular.copy(response.details);
                        $scope.projectData.project_amenities_list = angular.copy(responseAList.records);
                    }
                });
                
                $scope.projectDetails = true;
            }
        });
    }    
    
    
    $scope.saveBasicInfo = function(projectData, projectImages){
        
        if(angular.equals(projectData, {}) === false || angular.equals(projectImages, {}) === false)
        {   
            if (typeof projectImages === 'undefined') {
                projectImages = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date(), image: false});
            }
            
            projectImages.upload = Upload.upload({
                url: getUrl + '/projects/basicInfo',
                headers: {enctype: 'multipart/form-data'},
                data: {projectData: projectData, projectImages: projectImages, projectId: $scope.projectData.project_id},
            });
            projectImages.upload.then(function (response) { 
                if (!response.data.success) { 
                    $scope.errorMsg = response.message;
                } else {
                    $scope.projectSbtBtn = true;
                    toaster.pop('success', 'Project Details', 'Project created successfully');
                    $timeout(function () {
                        $state.go(getUrl + '.createProjectsIndex');
                    }, 1000);
                }
            });
        }
    }
//    $scope.saveContactInfo = function(contactData){
//        $scope.saveBasicInfo(contactData);
//    }
//    $scope.saveSeoInfo = function(seoData){
//        $scope.saveBasicInfo(seoData);
//    }
    $scope.saveInventoryInfo = function(wingId,inventoryData){
        
        inventoryData.wing_id = wingId;
        Data.post('projects/basicInfo',{
            data: {inventoryData: inventoryData, projectId: $scope.projectData.project_id},
        }).then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {       
                toaster.pop('success', 'Project', response.message);
            }
        });
    }
    
}]);
app.controller('basicInfoController', ['$scope', 'Data', 'toaster', 'Upload', function ($scope, Data, toaster, Upload) {
        $scope.basicData = $scope.contactData = $scope.seoData = $scope.mapData = $scope.imagesData = {};
        $scope.basicData.alias_status = "0";

        $scope.saveBasicInfo = function (projectData, projectImages) {
            projectData = (typeof projectData === 'undefined') ? [] : projectData;
            if (angular.equals(projectData, {}) === false || angular.equals(projectImages, {}) === false)
            {
                console.log(projectImages);
                if (typeof projectImages === 'undefined') {
                    projectImages = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date(), image: false});
                }

                projectImages.upload = Upload.upload({
                    url: getUrl + '/projects/basicInfo',
                    headers: {enctype: 'multipart/form-data'},
                    data: {projectData: projectData, projectImages: projectImages, projectId: $scope.projectData.project_id},
                });
                projectImages.upload.then(function (response) {
                    if (!response.data.success) {
                        $scope.errorMsg = response.message;
                    } else {
                        toaster.pop('success', 'Project', response.message);
                        angular.element('.btn-next').trigger('click');
                    }
                }, function (response) {
                    if (response.status !== 200) {
                        $scope.errorMsg = "Something went wrong.";
                    }
                });
            }
        }
        $scope.saveContactInfo = function (contactData) {
            $scope.saveBasicInfo(contactData);
        }
        $scope.saveSeoInfo = function (seoData) {
            $scope.saveBasicInfo(seoData);
        }
//        $scope.FetchProjectData = function (id)
//        {
//            if (id > 0)
//            {
//                Data.post('projects/getProjectInfo', {
//                    id: id,
//                }).then(function (response) {
//                    console.log(response);
//                    $scope.projectImages = angular.copy(response.records[0]);
//                   // $scope.project_logo = angular.copy(response.records[0].project_logo);
//                })
//            }
//        }
    }]);

app.controller('wingCtrl', function ($scope, Data) {
    Data.get('projects/getWings').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.wingList = response.records;
        }
    Data.get('projects/getBlocks').then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.blockList = response.records;
            }
        });
    });
});
app.controller('blockTypeCtrl', function ($scope, Data) {
    Data.get('projects/getBlocks').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.blockList = response.records;
        }
    });
});

app.controller('projectTypeCntrl', function ($scope, Data) {
    Data.get('projects/projectType').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.typeList = response.records;
        }
    });
});

app.controller('projectStatusCntrl', function ($scope, Data) {
    Data.get('projects/projectStatus').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.statusList = response.records;
        }
    });
});

