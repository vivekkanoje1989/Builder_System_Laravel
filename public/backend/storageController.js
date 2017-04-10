app.controller('storageCtrl', ['$scope', 'Data', '$state', 'Upload', '$timeout', function ($scope, Data, $state, Upload, $timeout) {

       
        $scope.dostorageFormAction = function ()
        {
            Data.post('storage-list/', {
                filename: $scope.filename}).then(function (response) {
                $scope.directories.push($scope.filename);
                $("#storageModel").modal('toggle');
            });
        };
        $scope.initialModal = function()
        {
             $scope.sbtBtn = false;
        };
        $scope.getEmployees = function () {
            Data.get('getEmployees').then(function (response) {
                $scope.employeeRow = response.records;
            });
        };
        
        $scope.sharedFormWith = function(foldername)
        {
             Data.post('storage-list/sharedWith', {
                folder: foldername,share_with:$scope.share_with}).then(function (response) {
                if(response.status){
                     $("#sharedModel").modal('toggle');
                }
            });
        };
        $scope.getStorageList = function ()
        {
            Data.get('storage-list/getStorage', {
                filename: $scope.filename}).then(function (response) {
                $scope.result = JSON.parse(response.result);
                $scope.directories = $scope.result.directories;
            });
        };
        $scope.getmyStorageList = function()
        {
            Data.get('storage-list/getMyStorage', {
                filename: $scope.filename}).then(function (response) {
               $scope.directories = response.records;
            });
        }
        $scope.deleteFolder = function (foldername)
        {
            Data.post('storage-list/deleteFolder', {
                foldername: foldername}).then(function (response) {
                if (response.result)
                {
                    $state.go(getUrl + '.storageListIndex');
                }
            });
        };
        $scope.allImages = function (filename)
        {
            $scope.folderName = filename;
            Data.post('storage-list/allFolderImages', {
                filename: filename}).then(function (response) {
                $scope.folderImages = response.files;
                if (typeof ($scope.folderImages) === 'undefined')
                {
                    $scope.noResult = "No any images found to preview";
                }
            });
        };
        $scope.dosubstorageFormAction = function (fileName, foldername)
        {
            $scope.errorMsg = '';
            $scope.allimages = '';
            if (typeof fileName === 'undefined') {
                fileName = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            }
            var url = getUrl + '/storage-list/subFolder';
            var data = {'foldername': foldername, 'fileName': {'fileName': fileName}}

            fileName.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            fileName.upload.then(function (response) {
                console.log(response);
                if (response.data.status)
                {
                    $scope.folderImages.push(response.data.result)
                }
                $("#storageModel").modal('toggle');
            }, function (response) {


            });
        };

        $scope.changeFileFolder = function ()
        {
            if ($scope.folderorfile == '1') {
                $scope.createFolder = "0";
            } else
            {
                $scope.createFolder = "";
                $scope.fileName = '0';
            }
        }
        $scope.deleteImages = function (index, filename)
        {
            Data.post('storage-list/deleteImages', {
                'filepath': filename}).then(function (response) {
                $scope.folderImages.splice(index, 1);
            });
        };

    }]);


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
    }])
