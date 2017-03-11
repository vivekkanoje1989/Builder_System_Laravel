'use strict';
app.controller('propertyPortalsController', ['$rootScope', '$scope', '$state', 'Data', function ($rootScope, $scope, $state, Data) {
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
                // $state.go(getUrl+'.portalAccounts');

            });
        }

    }]);

