<div class="row" ng-controller="wingCtrl">
    <div class="col-lg-6 col-sm-6 col-xs-12">
        <tabset class="tabs-left" >
            <tab ng-repeat="wlist in wingList" heading="{{wlist.wing_name}}" class="themeprimary">
                
            </tab>
        </tabset>
        <div class="horizontal-space"></div>
    </div>
</div>