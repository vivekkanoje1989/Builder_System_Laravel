app.controller('projectController', ['$rootScope','$scope', '$state', 'Data', 'toaster', '$timeout', '$stateParams', 'Upload', function ($rootScope, $scope, $state, Data, toaster, $timeout, $stateParams, Upload) {
        $scope.pageHeading = "Create Project";
        $scope.showAllTabs = true;
        $scope.projectData = {};
        $scope.mapData = {};
        $scope.contactData = {};
        $scope.seoData =  {};
        $scope.inventoryData = {};
        $scope.amenityData = {};
        $scope.galleryData = {};
        $scope.specificationData = {};
        $scope.statusRow = [];
        $scope.statusImages = [];
        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.searchDetails = {};
        $scope.searchData = {};
        $scope.lmodalForm = {};
        
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

        $scope.projectData.project_country = $scope.projectData.project_state = $scope.projectData.project_city = "";
        
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
                        $state.go('manageProjectIndex');
                    }, 1000);
                }
            });
        }
        
        $scope.webpageSettings = function (prid, settingData) {
            
            if (settingData === '') { //for data
                Data.post('projects/webpageSettings', {
                    getDataByPrid: prid,
                }).then(function (response) {
                    if(response.success){
                        $scope.projectData = angular.copy(response.settingData);
                        $scope.projectData.project_id = response.settingData.project_id;
                        $scope.projectData.prid = response.settingData.project_id;
                        $scope.contactData = angular.copy(response.settingData);
                        $scope.seoData = angular.copy(response.settingData);
                        Data.post('getStates', {
                             data: {countryId: response.settingData.project_country},
                        }).then(function (responseState) {
                             if (!responseState.success) {
                                 $scope.errorMsg = responseState.message;
                             } else {
                                 $scope.stateList = responseState.records;
                                 $scope.contactData.project_state = angular.copy(response.settingData.project_state);
                                 Data.post('getCities', {
                                     data: {stateId: response.settingData.project_state},
                                 }).then(function (responseCity) {
                                     if (!responseCity.success) {
                                         $scope.errorMsg = responseCity.message;
                                     } else {
                                         $scope.cityList = responseCity.records;
                                         Data.post('getLocations', {
                                             data: {countryId: response.settingData.project_country, stateId: response.settingData.project_state, cityId: response.settingData.project_city},
                                         }).then(function (responseLoc) {
                                             if (!responseLoc.success) {
                                                 $scope.errorMsg = responseLoc.message;
                                             } else {
                                                 $scope.locationList = responseLoc.records;
                                             }
                                         });
                                     }
                                 });
                             }
                         });
                         $scope.showAllTabs = false;
                    }else{
                        $scope.projectData.project_id = prid;
                        $scope.projectData.prid = prid;
                        $scope.showAllTabs = true;
                    }
                });
            }else{ //for create or update
                Data.post('projects/webpageSettings', {
                    getDataByPrid: prid,settingData:settingData
                }).then(function (response) {
                    $scope.projectData = $scope.contactData = $scope.seoData = settingData;
                    $scope.projectData.project_id = prid;
                    $scope.projectData.prid = prid;
                });
            }
        }
        
        $scope.uploadsData = function (prid, uploadData, otherData){
            if (uploadData === "" && otherData === "") { //for display data
                Data.post('projects/uploadsData', {
                    getDataByPrid: prid,
                }).then(function (response) {
<<<<<<< HEAD
                    console.log(response);
=======
                   $scope.projectImages = response.uploadData;
                });
            }
        }

