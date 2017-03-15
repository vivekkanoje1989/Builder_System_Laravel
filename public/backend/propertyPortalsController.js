'use strict';
app.controller('propertyPortalsController', ['$rootScope', '$scope', '$state', 'Data','$timeout', function ($rootScope, $scope, $state, Data,$timeout) {
        Data.get('getPropertyPortalType').then(function (response) {
            $scope.listPortals = response.records;
        });
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
            {//create
                $scope.modal_title = 'Add Project';
                $scope.page_heading = 'Add Account';
                $scope.buttonLabel = 'Create';
//                Data.post('propertyportals/getProperyAlias', {
//                    Data: {portalTypeId: portalTypeId, }
//                }).then(function (response) {
//                    $scope.aliasLists = response.records;
//
//                });
            } else
            {// edit account
                $scope.modal_title = 'Update Project';
                $scope.page_heading = 'Edit Account';
                $scope.buttonLabel = 'Update';
                Data.post('propertyportals/getEditAccountsData', {
                    Data: {portalTypeId: portalTypeId,portalAccountId:portalAccountId }
                }).then(function (response) {
                    console.log(response.records[0]);
                      console.log(response.employee);
                  $scope.portalData = angular.copy(response.records[0]);
                 
                });
                
                 Data.post('propertyportals/getProperyAlias', {
                    Data: {portalId: portalAccountId, }
                }).then(function (response) {
                    $scope.aliasLists = response.records;
                });
                
            }
        }
        $scope.addEditProjects = function (modalData)
        {
            var empname = '';
            var ids = '';
            var status = false;
            var count;
            angular.forEach(modalData.employee_id, function (item, key) {
                empname = empname + item.first_name + ' ' + item.last_name + ',';
                ids = ids + item.id + ',';
            });
            if(typeof $scope.aliasLists ==='undefined'){$scope.aliasLists=[];count=0;}else
            {
               count = Object.keys($scope.aliasLists).length; 
            }            
            if (count > 0)
            {
                for (var i = 0; i < count; i++)
                {
                    if ($scope.aliasLists[i]['project_id'] === modalData.project_id) {
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
                $scope.aliasLists.push({
                    project_id: modalData.project_id,
                    project_alias_name: modalData.project_alias_name,
                    project_employee_name: empname,
                    project_employee_id: ids
                });
            } else
            {
                alert("Project alredy Add");
            }
            $("#projectModal").modal('toggle');
            document.getElementById('portalaliastable').style.display = 'block';
            document.getElementById('btnCreate').style.display = 'block';
            clearModalControls();

        }
        $scope.createPortalAccount = function (portalData, aliasData, portalId,portalAccountId)
        {
            Data.post('propertyportals/createPortalAccount', {
                portalData: portalData, aliasData: aliasData, portalTypeId: portalId,portalAccountId:portalAccountId,
            }).then(function (response) { // FLASH MSG
                if(!response.success)
                {
                    
                }
                else
                {
                   $timeout(function () {
                        $state.go(getUrl+'.portalAccounts', {portalTypeId: portalId});
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
    }]);

