<div class="row" ng-controller="propertyPortalsController" ng-init="portalTypeList()">
    <div class="col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Property Portals</span>                
            </div>
            <div class="widget-body table-responsive">
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">Sr.No.</th>
                            <th style="width: 55%">Name of Property Portal</th>
                            <th style="width: 20%">Status</th>                                                     
                            <th style="width: 20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" ng-repeat="listPortal in listPortals">
                            <td>{{$index+1}}</td>
                            <td>{{ listPortal.portal_name }}</td>
                             <td ng-if="listPortal.status == 1"><label><input class="checkbox-slider slider-icon colored-success" type="checkbox" id="statuschk{{ listPortal.id }}" checked ng-click="changestatus({{  listPortal.status }},{{ listPortal.id }})"><span class="text"></span></label></td>
                            <td ng-if="listPortal.status == 0"><label><input class="checkbox-slider slider-icon" type="checkbox" id="statuschk{{ listPortal.id }}" ng-click="changestatus({{  listPortal.status }},{{ listPortal.id }})"><span class="text"></span></label></td>
                            <td class="fa-div"><a class="glyphicon glyphicon-eye-open" href="[[ config('global.backendUrl') ]]#/portalaccounts/{{ listPortal.id }}" ></a></td>
                        </tr>
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</div> 

