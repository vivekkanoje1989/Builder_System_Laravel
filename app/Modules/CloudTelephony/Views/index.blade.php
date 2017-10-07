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
<div class="row" ng-controller="cloudtelephonyController" ng-init="manageLists('', 'index')">

    <div class="col-xs-12 col-md-12 mainDiv">
        <div class="widget">

            <div class="widget-header bordered-themeprimary bordered-bottom ">
                <span class="widget-caption">Manage</span>
            </div>
            <div class="widget-body table-responsive">
                <div class="row table-toolbar">
                    <a href="[[ config('global.backendUrl') ]]#/cloudtelephony/create" class="btn btn-default">Create New</a>
                    <div class="btn-group pull-right">
                        <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2">
                            <span>Actions</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a href="" ng-click="telephonyRegExportToxls()" ng-show="exportData == '1'">Export</a>
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
                    <div class="row" style="border:2px;" id="filter-show" >
                        <div class="col-sm-12 col-xs-12">
                            <b ng-repeat="(key, value) in searchData">
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'marketing_name'" data-toggle="tooltip" title="Client Name"><strong> Client Name : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'virtual_number'" data-toggle="tooltip" title="Virtual Number"><strong> Virtual Number : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'default_number'" data-toggle="tooltip" title="Default Number"><strong> Default Number : </strong> {{ searchData.default_number == 1? 'Yes':'No'}} </strong>
                                        <strong ng-if="key === 'activation_date'" data-toggle="tooltip" title="Activation Date"><strong> Activation Date : </strong> {{ value}}</strong>
                                     <strong ng-if="key === 'incoming_call_status'" data-toggle="tooltip" title="Incoming Call Status"><strong> Incoming Call Status : </strong> {{ searchData.incoming_call_status == 1? 'Yes':'No'}} </strong>
                                     <strong ng-if="key === 'outbound_call_status'" data-toggle="tooltip" title="Outbound Call Status"><strong> Outbound Call Status : </strong> {{ searchData.outbound_call_status == 1? 'Yes':'No'}} </strong>
                                       </div>
                                </div>
                            </b>                        
                        </div>
                    </div>
                    <!-- filter data-->
                    <div class="dataTables_length" >
                        <label>
                            <select class="form-control" ng-model="itemsPerPage" name="itemsPerPage" onchange="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
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
                                    <a href="javascript:void(0);" ng-click="orderByField('default_number')">Default Number
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
                            <tr role="row" dir-paginate="listNumber in listNumbers | filter:search |filter:searchData| itemsPerPage:itemsPerPage | orderBy:sortKey:reverseSort">
                                <td>{{ itemsPerPage * (noOfRows - 1) + $index + 1}}</td> 
                                <td>{{ listNumber.marketing_name}}</td>
                                <td>{{ listNumber.virtual_number}}</td>
                                <td ng-if="listNumber.default_number == 1">Yes</td>
                                <td ng-if="listNumber.default_number == 0">No</td>
                                <td>{{ listNumber.activation_date }}</td>
                                <td ng-if="listNumber.incoming_call_status == 1">Yes</td>
                                <td ng-if="listNumber.incoming_call_status == 0">No</td>
                                <td ng-if="listNumber.outbound_call_status == 1">Yes</td>
                                <td ng-if="listNumber.outbound_call_status == 0">No</td>
                                <td class="">
                                    <span class="" tooltip-html-unsafe="Edit"><a href="[[ config('global.backendUrl') ]]#/cloudtelephony/update/{{ listNumber.id}}" class="btn-primary btn-xs"><i class="fa fa-edit"></i>Edit</a> &nbsp;&nbsp;</span>
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
    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="calllogsFilterform" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row">
                <div class="col-sm-12 col-sx-12">
                    <div class="form-group">
                        <label for="">Select Client</label>
                        <span class="input-icon icon-right">
                            <select ng-controller="clientCtrl" ng-model="searchDetails.marketing_name" name="marketing_name" class="form-control">
                                <option value="">Select Client</option>
                                <option ng-repeat="client in clients" value="{{client.marketing_name}}">{{client.marketing_name}}</option>
                            </select>
                            <i class="fa fa-sort-desc"></i>
                        </span> 
                    </div>
                </div>
                <div class="col-sm-12 col-sx-12" >
                    <div class="form-group">
                        <label for="">Virtual Number</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.virtual_number" name="virtual_number" class="form-control"  oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                        </span>
                    </div>
                </div>    
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Default Number</label>
                        <span class="input-icon icon-right">
                            <select ng-model="searchDetails.default_number" name="default_number" class="form-control">
                                <option value="">Select </option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            <i class="fa fa-sort-desc"></i>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12" ng-controller="DatepickerDemoCtrl">
                    <div class="form-group">
                        <label for="">Activation Date</label>
                        <span class="input-icon icon-right">
                            <p class="input-group">
                                <input type="text" ng-model="searchDetails.activation_date" placeholder="Activation Date" name="activation_date" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Incoming Call Status</label>
                        <span class="input-icon icon-right">
                            <select ng-model="searchDetails.incoming_call_status" name="incoming_call_status" class="form-control">
                                <option value="">Select </option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            <i class="fa fa-sort-desc"></i>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Outbound Call Status</label>
                        <span class="input-icon icon-right">
                            <select ng-model="searchDetails.outbound_call_status" name="outbound_call_status" class="form-control">
                                <option value="">Select </option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
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
</div>


