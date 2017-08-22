app.controller('storageCtrl', ['$scope', 'Data', '$state', 'Upload', 'toaster', function ($scope, Data, $state, Upload, toaster) {
        $scope.dostorageFormAction = function ()
        {
            Data.post('storage-list/', {
                filename: $scope.filename}).then(function (response) {
                if (response.status) {
                    toaster.pop('success', 'My storage', 'Record successfully created');
                    $scope.directories.push({'folder': $scope.filename, 'id': response.result.id});
                    $("#storageModel").modal('toggle');
                } else {
                    $scope.errorMsg = response.errorMsg;
                }
            });
        };

        $scope.share = function (shareId)
        {
            $scope.id = shareId;
            $scope.subDirectories;
            $scope.getSharedEmployees(shareId)
        }
        $scope.dofolderstorageAction = function (folder)
        {
            Data.post('storage-list/folderStorage', {
                folder: folder, folderName: $scope.folderName}).then(function (response) {
                if (response.status)
                {
                    toaster.pop('success', 'My storage', 'Record successfully created');
                    $scope.subDirectories.push({'folder': $scope.folderName, 'id': response.id});
                    $("#folderModel").modal('toggle');
                } else {
                    $scope.errorMsg = response.errorMsg;
                }
            });
        };
        $scope.getSubDirectory = function (id)
        {
            Data.post('storage-list/getSubDirectory', {
                id: id}).then(function (response) {
                if (response.status)
                {
                    $scope.subDirectories = response.result;
                } else {
                    $scope.subDirectories = [];
                    $scope.errorMsg = response.errorMsg;
                }
            });
        };
        $scope.initialModal = function ()
        {
            $scope.sbtBtn = false;
            $scope.folderName = '';
            $scope.subDirectories;
        };
        $scope.getEmployees = function () {
            Data.get('getEmployees').then(function (response) {
                $scope.employeeRow = response.records;
            });
        };
        $scope.getSharedEmployees = function (id)
        {
            Data.post('storage-list/folderSharedEmployees', {
                id: id}).then(function (response) {
                $scope.folderSharedEmployees = response.result;
            });
        };
        $scope.removeEmployees = function (index, employee_id, id)
        {
            Data.post('storage-list/removeEmployees', {
                employee_id: employee_id, id: id}).then(function (response) {
                //console.log(response);
                toaster.pop('success', 'My storage', 'Employee removed successfully');
                $scope.folderSharedEmployees.splice(index, 1);
            });
        };
        $scope.removeImageSharedEmp = function (index, employee_id)
        {
            Data.post('storage-list/removeImageSharedEmp', {
                employee_id: employee_id, 'image_id': $scope.id}).then(function (response) {
                $scope.imageSharedEmployees.splice(index, 1);
                toaster.pop('success', 'My storage', 'Employee removed successfully');
            });
        };

        $scope.getSharedImagesEmployees = function (id)
        {
            Data.post('storage-list/getSharedImagesEmployees', {
                id: id}).then(function (response) {
                $scope.imageSharedEmployees = response.result;
            });
        };
        $scope.sharedFormWith = function (id)
        {
            Data.post('storage-list/sharedWith', {
                id: id, share_with: $scope.share_with}).then(function (response) {

                if (response.status)
                {
                    if ($scope.folderSharedEmployees !== undefined) {
                        $scope.folderSharedEmployees.push({'first_name': response.empl.first_name, 'last_name': response.empl.last_name, 'id': id, 'employee_id': $scope.share_with});
                    } else {
                        $scope.folderSharedEmployees = [];
                        $scope.folderSharedEmployees.push({'first_name': response.empl.first_name, 'last_name': response.empl.last_name, 'id': id, 'employee_id': $scope.share_with});
                    }
                } else {
                    $scope.errorMsg = response.errorMsg;
                }
            });
        };
        $scope.getStorageList = function ()
        {
            Data.get('storage-list/getStorage').then(function (response) {
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
        $scope.deleteFolder = function (id, index, type)
        {

            Data.post('storage-list/deleteFolder', {
                id: id}).then(function (response) {
                console.log(response);
                if (response.result)
                {
                    if (type == 1)
                    {
                        $scope.directories.splice(index, 1);
                        toaster.pop('success', 'My storage', 'Record successfully deleted');
                    } else {
                        $scope.subDirectories.splice(index, 1);
                        toaster.pop('success', 'My storage', 'Record successfully deleted');
                    }

                }
            });
        };
        $scope.restoreFolder = function (id)
        {
            Data.post('storage-list/restoreFolder', {
                id: id}).then(function (response) {
                if (response.result)
                {
                    toaster.pop('success', 'My storage', 'Record successfully restored');
                    $state.go('.recycleBin');
                }
            });
        };
        $scope.allImages = function (filename)
        {
            $scope.folderName = filename;
            Data.post('storage-list/allFolderImages', {
                id: filename}).then(function (response) {
                $scope.folderImages = response.records;
                if ($scope.folderImages == undefined)
                {
                    $scope.noResult = "No images found to preview";
                }
            });
        };
        $scope.dosubstorageFormAction = function (fileName, foldername)
        {
            $scope.folderImages;
            $scope.errorMsg = '';
            $scope.allimages = '';
            if (typeof fileName === 'undefined') {
                fileName = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            }
            var url = '/storage-list/subFolder';
            var data = {'id': foldername, 'fileName': {'fileName': fileName}};

            fileName.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            fileName.upload.then(function (response) {
                toaster.pop('success', 'My storage', 'Record successfully created');
                var post = response.data.result;
                if ($scope.folderImages !== undefined)
                {
                    $scope.folderImages.push({'file_url': post, 'id': response.data.lastId});
                } else {
                    $scope.folderImages = [];
                    $scope.folderImages.push({'file_url': post, 'id': response.data.lastId});
                    $scope.noResult = '';
                }
                $("#storageModel").modal('toggle');
            }, function (response) {

            });
        };
        $scope.doSubImageFormAction = function (fileName, foldername)
        {
            $scope.folderImages;
            $scope.errorMsg = '';
            $scope.allimages = '';
            if (typeof fileName === 'undefined') {
                fileName = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            }
            var url = '/storage-list/subImageStorage';
            var data = {'id': foldername, 'fileName': {'fileName': fileName}};

            fileName.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            fileName.upload.then(function (response) {
                // console.log(response);
                toaster.pop('success', 'My storage', 'Record successfully created');
                var post = response.data.result;
                if ($scope.folderImages !== undefined)
                {
                    $scope.folderImages.push({'file_url': post, 'id': response.data.lastId});
                } else {
                    $scope.folderImages = [];
                    $scope.folderImages.push({'file_url': post, 'id': response.data.lastId});
                    $scope.noResult = '';
                }
                $("#storageModel").modal('toggle');
            }, function (response) {

            });
        }
        $scope.getMySharedImages = function () {
            Data.get('storage-list/getMySharedImages').then(function (response) {
                $scope.myImageStore = response.records
            });
        }
        $scope.sharedImageWith = function (id)
        {
            Data.post('storage-list/sharedImageWith', {
                'id': $scope.id, 'share_with': $scope.share_with}).then(function (response) {
                if (response.status) {
                    if ($scope.imageSharedEmployees == undefined)
                    {
                        $scope.imageSharedEmployees = [];
                        $scope.imageSharedEmployees.push({'first_name': response.empl.first_name, 'last_name': response.empl.last_name, 'employee_id': $scope.share_with});

                    } else {
                        $scope.imageSharedEmployees.push({'first_name': response.empl.first_name, 'last_name': response.empl.last_name, 'employee_id': $scope.share_with});
                    }
                } else {
                    $scope.errorMsg = 'Image already shared with employee';
                }
            });
        };
        $scope.imageShared = function (id)
        {
            $scope.id = id;
            $scope.sbtBtn = false;
        };

        $scope.deleteImages = function (index, imageId)
        {
            Data.post('storage-list/deleteImages', {
                'id': imageId}).then(function (response) {
                $scope.folderImages.splice(index, 1);
            });
        };

        $scope.getSynchedFolderList = function ()
        {
            Data.get('storage-list/synchedFolderList').then(function (response) {
                $scope.tableData = [];
                for (i = 0; i < response.result2.length; i++)
                {
                    $scope.tableData.push(response.result2[i].folder)
                }
                var counter = JSON.parse(response.result);
                $scope.s3Data = counter.directories;
                difference = $scope.s3Data.filter(function (x) {
                    return $scope.tableData.indexOf(x) < 0
                });
                $scope.insertSyncedData(difference);
            });
        };
        $scope.insertSyncedData = function (difference)
        {
            Data.post('storage-list/insertSyncedData', {
                'difference': difference}).then(function (response) {
            });
        };

        $scope.subDirectoryAdd = function (folder)
        {
            $scope.subFolder = [];
            Data.post('storage-list/subDirectoryAdd', {'id': folder}).then(function (response) {
                var counter = JSON.parse(response.result);
                $scope.s3Data = counter.directories;
                var count = JSON.parse(response.result2);
                $scope.s3allData = count.directories;
                difference = $scope.s3allData.filter(function (x) {
                    return $scope.s3Data.indexOf(x) < 0
                });
                for (i = 0; i < difference.length; i++)
                {
                    var fields = difference[i].split('/');
                    var name = fields[0];
                    if (response.folder == name) {
                        var street = fields[1];
                        $scope.subFolder.push(street);
                    }
                }
                syncSubFolder = $scope.subFolder.filter(function (x) {
                    return response.oldFolder.indexOf(x) < 0
                });
                $scope.syncSubFolderCreate(syncSubFolder, folder, response.subId);
            });
        };
        $scope.syncSubFolderCreate = function (syncSubFolder, folder, subId) {
            Data.post('storage-list/syncSubFolderCreate', {
                'syncSubFolder': syncSubFolder, 'id': folder, 'subId': subId}).then(function (response) {

            });
        }
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