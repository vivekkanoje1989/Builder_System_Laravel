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
<div class="row" ng-controller="customerCtrl" ng-init="manageCustomer()">  
    <div class="mainDiv col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Customer Data</span>                
            </div>
            <div class="widget-body table-responsive">
                <!-- filter data-->
                <div class="row table-toolbar">
                    <div class="btn-group pull-right filterBtn">
                        <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <!--                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Excel" ng-show="exportBtn == '1'" ng-click="customerDetailsExportToxls()">
                                                    <span>Export</span>
                                                </a>-->
                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2">
                            <span>Actions</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a href=""  ng-show="exportBtn == '1'" ng-click="customerDetailsExportToxls()">Export</a>
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
                    <div class="row" style="border:2px;" id="filter-show">
                        <div class="col-sm-12 col-xs-12">
                            <b ng-repeat="(key, value) in searchData"  ng-if="value != 0">
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'firstName'" data-toggle="tooltip" title="Customer Name"><strong>Customer Name : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'profession'" data-toggle="tooltip" title="Profession"><strong>Profession : </strong>{{ value}}</strong>
                                        <strong ng-if="key === 'sales_source_name'"  data-toggle="tooltip" title="Source"><strong>Source : </strong>{{ value}}</strong>
                                        <strong ng-if="key === 'email_privacy_status'"  data-toggle="tooltip" title="Email Status"><strong>Email Status : </strong>{{ value == 1 ? "Yes" : "No"}}</strong>
                                        <strong ng-if="key === 'sms_privacy_status'"  data-toggle="tooltip" title="SMS Status"><strong>SMS Status : </strong>{{ value == 1 ? "Yes" : "No"}}</strong>
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
                                <th style="width:5%">Title</th>
                                <th style="width:17%">
                                    <a href="javascript:void(0);" ng-click="orderByField('firstName')">Customer Name
                                        <span ><img ng-hide="(sortKey == 'firstName' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'firstName' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'firstName' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width:20%">
                                    <a href="javascript:void(0);" ng-click="orderByField('profession')">Profession
                                        <span ><img ng-hide="(sortKey == 'profession' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'profession' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'profession' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>  
                                <th style="width:20%">
                                    <a href="javascript:void(0);" ng-click="orderByField('sales_source_name')">Source
                                        <span ><img ng-hide="(sortKey == 'sales_source_name' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'sales_source_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'sales_source_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th> 
                                <th style="width:10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('email_privacy_status')">Email Status
                                        <span ><img ng-hide="(sortKey == 'email_privacy_status' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'email_privacy_status' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'email_privacy_status' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th> 
                                <th style="width:8%">
                                    <a href="javascript:void(0);" ng-click="orderByField('sms_privacy_status')">SMS Status
                                        <span ><img ng-hide="(sortKey == 'sms_privacy_status' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'sms_privacy_status' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'sms_privacy_status' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th> 
                                <th style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" dir-paginate="list in customerDataRow| filter:search | filter:searchData | itemsPerPage:itemsPerPage | orderBy:sortKey:reverseSort">
                                <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                                <td>{{list.title}}</td>
                                <td>{{list.firstName}}</td>     
                                <td>{{list.profession}}</td>     
                                <td>{{list.sales_source_name}}</td>     
                                <td>{{(list.email_privacy_status == 1) ? "Yes" : "No"}}</td>     
                                <td>{{(list.sms_privacy_status == 1) ? "Yes" : "No"}}</td>     
                                <td class="">
                                    <span class="" tooltip-html-unsafe="Edit"><a href="[[ config('global.backendUrl') ]]#/customers/update/{{ list.id}}" class="btn-info btn-xs"><i class="fa fa-edit"></i>Edit</a></span>
                                    <span ng-show="deleteBtn == '1'" class="" tooltip-html-unsafe="Delete"><a href="" ng-click="confirm({{list.id}},{{$index}})" class="btn-danger btn-xs"><i class="fa fa-trash-o"></i>Delete</a></span>

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
    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="customerFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Customer Name</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.firstName" name="firstName" class="form-control" oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')">
                        </span>
                    </div>
                </div>

                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Profession</label>
<!--                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.profession" name="profession" class="form-control" oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')">
                        </span>-->
                        <span class="input-icon icon-right">
                            <select ng-controller="professionCtrl" ng-model="searchDetails.profession" name="profession" class="form-control" >
                                <option value="">Select Title</option>
                                <option ng-repeat="profession in professions" ng-selected="searchDetails.profession == profession"  value="{{profession.profession}}">{{profession.profession}}</option>
                            </select>
                            <i class="fa fa-sort-desc"></i>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group" ng-controller="enquirySourceCtrl">
                        <label for="">Source</label>
                        <select  ng-model="searchDetails.sales_source_name" name="sales_source_name" class="form-control">
                            <option value="">Select Source</option>
                            <option ng-repeat="source in sourceList"  ng-selected="searchDetails.sales_source_name == source.sales_source_name"  value="{{source.sales_source_name}}">{{source.sales_source_name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Email status</label>
                        <span class="input-icon icon-right">
                            <select ng-model="searchDetails.email_privacy_status" name="email_privacy_status" class="form-control">
                                <option value="">Select status </option>
                                <option value="1">Yes </option>
                                <option value="2">No </option>
                            </select>

                        </span>    
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">SMS status</label>
                        <span class="input-icon icon-right">
                            <select ng-model="searchDetails.sms_privacy_status" name="sms_privacy_status" class="form-control">
                                <option value="">Select status </option>
                                <option value="1">Yes </option>
                                <option value="2">No </option>
                            </select>
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


