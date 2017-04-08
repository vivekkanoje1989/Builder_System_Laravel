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
app.controller('basicInfoController', ['$scope', '$state', 'Data', 'toaster', '$timeout', function ($scope, Data, toaster) {
    $scope.basicData = $scope.contactData = $scope.seoData = {};
    $scope.basicData.alias_status = "0";
    $scope.saveBasicInfo = function(basicData){
        if(angular.equals(basicData, {}) === false)
        {   
            Data.post('projects/basicInfo',{
                data: {basicData: basicData, projectId: $scope.projectData.project_id},
            }).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    toaster.pop('success', 'Project', response.message);
                    angular.element('.btn-next').trigger('click');
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
app.controller('imagesController', ['$scope', '$state', 'Data', 'toaster', '$timeout', function ($scope, Data, toaster) {
    $scope.imagesData = {};
    $scope.imagesInfo = function(imagesData){
        if(angular.equals(imagesData, {}) === false)
        {   
            Data.post('projects/basicInfo',{
                data: {imagesData: imagesData, projectId: $scope.projectData.project_id},
            }).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    toaster.pop('success', 'Project', response.message);
                    angular.element('.btn-next').trigger('click');
                }
            });
        }
    }  
        
}]);
app.controller('projectCntrl', function ($scope, Data) {
    Data.get('projects/getProjects').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.projectList = response.records;
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

