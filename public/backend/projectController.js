app.controller('projectController', ['$scope', '$state', 'Data', 'toaster', '$timeout', function ($scope, $state, Data, toaster, $timeout) {
    $scope.pageHeading = "Create Project";
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
app.controller('basicInfoController', ['$scope', 'Data', 'toaster', 'Upload', function ($scope, Data, toaster, Upload) {
    $scope.basicData = $scope.contactData = $scope.seoData = $scope.mapData = $scope.imagesData = {};
    $scope.basicData.alias_status = "0";
    
    $scope.saveBasicInfo = function(projectData, projectImages){
        if(angular.equals(projectData, {}) === false || angular.equals(projectImages, {}) === false)
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
                } else{
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
    $scope.saveContactInfo = function(contactData){
        $scope.saveBasicInfo(contactData);
    }
    $scope.saveSeoInfo = function(seoData){
        $scope.saveBasicInfo(seoData);
    }
}]);

app.controller('wingCtrl', function ($scope, Data) {
    Data.get('projects/getWings').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.wingList = response.records;
        }
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

