
<div class="row" ng-controller="cloudtelephonyController" ng-init="manageLists('', 'index')">

    <div class="col-xs-12 col-md-12 mainDiv">
        <div class="widget">

            <div class="widget-header ">
                <span class="widget-caption">Manage Virtual Numbers</span>
            </div>
            <div class="widget-body table-responsive">
                <div class="row table-toolbar">
                    <!--<a href="" data-toggle="modal" data-target="#bloodGroupModal" ng-click="initialModal(0, '', '')" class="btn btn-default">Add Blood Group</a>-->
                    <a href="[[ config('global.backendUrl') ]]#/cloudtelephony/create" class="btn btn-default">Create New</a><br><br>
                    <!--<a id="editabledatatable_new" href="" class="btn btn-default" data-toggle="modal" data-target="#verticalModal" ng-click="initialModal(0, '', '', '', '')">Add New Vertical</a>-->
                    <div class="btn-group pull-right">
                        <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Excel" ng-click="bloodGroupExportToxls()" ng-show="exportData == '1'">
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
                    <div class="row" style="border:2px;" id="filter-show" ng-controller="adminController">
                        <div class="col-sm-12 col-xs-12">
                            <b ng-repeat="(key, value) in searchData" ng-if="value != 0">
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'blood_group'" data-toggle="tooltip" title="Blood Group"><strong> Blood Group : </strong> {{ value}}</strong>
                                    </div>
                                </div>
                            </b>                        
                        </div>
                    </div>
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
                                <th style="width: 15%">
                                    <a href="javascript:void(0);" ng-click="orderByField('marketing_name')">Client Name
                                        <span ><img ng-hide="(sortKey == 'marketing_name' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'marketing_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'marketing_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('virtual_number')">Virtual Number
                                        <span ><img ng-hide="(sortKey == 'virtual_number' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'virtual_number' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'virtual_number' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%"> 
                                    <a href="javascript:void(0);" ng-click="orderByField('virtual_number')">Default Number
                                        <span ><img ng-hide="(sortKey == 'default_number' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'default_number' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'default_number' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('activation_date')">Activation Date
                                        <span ><img ng-hide="(sortKey == 'activation_date' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'activation_date' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'activation_date' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('incoming_call_status')">Incoming Call Status
                                        <span ><img ng-hide="(sortKey == 'incoming_call_status' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'incoming_call_status' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'incoming_call_status' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a></th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('outbound_call_status')">Outbound Call Status
                                        <span ><img ng-hide="(sortKey == 'outbound_call_status' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'outbound_call_status' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'outbound_call_status' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" dir-paginate="listNumber in listNumbers | filter:search | itemsPerPage:itemsPerPage | orderBy:sortKey:reverseSort">
                                <td>{{ itemsPerPage * (noOfRows - 1) + $index + 1}}</td> 
                                <td>{{ listNumber.marketing_name}}</td>
                                <td>{{ listNumber.virtual_number}}</td>
                                <td ng-if="listNumber.default_number == 1">Yes</td>
                                <td ng-if="listNumber.default_number == 0">No</td>
                                <td>{{ listNumber.activation_date | date:'dd-MM-yyyy' }}</td>
                                <td ng-if="listNumber.incoming_call_status == 1">Yes</td>
                                <td ng-if="listNumber.incoming_call_status == 0">No</td>
                                <td ng-if="listNumber.outbound_call_status == 1">Yes</td>
                                <td ng-if="listNumber.outbound_call_status == 0">No</td>
                                <td class="">
                                    <span class="" tooltip-html-unsafe="Edit"><a href="[[ config('global.backendUrl') ]]#/cloudtelephony/update/{{ listNumber.id}}" class="btn-info btn-xs"><i class="fa fa-edit"></i>Edit</a> &nbsp;&nbsp;</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="11"  ng-show="(listNumbers|filter:search | filter:searchData).length == 0" align="center">Record Not Found</td>   
                            </tr>
                        </tbody>
                    </table>
                    <div class="DTTTFooter">
                        <div class="col-sm-6"><div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{noOfRows}}</div>
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
</div>


