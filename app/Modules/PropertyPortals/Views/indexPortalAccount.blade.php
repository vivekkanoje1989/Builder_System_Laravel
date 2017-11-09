<div class="row" ng-controller="propertyPortalsController" ng-init="getAccounts('[[ $accountid ]]')">
    <div class="  col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage {{ portal_name}} Accounts</span>                
            </div>
            <div class="widget-body table-responsive">
                <!--                <div class="row">
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
                                </div>-->
                <div class="row table-toolbar">
                    <a  href="[[ config('global.backendUrl') ]]#/portalaccounts/create/[[ $accountid ]]"  class="btn btn-default">Add New Account</a>
                    <div class="btn-group pull-right filterBtn">
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2"  ng-disabled="disableBtn" >
                            <span>Actions</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"  ng-disabled="disableBtn" ><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a href="" ng-click="accountsExportToxls('[[ $accountid ]]')" ng-show="exportData == '1'">Export</a>
                                </li>

                            </ul>
                        </a>
                    </div>
                    <div  class="dataTables_filter">
                        <label>
                            <input type="search"  ng-disabled="disableBtn"  class="form-control input-sm" ng-model="search" name="search" >
                        </label>
                    </div>
                    <div class="dataTables_length" >
                        <label>
                            <select  ng-disabled="disableBtn"  class="form-control" ng-model="itemsPerPage" name="itemsPerPage" onchange="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
                                <option value="30">30</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                                <option value="300">300</option>
                                <option value="400">400</option>
                                <option value="500">500</option>
                                <option value="600">600</option>
                                <option value="700">700</option>
                                <option value="800">800</option>
                                <option value="900">900</option>
                                <option value="999">999</option>
                            </select>
                        </label>
                    </div>
                    <table class="table table-hover table-striped table-bordered tableHeader" at-config="config">
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
                                <td class="">
                                    <span tooltip-html-unsafe="Edit Account" >
                                        <a href="[[ config('global.backendUrl') ]]#/portalaccounts/update/[[ $accountid ]]/{{ listPortal.id}}" class="btn-primary btn-xs">
                                            <i class="fa fa-edit"></i>Edit</a> </span>

                                </td>
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

