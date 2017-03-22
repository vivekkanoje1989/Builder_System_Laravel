<div class="row" ng-controller="propertyPortalsController" ng-init="getAccounts('[[ $accountid ]]')">
    <div class="col-xs-12 col-md-12">
        <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>Manage {{ portal_name}} Accounts</h5>
        <div class="widget">
            <div class="widget-header ">                
                <span class="widget-caption"> {{ portal_name}} </span> 
                <a href="#/[[config('global.getUrl')]]/portalaccounts/create/[[ $accountid ]]" class="btn btn-info">Add New Account</a>
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>            
            <div class="widget-body table-responsive">
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">Sr.No.</th>
                            <th style="width: 25%">Friendly Account Name</th>
                            <th style="width: 25%">Assign Enquiries to</th>
                            <th style="width: 15%">Check Enquiry Now</th>
                            <th style="width: 10%">Response Logs</th>
                            <th style="width: 10%">Status</th>                                                     
                            <th style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" ng-repeat="listPortal in listPortalAccounts">
                            <td>{{$index + 1}}</td>
                            <td>{{ listPortal.portal_name}}</td>
                            <td>{{ listPortal.employee_id}}</td>
                            <td><a href="">Check</a></td>
                            <td><a href="">View</a></td>
                            <td ng-if="listPortal.status == 1"><label><input class="checkbox-slider slider-icon" id="accountStatuschk{{ listPortal.id}}" type="checkbox" checked ng-click="changeAccountStatus({{  listPortal.status}},{{ listPortal.id}})"><span class="text"></span></label></td>
                            <td ng-if="listPortal.status == 0"><label><input class="checkbox-slider slider-icon" id="accountStatuschk{{ listPortal.id}}" type="checkbox" ng-click="changeAccountStatus({{  listPortal.status}},{{ listPortal.id}})"><span class="text"></span></label></td>
                            <!-- <td>{{ listPortal.status }}</td> -->
                            <td class="fa-div"><div class="fa-hover" tooltip-html-unsafe="Edit Account" style="display: block;"><a href="#/[[config('global.getUrl')]]/portalaccounts/update/[[ $accountid ]]/{{ listPortal.id}}"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;</div></td>
                        </tr>
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</div> 

