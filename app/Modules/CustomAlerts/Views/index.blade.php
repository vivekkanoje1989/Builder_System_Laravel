<style>
    .toggleClassActive {font-size:40px !important;cursor:pointer;color: #5cb85c !important;vertical-align: middle;margin-left: 15px;}
    .toggleClassInactive {font-size:40px !important;cursor:pointer;color: #d9534f !important;vertical-align: middle;margin-left: 15px;}
</style>

<div class="row" ng-controller="customalertsController" ng-init="manageAlerts('', 'index', 1, [[config('global.recordsPerPage')]])">
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Custom Templates</span>

            </div>
            <div class="widget-body table-responsive">
                <!--                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <label for="search">Search:</label>
                                        <input type="text" ng-model="search" class="form-control" style="width:25%;" placeholder="Search">
                                    </div>
                
                                    <div class="col-sm-6 col-xs-12">
                                        <label for="search">Records per page:</label>
                                        <input type="text" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"   minlength="1" maxlength="3" style="width:25%;" class="form-control" ng-model="itemsPerPage">
                                    </div>
                                </div><br>-->
                <div class="row table-toolbar">
                    <a href="[[ config('global.backendUrl') ]]#/customalerts/create " class="btn btn-default">Create New Template</a>&nbsp;&nbsp;&nbsp;
                   
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                        <div class="DTTT btn-group">
                            <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Excel" ng-click="customTemplatesExportToxls()" ng-show="exportData == '1'" >
                                <span>Export</span>
                            </a>
                            <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2">
                                <span>Options</span>
                                <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu dropdown-default">
                                    <li>
                                        <a href="javascript:void(0);">Action</a>
                                    </li>
                                </ul>
                            </a>
                        </div>
                   
                    <div  class="dataTables_filter">
                        <label>
                            <input type="search" class="form-control input-sm" ng-model="search" name="search" >
                        </label>
                    </div>
                    <!-- filter data--> 
                    <!--                    <div class="row" style="border:2px;" id="filter-show">
                                            <div class="col-sm-12 col-xs-12">
                                                <b ng-repeat="(key, value) in searchData" ng-if="value != 0">
                                                    <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                                        <div class="alert alert-info fade in">
                                                            <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                                            <strong ng-if="key === 'legal_name'" data-toggle="tooltip" title=""><strong> Project Name : </strong> {{ value}}</strong>
                                                            <strong ng-if="key === 'name'" data-toggle="tooltip" title="Name"><strong> Name : </strong> {{ value}}</strong>
                                                            <strong ng-if="key === 'account_type'" data-toggle="tooltip" title="Account Type"><strong> Account Type : </strong> {{ value == '1' ? "Saving":"Current"}}</strong>
                                                            <strong ng-if="key === 'account_number'" data-toggle="tooltip" title="Account Number"><strong> Account Number : </strong> {{ value}}</strong>
                                                            <strong ng-if="key === 'branch'" data-toggle="tooltip" title="Branch"><strong> Branch  : </strong> {{ value}}</strong>
                                                        </div>
                                                    </div>
                                                </b>                        
                                            </div>
                                        </div>-->
                    <!-- filter data-->
                    <div class="dataTables_length" >
                        <label>
                            <select class="form-control" ng-model="itemsPerPage" name="itemsPerPage" onchange="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
                                <option value="1">1</option>
                                <option value="5">5</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="100">100</option>
                            </select>
                        </label>
                    </div>
                    <table class="table table-hover table-striped table-bordered tableHeader" at-config="config">
                        <thead class="bord-bot">
                            <tr>
                                <th style="width:5%">Sr. No.</th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'friendly_name'; reverseSort = !reverseSort">Friendly Name
                                        <span ng-show="orderByField == 'friendly_name'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                        </span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'sms_body'; reverseSort = !reverseSort">SMS Body
                                        <span ng-show="orderByField == 'sms_body'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                        </span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'email_subject'; reverseSort = !reverseSort">Email Subject
                                        <span ng-show="orderByField == 'email_subject'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                        </span>
                                    </a>
                                </th>
                                <th style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr dir-paginate="listAlert in listcustomAlerts | filter:search | itemsPerPage: itemsPerPage | orderBy:orderByField:reverseSort" >
                                <td>
                        <center>
                            {{itemsPerPage * (noOfRows - 1) + $index + 1}}<br>                              
                        </center>
                        </td>
                        <td>{{ listAlert.friendly_name}}</td>
                        <td>{{ listAlert.sms_body | htmlToPlaintext }}</td>
                        <td>{{ listAlert.email_subject | htmlToPlaintext }}</td>
                        <td class="">
                            <div class="" tooltip-html-unsafe="Edit User" style="display: block;"><a href="[[ config('global.backendUrl') ]]#/customalerts/update/{{ listAlert.id}}" class="btn-info btn-xs"><i class="fa fa-edit"></i>Edit</a> &nbsp;&nbsp;</div>
                        </td>
                        </tr>
                        <tr><td colspan="4"  ng-show="(listcustomAlerts|filter:search).length == 0" align="center">Record Not Found</td></tr>
                        </tbody>
                    </table>
                    <div class="DTTTFooter">
                        <div class="col-sm-6">
                            <!--<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing {{itemsPerPage * (noOfRows-1)+1}} to of {{ listdefaultAlertsLength }} entries</div>-->
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


