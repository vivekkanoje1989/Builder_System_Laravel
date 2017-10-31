<style>
    .toggleClassActive {font-size:40px !important;cursor:pointer;color: #5cb85c !important;vertical-align: middle;margin-left: 15px;}
    .toggleClassInactive {font-size:40px !important;cursor:pointer;color: #d9534f !important;vertical-align: middle;margin-left: 15px;}
</style>
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
<div class="row" ng-controller="customalertsController" ng-init="manageAlerts('', 'index', 1, [[config('global.recordsPerPage')]])">
    <div class="col-xs-12 col-md-12 mainDiv">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Custom Templates</span>
                <span class="helpDescription" ng-mouseover="showHelpCustomTemplate()">Help?</span>
            </div>
            <div class="widget-body table-responsive">
                <div class="row table-toolbar">
                    <a href="[[ config('global.backendUrl') ]]#/customalerts/create " class="btn btn-default">Create New Template</a>&nbsp;&nbsp;&nbsp;
                    <div class="btn-group pull-right filterBtn">
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
                                    <a href="" ng-click="customTemplatesExportToxls()" ng-show="exportData == '1'" >Export</a>
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
                            <b ng-repeat="(key, value) in searchData" >
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'friendly_name'" data-toggle="tooltip" title="Friendly Name"><strong> Friendly Name : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'sms_body'" data-toggle="tooltip" title="Sms Body"><strong> Sms Body : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'email_subject'" data-toggle="tooltip" title="Email Subject"><strong> Email Subject : </strong> {{ value}}</strong>
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
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('friendly_name')">Friendly Name
                                        <span ><img ng-hide="(sortKey == 'friendly_name' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'friendly_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'friendly_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('sms_body')">SMS Body
                                        <span ><img ng-hide="(sortKey == 'sms_body' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'sms_body' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'sms_body' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('email_subject')">Email Subject
                                        <span ><img ng-hide="(sortKey == 'email_subject' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'email_subject' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'email_subject' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr dir-paginate="listAlert in listcustomAlerts | filter:search  | filter:searchData | itemsPerPage: itemsPerPage | orderBy:sortKey:reverseSort" id='{{listAlert.id}}'>
                                <td>
                        <center>
                            {{itemsPerPage * (noOfRows - 1) + $index + 1}}<br>                              
                        </center>
                        </td>
                        <td>{{ listAlert.friendly_name}}</td>
                        <td>{{ listAlert.sms_body | htmlToPlaintext }}</td>
                        <td>{{ listAlert.email_subject | htmlToPlaintext }}</td>
                        <td class="">
                            <span class="" tooltip-html-unsafe="Edit Custom Template" ><a href="[[ config('global.backendUrl') ]]#/customalerts/update/{{ listAlert.id}}" class="btn-primary btn-xs"><i class="fa fa-edit"></i>Edit</a> &nbsp;&nbsp;</span>
                            <span  ng-show="deleteBtn == '1'" class="" tooltip-html-unsafe="Delete"><a href="" ng-click="confirm({{listAlert.id}},{{$index}})" class="btn-danger btn-xs"><i class="fa fa-trash-o"></i>Delete</a></span>
                        </td>
                        </tr>
                        <tr><td colspan="5"  ng-show="(listcustomAlerts|filter:search | filter:searchData).length == 0" align="center">Record Not Found</td>
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
        <form name="bloodGroupFilter" role="form" ng-submit="filterDetails(searchDetails)">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>

            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Template For</label>
                        <span class="input-icon icon-right" ng-init="manageAlerts('', 'index')"> 
                            <select class="form-control"  ng-model="searchDetails.friendly_name" name="friendly_name" id="event_name" >
                                <option value="">Select Friendly Name</option>
                                <option ng-repeat="item in listcustomAlerts" value="{{item.friendly_name}}" ng-selected="{{ item.friendly_name == searchDetails.friendly_name}}" >{{item.friendly_name}}</option>
                            </select>
                        </span>
                    </div>
                </div>

                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Sms Body</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.sms_body" name="sms_body" class="form-control">
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Email Subject</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.email_subject" name="email_subject" class="form-control">
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" >
                    <div class="form-group">
                        <span class="input-icon icon-right" >
                            <button type="submit"  style="margin-left: 46%;" name="sbtbtn" value="Search" class="btn btn-primary toggleForm">Search</button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="/js/filterSlider.js"></script>
    <!-- Filter Form End-->
</div>