//}]);
//app.controller('basicInfoController', ['$scope', 'Data', 'toaster', 'Upload', '$timeout', '$state', '$stateParams', function ($scope, Data, toaster, Upload, $timeout, $state, $stateParams) {
        $scope.projectData = $scope.contactData = $scope.seoData = $scope.mapData = $scope.inventoryData = $scope.amenityData = $scope.galleryData = $scope.specificationData = {};
        $scope.statusRow = [];
        $scope.statusImages = [];
        $scope.specificationTitle = [];
        $scope.floorTitle = [];
        $scope.layoutTitle = [];
        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.lmodalForm = {};

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

        $scope.projectData.project_country = $scope.projectData.project_state = $scope.projectData.project_city = "";

        $scope.manageproject = function ()
        {
            Data.get('projects/manageProjects').then(function (response) {
                $scope.projectRow = response.records;
                $scope.exportData = response.exportData;
            });
        }
       
        
        
        $scope.manageProjectsExportToExcel = function () {
            $scope.getexcel = window.location = "/projects/manageProjectsExportToExcel";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        }

        $scope.searchDetails = {};
        $scope.searchData = {};

        $scope.filterDetails = function (search) {
            if (search.joining_date != undefined) {
                var today = new Date(search.joining_date);
                search.joining_date = (today.getFullYear() + '-' + ("0" + (today.getMonth() + 1)).slice(-2) + '-' + today.getDate());
            }
            if (search.login_date_time != undefined) {
                var loginDate = new Date(search.login_date_time);
                search.login_date_time = (loginDate.getDate() + '-' + ("0" + (loginDate.getMonth() + 1)).slice(-2) + '-' + loginDate.getFullYear());
            }
            $scope.searchData = search;

        }
        $scope.removeFilterData = function (keyvalue) {
            delete $scope.searchData[keyvalue];
            $scope.filterDetails($scope.searchData);
        }
        $scope.closeModal = function () {
            $scope.searchData = {};
        }
        $scope.resetLayoutDetails = function () {
            $scope.lmodalForm = {};
        }

        $scope.getProjectDetails = function (projectId) { //get project details
            Data.get('projects/getProjectDetails/' + projectId).then(function (response) {
                if (!response.success) {
                    $scope.projectData = $scope.contactData = $scope.seoData = $scope.mapData = $scope.inventoryData = $scope.amenityData = $scope.galleryData = $scope.specificationData = {};
                    $scope.statusRow = $scope.statusImages = $scope.specificationTitle = $scope.floorTitle = $scope.layoutTitle = [];
                    $scope.project_logo = $scope.project_thumbnail = $scope.project_favicon = $scope.project_banner_images = $scope.project_background_images = $scope.project_brochure = $scope.project_favicon = $scope.location_map_images = $scope.amenities_images = $scope.project_gallery = [];
                    $scope.projectData.project_id = projectId;
                    $scope.wingList = $scope.floorList = [];
                    $scope.notFound = true;
                } else {
                    Data.post('getStates', {
                        data: {countryId: response.details.project_country},
                    }).then(function (responseState) {
                        if (!responseState.success) {
                            $scope.errorMsg = responseState.message;
                        } else {
                            $scope.stateList = responseState.records;
                            $scope.contactData.project_state = angular.copy(response.details.project_state);
                            Data.post('getCities', {
                                data: {stateId: response.details.project_state},
                            }).then(function (responseCity) {
                                if (!responseCity.success) {
                                    $scope.errorMsg = responseCity.message;
                                } else {
                                    $scope.cityList = responseCity.records;
                                    Data.post('getLocations', {
                                        data: {countryId: response.details.project_country, stateId: response.details.project_state, cityId: response.details.project_city},
                                    }).then(function (responseLoc) {
                                        if (!responseLoc.success) {
                                            $scope.errorMsg = responseLoc.message;
                                        } else {
                                            $scope.locationList = responseLoc.records;
                                        }
                                    });
                                }
                            });
                        }
                    });
>>>>>>> b0e951a59ff80c4b7d77329a62146306fb91bfa8
                    Data.post('projects/getAmenitiesListOnEdit', {
                        data: response.uploadData.project_amenities_list,
                        async: false,
                    }).then(function (responseAList) {
                        if (!responseAList.success) {
                            $scope.errorMsg = responseAList.message;
                        } else {
                            $timeout(function(){
                                $scope.amenityData.project_amenities_list = angular.copy(responseAList.records);
                            },200);
                            
                            $scope.project_logo = $scope.project_thumbnail = $scope.project_favicon = $scope.project_banner_images = $scope.project_background_images = $scope.project_brochure = $scope.project_favicon = $scope.location_map_images = $scope.amenities_images = $scope.project_gallery = [];
                            //$scope.projectImages = response.uploadData;
                            $scope.mapData.google_map_iframe = (response.uploadData.google_map_iframe !== null && response.uploadData.google_map_iframe !== "null") ? response.uploadData.google_map_iframe : "";
                            $scope.mapData.google_map_short_url = (response.uploadData.google_map_short_url !== null && response.uploadData.google_map_short_url !== "null") ? response.uploadData.google_map_short_url : "";
                            $scope.galleryData.video_link = (response.uploadData.video_link !== null && response.uploadData.video_link !== "null") ? response.uploadData.video_link : "";
                            $scope.galleryData.video_short_link = (response.uploadData.video_short_link !== null && response.uploadData.video_short_link !== "null") ? response.uploadData.video_short_link : "";
                            $scope.amenityData.amenities_description = (response.uploadData.amenities_description !== null && response.uploadData.amenities_description !== "null") ? response.uploadData.amenities_description : "";             
                            $scope.specificationData.specification_description = (response.uploadData.specification_description !== null && response.uploadData.specification_description !== "null") ? response.uploadData.specification_description : "";
                            
                            $scope.projectData.prid = response.uploadData.project_id;
                            $scope.project_logo = (response.uploadData.project_logo !== null && response.uploadData.project_logo !== "null") ? response.uploadData.project_logo.split(',') : [];
                            $scope.project_thumbnail = (response.uploadData.project_thumbnail !== null && response.uploadData.project_thumbnail !== "null") ? response.uploadData.project_thumbnail.split(',') : [];
                            $scope.project_favicon = (response.uploadData.project_favicon !== null && response.uploadData.project_favicon !== "null") ? response.uploadData.project_favicon.split(',') : [];
                            $scope.project_banner_images = (response.uploadData.project_banner_images !== null && response.uploadData.project_banner_images !== "null") ? response.uploadData.project_banner_images.split(',') : [];
                            $scope.project_background_images = (response.uploadData.project_background_images !== null && response.uploadData.project_background_images !== "null") ? response.uploadData.project_background_images.split(',') : [];
                            $scope.project_brochure = (response.uploadData.project_brochure !== null && response.uploadData.project_brochure !== "null") ? response.uploadData.project_brochure.split(',') : [];
                            $scope.location_map_images = (response.uploadData.location_map_images !== null && response.uploadData.location_map_images !== "null") ? response.uploadData.location_map_images.split(',') : [];
                            $scope.amenities_images = (response.uploadData.amenities_images !== null && response.uploadData.amenities_images !== "null") ? response.uploadData.amenities_images.split(',') : [];
                            $scope.project_gallery = (response.uploadData.project_gallery !== null && response.uploadData.project_gallery !== "null") ? response.uploadData.project_gallery.split(',') : [];
                            
                            $scope.specificationTitle = response.specificationTitle;
                            $scope.floorTitle = response.floorTitle;
                            $scope.layoutTitle = response.layoutTitle;
                            $scope.statusRow = response.getProjectStatusRecords;
                            for (var i = 0; i < response.getProjectStatusRecords.length; i++) {
                                var array = response.getProjectStatusRecords[i].images.split(',');
                                $scope.statusImages.push(array);
                            }
                        }
                    });
                    $scope.getWings();
                    $scope.getBlocks();
                });
            }
            else{ //for insert or update
                $scope.sbtbtnFiles = true;
                if (typeof uploadData === 'undefined') {
                    uploadData = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date(), image: false});
                }
                uploadData.upload = Upload.upload({
                    url: '/projects/uploadsData',
                    headers: {enctype: 'multipart/form-data'},
                    data: {getDataByPrid: prid, projectImages: uploadData, projectData:otherData},
                });
                uploadData.upload.then(function (response) {console.log(response);
                    if (!response.data.success) {
                        $scope.errorMsg = response.data.message;
                    } else {
                        $scope.sbtbtnFiles = false;
                        $scope.uploadData = otherData = "";
                        toaster.pop('success', 'Project', response.data.message);
                    }
                }, function (response) {
                    if (response.data.status !== 200) {
                        $scope.errorMsg = "Something went wrong.";
                    }
                });
            }
        }

        $scope.saveInventoryInfo = function (prid, wingId, inventoryData) {
            inventoryData.wing_id = wingId;
            Data.post('projects/uploadsData', {getDataByPrid: prid, inventoryData: inventoryData}).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    toaster.pop('success', 'Project', response.message);
                }
            });
        }
        $scope.saveStatusInfo = function (prid, statusImages, statusData) {
            if (typeof statusImages === 'undefined') {
                statusImages = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date(), image: false});
            }
            statusImages.upload = Upload.upload({
                url: '/projects/uploadsData',
                headers: {enctype: 'multipart/form-data'},
                data: {getDataByPrid: prid, statusData: statusData, projectImages: statusImages},
            });
            statusImages.upload.then(function (response) {
                if (!response.data.success) {
                    $scope.errorMsg = response.data.message;
                } else {
                    toaster.pop('success', 'Project', response.data.message);
                    $('#statusForm')[0].reset();
                    $('.editor-text p').text("");
                    $(".img-div2").empty();
                    $scope.images_preview = [];
                    $scope.statusImages = [];
                    $scope.statusRow = response.data.records;
                    for (var i = 0; i < response.data.records.length; i++) {
                        var array = response.data.records[i].images.split(',');
                        $scope.statusImages.push(array);
                    }
                }
            }, function (response) {
                if (response.data.status !== 200) {
                    $scope.errorMsg = "Something went wrong.";
                }
            });
        }
        $scope.delStatusRecord = function (statusId, selectedImages) {
            Data.post('projects/deleteStatus', {data: {statusId: statusId, selectedImages: selectedImages}}).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $("tr#del_" + statusId).remove();
                }
            });
        }

        $scope.manageproject = function (){
            Data.get('projects/manageProjects').then(function (response) {
                $scope.projectRow = response.records;
                $scope.exportData = response.exportData;
            });
        }
        
        $scope.resetLayoutDetails = function () {
            $scope.lmodalForm = {};
        }
        
        $scope.showWebPage = function (id) {
            $scope.showloader();
            $state.go('projectWebPage');
            $scope.hideloader();
            $timeout(function () {
                $("#project_id").val(id);
                $("#project_id").change();
                $scope.projectData.project_id = id;
                $scope.getProjectDetails(id);
            }, 1000);
        }
      
        /*********************************Specification & floor plan Code Start***************************************/
        $scope.wingList = $scope.floorList = [];
        $scope.getWings = function () {
            Data.post('projects/getWings', {data: {projectId: $scope.projectData.project_id}}).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.wingList = response.records;
                    $scope.notFound = false;
                }
            });
        }
        $scope.getBlocks = function () {
            $scope.blockList = {};
            Data.post('projects/getBlocks', {data: {projectId: $scope.projectData.project_id}}).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.blockList = response.records;
                }
            });
        }
        $scope.selectFloor = function (wingId) {
            $scope.floorList = [];
            for (var i = 0; i < $scope.wingList.length; i++) {
                if ($scope.wingList[i].id == wingId) {
                    for (var j = 1; j <= $scope.wingList[i].number_of_floors; j++) {
                        var obj = {
                            id: j,
                            floorName: "floor " + j,
                            wingId: wingId
                        };
                        $scope.floorList.push(obj);
                    }
                }
            }
        }
        $scope.resetSpecificationDetails = function () {
            $scope.modalData = {};
            $scope.specification_images = {};
            $scope.floor_plan_images = {};
            $scope.layout_plan_images = {};
        }
        $scope.specicationRow = function (prid, modalData, modalImages, objName) { //specificationData
            if (typeof modalImages === 'undefined') {
                modalImages = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date(), image: false});
            }
            if (objName === "specificationData") {
                var customData = {getDataByPrid: prid, specificationData: {modalData: modalData}, projectImages: modalImages, objName: objName};
            } else if (objName === "floorData") {
                var customData = {getDataByPrid: prid, floorData: {modalData: modalData}, projectImages: modalImages, objName: objName};
            }
            modalImages.upload = Upload.upload({
                url: '/projects/uploadsData',
                headers: {enctype: 'multipart/form-data'},
                data: customData,
            });
            modalImages.upload.then(function (response) {

                if (!response.data.success) {
                    $scope.errorMsg = response.message;
                } else {
                    if (objName === "specificationData") {
                        $scope.specificationTitle.push(response.data.specificationTitle);
                        $scope.specification_images = {};
                        $('#specificationDataModal').modal('toggle');
                    }
                    if (objName === "floorData") {
                        $scope.floorTitle.push(response.data.specificationTitle);
                        $scope.floor_plan_images = {};
                        $('#floorDataModal').modal('toggle');
                    }
                    toaster.pop('success', 'Project', response.data.message);
                }
            }, function (response) {
                if (response.status !== 200) {
                    $scope.errorMsg = "Something went wrong.";
                }
            });

        }
        /*********************************Specification & floor plan Code End***************************************/

        $scope.layoutRow = function (prid, modalImages, modalData) { //specificationData
            if (typeof modalImages === 'undefined') {
                modalImages = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date(), image: false});
            }
            modalImages.upload = Upload.upload({
                url: '/projects/uploadsData',
                headers: {enctype: 'multipart/form-data'},
                data: {getDataByPrid: prid, layoutData: {modalData: modalData}, projectImages: modalImages},
            });
            modalImages.upload.then(function (response) {

                if (!response.data.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.layoutTitle.push(response.data.layoutTitle);
                    $scope.layout_plan_images = {};
                    $timeout(function () {
                        $('#layoutDataModal').modal('toggle');
                        toaster.pop('success', 'Project', response.data.message);
                        $(".modal-backdrop").hide();
                        $("#project_id").val(1);                        
                        $scope.projectDetails = true;
                    }, 200);
                }
            }, function (response) {
                if (response.status !== 200) {
                    $scope.errorMsg = "Something went wrong.";
                }
            });
        }

        $scope.getInventoryDetails = function (id) {
            Data.post('projects/getInventoryDetails', {data: {projectId: $scope.projectData.project_id, wingId: id}}).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.inventoryData = angular.copy(response.records[0]);
                }
            });
        }

        $scope.deleteImage = function (selectedImg, delImgName, index, tblRowId, folderName, tblFieldName)
        {
            if (window.confirm("Are you sure want to remove this image?"))
            {
                if (index > -1) {
                    selectedImg.splice(index, 1);
                    Data.post('projects/deleteImage', {
                        selectedImg: selectedImg, tblRowId: tblRowId, delImgName: delImgName, folderName: folderName, tblFieldName: tblFieldName,
                    }).then(function (response) {
                        if (!response.success) {
                            $scope.errorMsg = response.message;
                        } else {
                            $("div#del_" + tblFieldName + "_" + index).remove();
                        }
                    });
                }
            }
        }
        
        $scope.closeModal = function () {
            $scope.searchData = {};
        }
        $scope.manageProjectsExportToExcel = function () {
            $scope.getexcel = window.location = "/projects/manageProjectsExportToExcel";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting Data');
            } else {
                toaster.pop('error', '', 'Exporting Data Fails');
            }
        }
        $scope.filterDetails = function (search) {
            if (search.joining_date != undefined) {
                var today = new Date(search.joining_date);
                search.joining_date = (today.getFullYear() + '-' + ("0" + (today.getMonth() + 1)).slice(-2) + '-' + today.getDate());
            }
            if (search.login_date_time != undefined) {
                var loginDate = new Date(search.login_date_time);
                search.login_date_time = (loginDate.getDate() + '-' + ("0" + (loginDate.getMonth() + 1)).slice(-2) + '-' + loginDate.getFullYear());
            }
            $scope.searchData = search;

        }
        $scope.removeFilterData = function (keyvalue) {
            delete $scope.searchData[keyvalue];
            $scope.filterDetails($scope.searchData);
        }
        
}]);
app.filter('split', function () {
    return function (input, splitChar, splitIndex) {
        // do some bounds checking here to ensure it has that index
        return input.split(splitChar)[splitIndex];
    }
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

app.directive('ngConfirmClick', [
    function () {
        return {
            link: function (scope, element, attr) {
                var msg = attr.ngConfirmClick || "Are you sure?";
                var clickAction = attr.confirmedClick;
                element.bind('click', function (event) {
                    if (window.confirm(msg)) {
                        scope.$eval(clickAction)
                    }
                });
            }
        };
    }]);
    
    
    
    /*$scope.getProjectDetails = function (projectId) { //get project details
            Data.get('projects/getProjectDetails/' + projectId).then(function (response) {
                if (!response.success) {
                    $scope.projectData = $scope.contactData = $scope.seoData = $scope.mapData = $scope.inventoryData = $scope.amenityData = $scope.galleryData = $scope.specificationData = {};
                    $scope.statusRow = $scope.statusImages = $scope.specificationTitle = $scope.floorTitle = $scope.layoutTitle = [];
                    $scope.project_logo = $scope.project_thumbnail = $scope.project_favicon = $scope.project_banner_images = $scope.project_background_images = $scope.project_brochure = $scope.project_favicon = $scope.location_map_images = $scope.amenities_images = $scope.project_gallery = [];
                    $scope.projectData.project_id = projectId;
                    $scope.wingList = $scope.floorList = [];
                    $scope.notFound = true;
                } else {
                    Data.post('getStates', {
                        data: {countryId: response.details.project_country},
                    }).then(function (responseState) {
                        if (!responseState.success) {
                            $scope.errorMsg = responseState.message;
                        } else {
                            $scope.stateList = responseState.records;
                            $scope.contactData.project_state = angular.copy(response.details.project_state);
                            Data.post('getCities', {
                                data: {stateId: response.details.project_state},
                            }).then(function (responseCity) {
                                if (!responseCity.success) {
                                    $scope.errorMsg = responseCity.message;
                                } else {
                                    $scope.cityList = responseCity.records;
                                    Data.post('getLocations', {
                                        data: {countryId: response.details.project_country, stateId: response.details.project_state, cityId: response.details.project_city},
                                    }).then(function (responseLoc) {
                                        if (!responseLoc.success) {
                                            $scope.errorMsg = responseLoc.message;
                                        } else {
                                            $scope.locationList = responseLoc.records;
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
                            $scope.project_logo = $scope.project_thumbnail = $scope.project_favicon = $scope.project_banner_images = $scope.project_background_images = $scope.project_brochure = $scope.project_favicon = $scope.location_map_images = $scope.amenities_images = $scope.project_gallery = [];
                            //$scope.projectData = $scope.contactData = $scope.seoData = $scope.mapData = $scope.amenityData = $scope.galleryData = $scope.specificationData = angular.copy(response.details);
                                                        
                            $scope.project_logo = (response.details.project_logo !== null && response.details.project_logo !== "null") ? response.details.project_logo.split(',') : [];
                            $scope.project_thumbnail = (response.details.project_thumbnail !== null && response.details.project_thumbnail !== "null") ? response.details.project_thumbnail.split(',') : [];
                            $scope.project_favicon = (response.details.project_favicon !== null && response.details.project_favicon !== "null") ? response.details.project_favicon.split(',') : [];
                            $scope.project_banner_images = (response.details.project_banner_images !== null && response.details.project_banner_images !== "null") ? response.details.project_banner_images.split(',') : [];
                            $scope.project_background_images = (response.details.project_background_images !== null && response.details.project_background_images !== "null") ? response.details.project_background_images.split(',') : [];
                            $scope.project_brochure = (response.details.project_brochure !== null && response.details.project_brochure !== "null") ? response.details.project_brochure.split(',') : [];
                            $scope.location_map_images = (response.details.location_map_images !== null && response.details.location_map_images !== "null") ? response.details.location_map_images.split(',') : [];
                            $scope.amenities_images = (response.details.amenities_images !== null && response.details.amenities_images !== "null") ? response.details.amenities_images.split(',') : [];
                            $scope.project_gallery = (response.details.project_gallery !== null && response.details.project_gallery !== "null") ? response.details.project_gallery.split(',') : [];
                            $scope.amenityData.project_amenities_list = angular.copy(responseAList.records);

                            $scope.specificationTitle = response.specificationTitle;
                            $scope.floorTitle = response.floorTitle;
                            $scope.layoutTitle = response.layoutTitle;
                            $scope.statusRow = response.projectStatusRecords;
                            for (var i = 0; i < response.projectStatusRecords.length; i++) {
                                var array = response.projectStatusRecords[i].images.split(',');
                                $scope.statusImages.push(array);
                            }
                            $scope.inventoryData = angular.copy(response.getProjectInventory);
                        }
                    });
                    $scope.getWings();
                    $scope.getBlocks();
                    $scope.getInventoryDetails(0);
                }
                $scope.projectDetails = true;
            });
        }*/

     /*$scope.saveBasicInfo = function (projectData, projectImages) {
            console.log(projectImages);
            if (angular.equals(projectData, {}) === false || angular.equals(projectImages, {}) === false)
            {
                if (typeof projectImages === 'undefined') {
                    projectImages = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date(), image: false});
                }
                projectImages.upload = Upload.upload({
                    url: '/projects/basicInfo',
                    headers: {enctype: 'multipart/form-data'},
                    data: {project_id: $scope.projectData.project_id, projectData: projectData, projectImages: projectImages},
                });
                projectImages.upload.then(function (response) {
                    if (!response.data.success) {
                        $scope.errorMsg = response.message;
                    } else {
                        $state.reload();
                        toaster.pop('success', 'Project', response.data.message);
//                    angular.element('.btn-next').trigger('click');
                    }
                }, function (response) {
                    if (response.data.status !== 200) {
                        $scope.errorMsg = "Something went wrong.";
                    }
                });
            }
        }*/