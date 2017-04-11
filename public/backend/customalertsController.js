'use strict';
app.controller('customalertsController', ['$rootScope', '$scope', '$state', 'Data', '$filter', 'Upload', '$timeout', function ($rootScope, $scope, $state, Data, $filter, Upload, $timeout) {
    $scope.pageHeading = 'Create Custome Alert';
    $scope.buttonLabel = 'Create';
    $scope.customAlertData = {};
    $scope.listcustomAlerts = [];
    $scope.templateEvents = [];
    $scope.isDisabled = false;
    $scope.customAlertData.client_id = 1;
    $scope.currentPage =  $scope.itemsPerPage = 10; 
    $scope.noOfRows = 1;
   
    $scope.getTemplatesEvents = function(){
        Data.post('alerts/getTemplatesEvents').then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.templateEvents = response.records;
            }
        });
    };
    $scope.createAlert = function (enteredData, alterId) {
        var customAlertData = {};        
        customAlertData = angular.fromJson(angular.toJson(enteredData));
        if(alterId === 0)
        {          
           Data.post('customalerts/', {
                customAlertData:customAlertData}).then(function (response) {
                console.log(response)
                if (!response.success)
                {
                    $scope.errorMsg = response.errormsg;
                } else {
                    $rootScope.alert('success', response.message);
                    $('.alert-delay').delay(3000).fadeOut("slow");
                    $timeout(function(){
                        $state.go(getUrl+'.customalertsIndex');
                    }, 1000);
                }
            }); 
        }
        else{
            Data.post('customalerts/updateCustomAlerts', {
                customAlertData:customAlertData, id: alterId}).then(function (response) {
                console.log(response)
                if (!response.success)
                {
                    $scope.errorMsg = response.errormsg;
                } else {
                    $rootScope.alert('success', response.message);
                    $('.alert-delay').delay(3000).fadeOut("slow");
                    $timeout(function(){
                        $state.go(getUrl+'.customalertsIndex');
                    }, 1000);
                }
            });
        }
    };
    
    $scope.manageAlerts = function (id,action) { //edit/index action
        $scope.modal = {};
        Data.post('customalerts/manageCustomAlerts',{
            id: id,
        }).then(function (response) {
            if (response.success) {
                if(action === 'index'){
                    $scope.listcustomAlerts = response.records.data;
                    $scope.listcustomAlertsLength = response.records.total;
                }
                else if(action === 'edit'){
                    if(id !== '0'){
                        $scope.pageHeading = 'Edit Custome Alert';
                        $scope.buttonLabel = 'Update';
                        $scope.isDisabled =true;
                        $scope.customAlertData = angular.copy(response.records.data[0]);
                    }
                }
            } else {
                $scope.errorMsg = response.message;
            }
        });
    };

    $scope.pageChangeHandler = function(num) {
        $scope.noOfRows = num;
        $scope.currentPage = num * $scope.itemsPerPage;
    };
    
}]);
app.directive('ckEditor', function() {
    return {
        require : '?ngModel',
        link : function($scope, elm, attr, ngModel) {

            var ck = CKEDITOR.replace(elm[0]);

            ck.on('instanceReady', function() {
                ck.setData(ngModel.$viewValue);
            });

            ck.on('pasteState', function() {
                $scope.$apply(function() {
                    ngModel.$setViewValue(ck.getData());
                });
            });

            ngModel.$render = function(value) {
                ck.setData(ngModel.$modelValue);
            };
        }
    };
});
app.filter('htmlToPlaintext', function()
{
    return function(text)
    {
        var temp = text ? String(text).replace(/<[^>]+>/gm, '') : '' ;
        temp = temp ? String(temp).replace(/  /g, '&nbsp; '):'';
        return  temp;
    };
});
