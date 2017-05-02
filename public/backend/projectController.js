app.controller('projectController', ['$scope', '$state', 'Data', 'toaster', '$timeout', function ($scope, $state, Data, toaster, $timeout) {
        $scope.pageHeading = "Create Project";
        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.projectData = {};
        $scope.createProject = function (projectData) {
            Data.post('projects/', {
                data: projectData,
            }).then(function (response) {
                if (!response.success) {
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
        $scope.manageproject = function ()
        {
            Data.post('projects/getprojects').then(function (response) {
                $scope.projectRow = response.records;
                console.log(response.records);
            });
        }
    }]);
app.controller('basicInfoController', ['$scope', 'Data', 'toaster', 'Upload', '$timeout', function ($scope, Data, toaster, Upload, $timeout) {
        $scope.projectData = $scope.inventoryData = $scope.amenityData = $scope.specificationData = {};
        $scope.statusRow = [];
        $scope.inventoryData.block_availablity = "1";
        $scope.projectData.project_country = $scope.projectData.project_state = $scope.projectData.project_city = "";

        $scope.getProjectDetails = function (projectId) { //get project details
            Data.post('projects/showProjectDetails', {
                data: {projectId: projectId},
            }).then(function (response) {
                if (!response.success) {
                    var project_id = $scope.projectData.project_id;
                    $scope.projectData = {};
                    $scope.projectData.project_id = project_id;
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
                                        data: {countryId: response.details.project_country, stateId: response.details.project_state, cityId: response.details.project_city},
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
                    Data.post('projects/getAmenitiesListOnEdit', {
                        data: response.details.project_amenities_list,
                        async: false,
                    }).then(function (responseAList) {
                        if (!responseAList.success) {
                            $scope.errorMsg = responseAList.message;
                        } else {
                            $scope.projectData = $scope.mapData = $scope.amenityData = $scope.galleryData = angular.copy(response.details);
                            $scope.amenityData.project_amenities_list = angular.copy(responseAList.records);
                            $scope.statusRow = response.projectStatusRecords;
                        }
                    });
                    $scope.wings();
                }
                $scope.projectDetails = true;
            });
        }

        $scope.saveBasicInfo = function (projectData, projectImages) {
            if (angular.equals(projectData, {}) === false || angular.equals(projectImages, {}) === false)
            {
                if (typeof projectImages === 'undefined') {
                    projectImages = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date(), image: false});
                }
                projectImages.upload = Upload.upload({
                    url: getUrl + '/projects/basicInfo',
                    headers: {enctype: 'multipart/form-data'},
                    data: {project_id: $scope.projectData.project_id, projectData: projectData, projectImages: projectImages},
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
        $scope.saveInventoryInfo = function (wingId, inventoryData) {
            inventoryData.wing_id = wingId;
            Data.post('projects/basicInfo', {project_id: $scope.projectData.project_id, inventoryData: inventoryData}).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    toaster.pop('success', 'Project', response.message);
                }
            });
        }
        $scope.saveStatusInfo = function (statusData, statusImages) {

            if (typeof statusImages === 'undefined') {
                statusImages = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date(), image: false});
            }
            statusImages.upload = Upload.upload({
                url: getUrl + '/projects/basicInfo',
                headers: {enctype: 'multipart/form-data'},
                data: {project_id: $scope.projectData.project_id, statusData: statusData, projectImages: statusImages},
            });
            statusImages.upload.then(function (response) {
                if (!response.data.success) {
                    $scope.errorMsg = response.message;
                } else {
                    toaster.pop('success', 'Project', response.message);
                    $scope.statusRow = response.records;
                }
            }, function (response) {
                if (response.status !== 200) {
                    $scope.errorMsg = "Something went wrong.";
                }
            });
        }
        $scope.wingList = $scope.floorList = $scope.popupData = [];
        $scope.wings = function () {
            Data.post('projects/getWings', {data: {projectId: $scope.projectData.project_id}}).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.wingList = response.records;
                }
            });
        }
        $scope.selectFloor = function (wingId) {
            $scope.modalData.floors = {};
            $scope.floorList = [];
            for (var i = 0; i < $scope.wingList.length; i++) {
                if ($scope.wingList[i].id == wingId) {
                    for (var j = 1; j <= $scope.wingList[i].number_of_floors; j++) {
                        var obj = {
                            id: j,
                            wingId: wingId,
                            floor_name: "floor " + j
                        };
                        $scope.floorList.push(obj);
                    }
                }
            }
        }
        $scope.resetSpecificationDetails = function () {
            $scope.modalData = $scope.modalProjectImages = {};
        }
        $scope.specicationRow = function (modalData, modalImages) {
            if (typeof modalImages === 'undefined') {
                modalImages = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date(), image: false});
            }
            modalImages.upload = Upload.upload({
                url: getUrl + '/projects/basicInfo',
                headers: {enctype: 'multipart/form-data'},
                data: {project_id: $scope.projectData.project_id, statusData: modalData, projectImages: modalImages},
            });
            modalImages.upload.then(function (response) {
                if (!response.data.success) {
                    $scope.errorMsg = response.message;
                } else {
                    toaster.pop('success', 'Project', response.message);
                    $scope.statusRow = response.records;
                }
            }, function (response) {
                if (response.status !== 200) {
                    $scope.errorMsg = "Something went wrong.";
                }
            });
//        $scope.popupData.push(modalData);
//        console.log($scope.popupData);

        }
    }]);

app.controller('wingCtrl', function ($scope, Data) {
    $scope.wingList = [];
    Data.post('projects/getWings', {data: {projectId: $scope.projectData.project_id}}).then(function (response) {
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

