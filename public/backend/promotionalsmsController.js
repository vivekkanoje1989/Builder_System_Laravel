'use strict';
app.controller('promotionalsmsController', ['$scope', 'Data', 'Upload', '$timeout', '$state', '$rootScope', function ($scope, Data, Upload, $timeout, $state, $rootScope) {
        $scope.pageHeading = 'Promotional SMS';
        $scope.promotionalsmsData = {};

        $scope.sendPromotionalSMS = function (promotionalsmsData, numberFile) {
            $scope.submitted = true;
            var url = '/promotionalsms';
            var data = {promotionalsmsData: promotionalsmsData, numberFile: numberFile};
            numberFile.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            }).then(function (response, evt) {
                $timeout(function () {
                    $scope.promotionalsmsData = {};
                    $scope.promotionalsmsData.send_sms_type = 1;
                    $scope.promotionalsmsData.sms_type = 1;
                    $scope.step1 = false;
                    $('#totalsms').html(1);
                    $("#totalnumbers").html(0);
                    $('#totalcharacters').html(0);
                    $rootScope.alert('success', response.message);
                    $('.alert-delay').delay(1000).fadeOut("slow");
                    $state.go('promotionalsms');
                });
            });
        };

    }]);