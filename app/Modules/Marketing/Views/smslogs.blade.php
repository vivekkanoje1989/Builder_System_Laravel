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
<div class="row" ng-controller="promotionalsmsController" ng-init="managesmsLogs('0', 1, [[config('global.recordsPerPage')]])">

    <div class=" mainDiv col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-themeprimary ">
                <span class="widget-caption">Sms Logs</span>
                 <span data-toggle="modal" data-target="#help" class="helpDescription">Help <i class="fa fa-question-circle" aria-hidden="true"></i></span>
                </div>
            <div class="widget-body table-responsive">
                
                <div class="row table-toolbar">
                    <div class="btn-group pull-right filterBtn">
                        <a class="btn btn-default toggleForm" href=""  ng-hide="disableBtn"><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2"  ng-disabled="disableBtn">
                            <span>Actions</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"  ng-disabled="disableBtn"><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a href="" ng-click='smsLogsExpotToxls()' ng-show='exportSmsLogs=="1"'>Export</a>
                                </li>
                            </ul>
                        </a>
                    </div>
                    <div  class="dataTables_filter">
                        <label>
                            <input type="search"  ng-disabled="disableBtn" class="form-control input-sm" ng-model="search" name="search" >
                        </label>
                    </div>
                    <!-- filter data--> 
                    <div class="row" style="border:2px;" id="filter-show">
                        <div class="col-sm-12 col-xs-12">
                            <b ng-repeat="(key, value) in searchData" >
                                <div class="col-sm-2" data-toggle="tooltip"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'fromDate'"  data-toggle="tooltip" title="From Date"><strong>From Date : </strong>  {{ showFilterData.fromDate | date : 'dd-MM-yyyy' }} <span ng-if="showFilterData.toDate">To  {{ showFilterData.toDate | date : 'dd-MM-yyyy' }}</span></strong>
                                        <strong ng-if="key === 'externalId1'" data-toggle="tooltip" title="Transaction Id"><strong>Transaction Id : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'mobile_number'"><strong>Mobile Number : </strong>{{ value}}</strong>
                                        <!--<strong ng-if="key != 'fromDate' && key != 'toDate' && key != 'mobile_number'" data-toggle="tooltip" title="{{ key}}"> {{ value}}</strong>-->
                                    </div>
                                </div>
                            </b>                        
                        </div>
                    </div>
                    <!-- filter data-->
                    <div class="dataTables_length" >
                        <label>
                            <select class="form-control"  ng-disabled="disableBtn" ng-model="itemsPerPage" name="itemsPerPage" onchange="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
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
                                <th style="width:15%">
                                     <a href="javascript:void(0);" ng-click="orderByField('call_date')">Sent Date & Time
                                        <span ><img ng-hide="(sortKey == 'call_date' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'call_date' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'call_date' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width:15%">
                                    <a href="javascript:void(0);" ng-click="orderByField('externalId1')">Transaction Id
                                        <span ><img ng-hide="(sortKey == 'externalId1' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'externalId1' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'externalId1' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width:10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('mobile_number')">Mobile Number
                                        <span ><img ng-hide="(sortKey == 'mobile_number' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'mobile_number' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'mobile_number' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width:20%">
                                    <a href="javascript:void(0);" ng-click="orderByField('sms_body')">SMS Body
                                        <span ><img ng-hide="(sortKey == 'sms_body' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'sms_body' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'sms_body' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
    <!--                            <th style="width:10%">SMS Type</th>-->
                                <th style="width:10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('status')">Delivered Status
                                        <span ><img ng-hide="(sortKey == 'status' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'status' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'status' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width:15%">
                                    <a href="javascript:void(0);" ng-click="orderByField('efname')">SMS Send By
                                        <span ><img ng-hide="(sortKey == 'efname' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'efname' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'efname' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr role="row" dir-paginate="listSms in smslogslist | filter:search |filter:searchData | itemsPerPage:itemsPerPage | orderBy:sortKey:reverseSort" >
                                <td>{{ itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                                <td>{{ listSms.call_date}} @ {{listSms.call_time}}</td>
                                <td>{{ listSms.externalId1}}
                                    <a target="_blank" href="[[ config('global.backendUrl') ]]#/promotionalsms/detaillog/{{ listSms.externalId1}}/{{listSms.employee_id}}" data-toggle="tooltip" >({{listSms.wrapcnt}})</a>
                                </td>

                                <td ng-if="<?php echo Auth::guard('admin')->user()->customer_contact_numbers == 0 ?>">
                                    +91-xxxxxx{{ listSms.mobile_number.substring(listSms.mobile_number.length - 4, listSms.mobile_number.length)}}
                                </td>
                                <td ng-if="<?php echo Auth::guard('admin')->user()->customer_contact_numbers == 1 ?>"> {{listSms.mobile_number}} </td>

                                <td data-toggle="tooltip" title="{{listSms.sms_body}}">
                                    {{ listSms.sms_body | limitTo : 100 }}
                                    <span ng-if="listSms.sms_body.length > 100" data-toggle="tooltip" title="{{listSms.sms_body}}">...</span>
                                </td>
                                <td>{{listSms.status}}</td>
                                <td>{{listSms.efname}}&nbsp;{{listSms.elname}}</td>

                            </tr>
                             <tr>
                                <td colspan="7"  ng-show="(smslogslist|filter:search|filter:searchData).length == 0" align="center">Record Not Found</td>   
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
        <!--<div data-ng-include="'/Marketing/showFilter'"></div>-->
    </div>

    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="hrFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>

            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Transaction Id</label>
                        <span class="input-icon icon-right">
                            <input type="text" name="externalId1" ng-model="searchDetails.externalId1" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" >
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="">Mobile Number </label>
                        <input type="text" ng-model="searchDetails.mobile_number" name="mobile_number" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  maxlength="10">
                    </div>
                </div>

            </div>


            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" align="right">
                    <div class="form-group">
                        <span class="input-icon icon-right">
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


