<style>
    .close {
        color:black;
    }
    .alert.alert-info {
        border-color: 1px solid #d9d9d9;
        /* background: rgba(173, 181, 185, 0.81); */
        background-color: #f5f5f5;
        border: 1px solid #d9d9d9;
        color: black;
        padding: 5px;
        width: 110%;
    }
</style>
<div class="row" ng-controller="cloudtelephonyController" ng-init="teaminboundLists([[$loggedInUserId]], 1, [[config('global.recordsPerPage')]])">
    <div class="col-xs-12 col-md-12 mainDiv">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Team's Incoming Call Logs</span>
                <span data-toggle="modal" data-target="#help" class="helpDescription">Help <i class="fa fa-question-circle" aria-hidden="true"></i></span>
             </div>
            <div class="widget-body table-responsive">
                
                <div class="row table-toolbar">
                    <div class="btn-group pull-right filterBtn">
                        <a class="btn btn-default toggleForm" href="" ng-hide="disableBtn"><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2" ng-disabled="disableBtn">
                            <span>Actions</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" ng-disabled="disableBtn"><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a href="" ng-click="teamInboundExportToxls()" ng-show="teaminboundExport == '1'">Export</a>
                                </li>
                            </ul>
                        </a>
                    </div>
                    <div  class="dataTables_filter">
                        <label>
                            <input type="search" ng-disabled="disableBtn" class="form-control input-sm" ng-model="search" name="search" >
                        </label>
                    </div>
                    <!-- filter data--> 
                    <div class="row" style="border:2px;" id="filter-show">
                        <div class="col-sm-12 col-xs-12">
                            <b ng-repeat="(key, value) in searchData" >
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'empId'" ng-repeat='emp in value track by $index'> {{ $index + 1}}){{   emp.first_name}}  {{ emp.last_name}} </strong>
                                        <strong ng-if="key === 'customer_number'" data-toggle="tooltip" title="Customer Number"><strong>Customer Number : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'virtual_number'" data-toggle="tooltip" title="Virtual Number"><strong>Virtual Number : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'customer_call_status'"><strong>Call Status : </strong>{{ value}}</strong>
                                    </div>
                                </div>
                            </b>                        
                        </div>
                    </div>
                    <!-- filter data-->
                    <div class="dataTables_length" >
                        <label>
                            <select ng-disabled="disableBtn" class="form-control" ng-model="itemsPerPage" name="itemsPerPage" onchange="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
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
                                <th style="width:5%">Sr. No.</th>
                                <th style="width: 15%">
                                    <a href="javascript:void(0);" ng-click="orderByField('call_date')">Call Date & Time
                                        <span ><img ng-hide="(sortKey == 'call_date' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'call_date' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'call_date' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
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
                                    <a href="javascript:void(0);" ng-click="orderByField('customer_number')">Customer Number
                                        <span ><img ng-hide="(sortKey == 'customer_number' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'customer_number' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'customer_number' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('customer_name')">Customer Name
                                        <span ><img ng-hide="(sortKey == 'customer_name' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'customer_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'customer_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('customer_call_status')">Call Status
                                        <span ><img ng-hide="(sortKey == 'customer_call_status' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'customer_call_status' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'customer_call_status' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('employee_name')">Call Answered By
                                        <span ><img ng-hide="(sortKey == 'employee_name' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'employee_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'employee_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('customer_call_duration')">Call Duration
                                        <span ><img ng-hide="(sortKey == 'customer_call_duration' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'customer_call_duration' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'customer_call_duration' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">Recording</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr dir-paginate="inbound in teaminboundList | filter:search | filter:searchData | itemsPerPage: itemsPerPage | orderBy:sortKey:reverseSort"  >
                                <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}} </td>
                                <td>{{ inbound.call_date + ' @ ' + inbound.call_time}}<br>
                                    <span ng-if="inbound.customer_call_status == 'Non Working Hours Call'">( Non Working Hours Call )</span></td>
                                <td>{{ inbound.virtual_number.toString().substring(2, 12)}} ({{inbound.sales_source_name}}<span ng-if="inbound.enquiry_subsource"> - {{inbound.enquiry_subsource}}</span>)</td>
                                <td>{{ inbound.customer_number}}</td>
                                <td ng-if="inbound.customer_name != ' '">{{ inbound.customer_name}}</td>
                                <td ng-if="inbound.customer_name == ' '">-</td>
                                <td>{{ inbound.customer_call_status}}</td>
                                <td>{{ inbound.employee_name}}</td>
                                <td>{{ inbound.customer_call_duration}}</td>
                                <td><audio id="teamobject_{{ inbound.id}}" controls></audio></td>
                            </tr>
                            <tr>
                                <td colspan="9"  ng-show="(teaminboundList|filter:search | filter:searchData).length == 0" align="center">Record Not Found</td>   
                                <td colspan="9"  ng-if="teaminboundLength == 0" align="center">Records Not Found</td>   
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
                    <div data-ng-include="'/cloudtelephony/showFilter'" ></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="calllogsFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row" ng-controller="employeesWiseTeamCtrl">
                <div class="col-sm-12 col-sx-12" ng-if="employeesData.length > 0 && type == 1">
                    <div class="form-group">
                        <label for="">Select Call Answered By</label>
                        <span class="input-icon icon-right">                                                
                            <ui-select multiple ng-model="searchDetails.empId" name="empId" theme="select2" ng-disabled="disabled" style="width: 100%;">
                                <ui-select-match placeholder='Select Employee'>{{ $item.first_name}} {{$item.last_name}}</ui-select-match>
                                <ui-select-choices repeat="list in employeesData | filter:$select.search">
                                    <span>
                                        {{ list.first_name}} {{ list.last_name}}
                                    </span>
                                </ui-select-choices>
                            </ui-select>
                            <i class="fa fa-sort-desc"></i>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-sx-12" >
                    <div class="form-group">
                        <label for="">Customer Number</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.customer_number" name="customer_number" class="form-control" value="{{customer_number}}"  oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                        </span>
                    </div>
                </div>    
                <div class="col-sm-12 col-xs-12" ng-controller="virtualnumberCtrl">
                    <div class="form-group">
                        <label for="">Virtual Number</label>
                        <span class="input-icon icon-right">
                            <select ng-model="searchDetails.virtual_number" name="virtual_number" class="form-control">
                                <option value="">Select virtual number</option>
                                <option ng-repeat="list in virtualnolist track by $index" value="{{list.virtual_display_number}}">{{list.virtual_display_number}}</option>
                            </select>
                            <i class="fa fa-sort-desc"></i>
                        </span>
                    </div>
                </div>

                <div class="col-sm-12 col-xs-12" ng-controller="virtualnumberCtrl">
                    <div class="form-group">
                        <label for="">Call Status</label>
                        <span class="input-icon icon-right">
                            <select ng-model="searchDetails.customer_call_status" name="customer_call_status" class="form-control">
                                <option value="">Select call status</option>
                                <option ng-repeat="status in statuscall track by $index" value="{{status}}">{{status}}</option>
                            </select>
                            <i class="fa fa-sort-desc"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" >
                    <div class="form-group">
                        <span class="input-icon icon-right" align="center">
                            <button type="submit" name="sbtbtn" value="Search" class="btn btn-primary toggleForm">Search</button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="/js/filterSlider.js"></script>
    <!-- Filter Form End-->
    <div class="modal fade" id="help" role="dialog" tabindex="-1" >    
        <div class="modal-dialog">
           
            <div class="modal-content helpModal" >
                <div class="modal-header helpModalHeader bordered-bottom bordered-themeprimary" >
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title" align="center">Task Priority Help Info</h4>
                </div>                
                <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label class="helpContent">Priority </label>
                                <span class="input-icon icon-right">                                    
                                    
                                </span>
                            </div>                            
                        </div>
                    </div>  
            </div>
        </div>
    </div>
</div>


