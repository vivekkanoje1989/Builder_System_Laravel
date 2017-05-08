<div ng-controller="sessionController">
    
</div>

<script>
app.controller('sessionController', function ($rootScope, $scope, $state, Data, event) {
    $rootScope.authenticated = false;
    $state.go('login');
    event.preventDefault();
    return false;
});    
</script>