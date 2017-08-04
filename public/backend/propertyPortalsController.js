'use strict';
app.controller('propertyPortalsController', ['$scope', '$state', 'Data', '$timeout','$parse', function ($scope, $state, Data, $timeout, $parse) {
        $scope.lstAllEmployees = [];
        $scope.noOfRows = 1;
        $scope.itemsPerPage = 30;
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        $scope.portalTypeList = function () {
            Data.get('getPropertyPortalType').then(function (response) {
                $scope.listPortals = response.records;
            });
        }
        $scope.changestatus = function (status, id)
        {
            var ischk = document.getElementById('statuschk' + id).checked;
            status = (ischk === true) ? 1 : 0;
            Data.post('propertyportals/changePortalTypeStatus', {
                Data: {id: id, status: status},
            }).then(function (response) {
                //flash messages
            });
        }
        $scope.changeAccountStatus = function (status, id)
        {
            var ischk = document.getElementById('accountStatuschk' + id).checked;
            status = (ischk === true) ? 1 : 0;
            Data.post('propertyportals/changePortalAccountStatus', {
                Data: {id: id, status: status},
            }).then(function (response) {
                //flash messages
            });
        }
        $scope.getAccounts = function (id)
        {
            Data.post('propertyportals/properyPortalAccount', {
                Data: {id: id},
            }).then(function (response) {
                $scope.listPortalAccounts = response.records;
                $scope.portal_name = response.portalName[0].portal_name;
            });
        }
        $scope.managePortalAccounts = function (portalTypeId, portalAccountId, action)
        {
            if (portalAccountId === 0)
            {   //create
                $scope.modal_title = 'Add Project';
                $scope.page_heading = 'Add Account';
                $scope.buttonLabel = 'Create';
            } else
            {   // edit account
                $scope.modal_title = 'Update Project';
                $scope.page_heading = 'Edit Account';
                $scope.buttonLabel = 'Update';
                Data.post('propertyportals/getupdatePortalAccount', {
                    Data: {portalTypeId: portalTypeId, portalAccountId: portalAccountId}
                }).then(function (response) {
                    $scope.portalData = angular.copy(response.records[0]);
                    // $scope.portalData.
                });

                Data.post('propertyportals/getProperyAlias', {
                    Data: {portalId: portalAccountId, portalTypeId: portalTypeId, id: 0}
                }).then(function (response) {
                    $scope.aliasLists = response.records;
                });
            }
        }
        $scope.addEditProjects = function (modalData, index)
        {
            var empname = '';
            var ids = '';
            var status = false;
            var count;
            angular.forEach(modalData.employee_id, function (item, key) {
                empname = empname + item.first_name + ' ' + item.last_name + ',';
                ids = ids + item.id + ',';
            });
            if (typeof $scope.aliasLists === 'undefined') {
                $scope.aliasLists = [];
                count = 0;
            } else
            {
                count = Object.keys($scope.aliasLists).length;
            }
            if (count > 0)
            {
                for (var i = 0; i < count; i++)
                {
                    if ($scope.aliasLists[i]['project_id'] === modalData.project_id && index > 0) {
                        status = false;
                        break;
                    } else
                    {
                        status = true;
                    }
                }
            } else
            {
                status = true;
            }
            if (status === true)
            {
                if (index > 0)
                {
                    $scope.aliasLists.splice($scope.index - 1, 1);
                    $scope.aliasLists.splice($scope.index - 1, 0, {
                        project_id: modalData.project_id, project_alias: modalData.project_alias, project_employee_name: empname, project_employee_id: ids});
                } else
                {
                    $scope.aliasLists.push({
                        project_id: modalData.project_id,
                        project_alias: modalData.project_alias,
                        project_employee_name: empname,
                        project_employee_id: ids
                    });
                }
            } else
            {
                alert("Project alredy Add");
            }
            $("#projectModal").modal('toggle');
            document.getElementById('portalaliastable').style.display = 'block';
            document.getElementById('btnCreate').style.display = 'block';
            clearModalControls();
        }
        $scope.createPortalAccount = function (portalData, aliasData, portalId, portalAccountId)
        {
            Data.post('propertyportals/actionPortalAccount', {
                portalData: portalData, aliasData: aliasData, portalTypeId: portalId, portalAccountId: portalAccountId,
            }).then(function (response) { // FLASH MSG
                if (!response.success)
                {
                    var obj = response.message;
                    $('.errMsg').text('');
                    for (var key in obj) {
                        var model = $parse(key);// Get the model
                        model.assign($scope, obj[key][0]);// Assigns a value to it
                    }
                } else
                {
                    $timeout(function () {
                        $state.go('propertyPortalAccounts', {portalTypeId: portalId});
                    }, 1000);
                }
            });
        }
        $scope.checkPortalEmployees = function ()
        {
            if ($scope.portalData.employee_id.length === 0) {
                $scope.emptyEmployeeId = true;
            } else {
                $scope.emptyEmployeeId = false;
            }
        }
        $scope.checkPortalAliasEmployees = function ()
        {
            if ($scope.modal.employee_id.length === 0) {
                $scope.isEmptyEmployeeId = true;
            } else {
                $scope.isEmptyEmployeeId = false;
            }
        }
        function clearModalControls()
        {
            // $scope.modal='';
        }
        $scope.getUpdatePropertAlias = function (id, portaltypeid, portalid)
        {
            alert(id + ":" + portaltypeid + ":" + portalid);
            Data.post('propertyportals/getProperyAlias', {
                Data: {portalId: portalid, portalTypeId: portaltypeid, id: id}
            }).then(function (response) {
                $scope.modal = response.records[0];
                $scope.modal.employee_id = response.records[0]['project_employee_id'];
            });
        }
        $scope.clearPopup = function ()
        {
            $scope.modal = {};
        }
    }]);

app.controller('assignEmployeeCtrl', function ($scope, Data, $timeout) {
    $scope.lstAllEmployees = [];
    $timeout(function () {
        Data.get('propertyportals/getAllEmployees').then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                //console.log(response);
                $scope.lstAllEmployees = response.records;
            }
        });
    }, 3000);
});