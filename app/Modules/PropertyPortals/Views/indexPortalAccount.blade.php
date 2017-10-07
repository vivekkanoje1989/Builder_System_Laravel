<div class="row" ng-controller="propertyPortalsController" ng-init="getAccounts('[[ $accountid ]]')">
    <div class="col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage {{ portal_name}} Accounts</span>                
            </div>
            <div class="widget-body table-responsive">
                <div class="row">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="search">Search:</label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="search" name="search" class="form-control">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label for="search">Records per page:</label>
                            <input type="text" minlength="1" maxlength="3" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" style="width:30%;" class="form-control" ng-model="itemsPerPage" name="itemsPerPage">
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for=""></label>
                            <span class="input-icon icon-right">
                                <a href="[[ config('global.backendUrl') ]]#/portalaccounts/create/[[ $accountid ]]" class="btn btn-primary btn-right">Add New Account</a>
                            </span>
                        </div>
                    </div>
                </div>
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
                        <tr role="row" dir-paginate="listPortal in listPortalAccounts | filter:search | orderBy:orderByField:reverseSort| itemsPerPage:itemsPerPage"">
                            <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}} </td>
                            <td>{{ listPortal.portal_name}}</td>
                            <td>{{ listPortal.employee_id}}</td>
                            <td><a href="">Check</a></td>
                            <td><a href="">View</a></td>
                            <td ng-if="listPortal.status == 1"><label><input class="checkbox-slider slider-icon" id="accountStatuschk{{ listPortal.id}}" type="checkbox" checked ng-click="changeAccountStatus({{  listPortal.status}},{{ listPortal.id}})"><span class="text"></span></label></td>
                            <td ng-if="listPortal.status == 0"><label><input class="checkbox-slider slider-icon" id="accountStatuschk{{ listPortal.id}}" type="checkbox" ng-click="changeAccountStatus({{  listPortal.status}},{{ listPortal.id}})"><span class="text"></span></label></td>
                            <td class="fa-div"><div class="fa-hover" tooltip-html-unsafe="Edit Account" style="display: block;"><a href="[[ config('global.backendUrl') ]]#/portalaccounts/update/[[ $accountid ]]/{{ listPortal.id}}"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;</div></td>
                        </tr>
                    </tbody>
                </table> 
                <div class="DTTTFooter">
                    <div class="col-sm-6">
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{noOfRows}}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                            <dir-pagination-controls class="pagination" on-page-change="pageChangeHandler(newPageNumber)" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

