app.controller('DatepickerDemoCtrl', function ($scope, $filter) {
    var today = new Date();
    today.setMonth(today.getMonth());

    $scope.maxDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
   
    
    $scope.today = function () {
        $scope.dt = new Date();
    };
    $scope.today();

    $scope.clear = function () { 
        $scope.dt = null;
    };

    // Disable weekend selection
    $scope.disabled = function (date, mode) {
        return (mode === 'day' && (date.getDay() === 0 || date.getDay() === 6));
    };

    $scope.toggleMin = function () {
        $scope.minDate = $scope.minDate ? null : new Date();
    };
    $scope.toggleMin();

    $scope.open = function ($event, type) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope.opened = true;
        if (type == 3) {

            if (typeof $scope.customerData.birth_date == "undefined" || $scope.customerData.birth_date == '' || $scope.customerData.birth_date == null || $scope.customerData.birth_date == "-0001-11-30 00:00:00" || $scope.customerData.birth_date == "NaN-aN-NaN") {
                $scope.customerData.birth_date = '';
            }else{
                var today = new Date();
                today.setYear(today.getFullYear() - 20);
                $scope.maxDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
        
                var bd = new Date($scope.customerData.birth_date);
                if (bd.getDate() < 10) {
                    var date_of_birth = (bd.getFullYear() + '-' + ("0" + (bd.getMonth() + 1)).slice(-2) + '-' + ("0" + bd.getDate()));
                } else {
                    var date_of_birth = (bd.getFullYear() + '-' + ("0" + (bd.getMonth() + 1)).slice(-2) + '-' + bd.getDate());
                }
                $scope.customerData.birth_date = date_of_birth;
            } 
            if (typeof $scope.customerData.marriage_date == "undefined" || $scope.customerData.marriage_date == '' || $scope.customerData.marriage_date == null || $scope.customerData.marriage_date == "-0001-11-30 00:00:00" || $scope.customerData.marriage_date == "NaN-aN-NaN") {
                 $scope.customerData.marriage_date = '';
            }else{
                $scope.maxDates = new Date($scope.customerData.marriage_date);
                if ($scope.maxDates.getDate() < 10) {
                    var marriage_date = ($scope.maxDates.getFullYear() + '-' + ("0" + ($scope.maxDates.getMonth() + 1)).slice(-2) + '-' + ("0" + $scope.maxDates.getDate()));
                } else {
                    var marriage_date = ($scope.maxDates.getFullYear() + '-' + ("0" + ($scope.maxDates.getMonth() + 1)).slice(-2) + '-' + $scope.maxDates.getDate());
                }
                $scope.customerData.marriage_date = marriage_date;
            }
        }
    };
    $scope.dateOptions = {
        formatYear: 'yy',
        startingDay: 1
    };

    $scope.formats = ['dd-MMMM-yyyy', 'dd-MM-yyyy', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[1];

});