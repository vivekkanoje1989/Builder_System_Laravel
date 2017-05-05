app.controller('storageCtrl', ['$scope', 'Data', '$state', 'Upload', '$timeout', function ($scope, Data, $state, Upload, $timeout) {

        $scope.dostorageFormAction = function ()
        {
            Data.post('storage-list/', {
                filename: $scope.filename}).then(function (response) {
                if (response.status) {
                    $scope.directories.push({'folder': $scope.filename});
                    $("#storageModel").modal('toggle');
                } else {
                    $scope.errorMsg = response.errorMsg;
                }
            });
        };
        $scope.initialModal = function ()
        {
            $scope.sbtBtn = false;
            $scope.fileName = '';
        };
        $scope.getEmployees = function () {
            Data.get('getEmployees').then(function (response) {
                $scope.employeeRow = response.records;
            });
        };
        $scope.getSharedEmployees = function(foldername)
        {
            Data.post('storage-list/folderSharedEmployees', {
                folder: foldername }).then(function (response) {
                $scope.folderSharedEmployees = response.result;
            });
        };
        $scope.removeEmployees = function(index,employee_id,folder)
        {
            Data.post('storage-list/removeEmployees', {
                employee_id: employee_id,folder:folder}).then(function (response) {
                  $scope.folderSharedEmployees.splice(index,1);
            });
        }
        $scope.sharedFormWith = function (foldername)
        {
            Data.post('storage-list/sharedWith', {
                folder: foldername, share_with: $scope.share_with }).then(function (response) {
                if (response.status) {
                    $("#sharedModel").modal('toggle');
                }
            });
        };
        $scope.getStorageList = function ()
        {
            Data.get('storage-list/getStorage', {
                filename: $scope.filename}).then(function (response) {
                $scope.directories = response.result;
            });
        };
        $scope.getmyStorageList = function ()
        {
            Data.get('storage-list/getMyStorage', {
                filename: $scope.filename}).then(function (response) {
                $scope.directories = response.records;
            });
        };
        $scope.getRecycleList = function ()
        {
            Data.get('storage-list/getRecycle').then(function (response) {
                $scope.recycleDirectories = response.result;
            });
        };
        $scope.deleteFolder = function (foldername, type)
        {
            Data.post('storage-list/deleteFolder', {
                folder: foldername}).then(function (response) {
                if (response.result && type == '0')
                {
                    $state.go(getUrl + '.storageListIndex');
                } else {
                    $state.go(getUrl + '.sharedWithMe');
                }
            });
        };
        $scope.restoreFolder = function (foldername)
        {
            Data.post('storage-list/restoreFolder', {
                folder: foldername}).then(function (response) {
                if (response.result)
                {
                    $state.go(getUrl + '.recycleBin');
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
        };
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
                        scope.$eval(clickAction);
                    }
                });
            }
        };
    }]);
