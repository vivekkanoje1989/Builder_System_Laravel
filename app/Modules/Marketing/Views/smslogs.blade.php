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
            <div class="widget-header ">
                <span class="widget-caption">Sms Logs</span>
            </div>
            <div class="widget-body table-responsive">
                <div class="row">    
                    <div class="col-sm-3 col-xs-12" style="float:left"> 
                            <input type="text" minlength="1" maxlength="3"  ng-model="itemsPerPage" ng-change="managesmsLogs('0',{{pageNumber}}, itemsPerPage)" ng-model-options="{ updateOn: 'blur' }" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  class="form-control">
                        
                    </div>     
                    <div class="col-sm-6 col-xs-12 dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginat">                         
                        <span ng-if="smslogslength != 0" >&nbsp; &nbsp; &nbsp; Showing {{smslogslist.length}}  Logs Out Of Total {{smslogslength}} Logs.  &nbsp;</span>
                        <dir-pagination-controls max-size="5"  class="pull-right pagination" on-page-change="pageChanged(newPageNumber,0,'managesmsLogs',itemsPerPage)" template-url="/dirPagination" ng-if="smslogslength"></dir-pagination-controls>                        
                    </div>
                    <!--                    <div class="col-sm-6 col-xs-12">
                                            <button type="button" class="btn btn-primary btn-right toggleForm" style="margin-right: 10px;"><i class="btn-label fa fa-filter"></i>Show Filter</button>
                                        </div>-->
                    <div class="col-sm-3 ">
                        <button type="button" class="btn btn-primary ng-click-active btn-right toggleForm"  data-toggle="modal" data-target="#showFilterModal" ng-click="procName('proc_smslogs', '0')">
                            <i class="btn-label fa fa-filter"></i>Show Filter</button>
                    </div>
                </div>
                <hr>
                <!-- filter data-->
                <div class="row" style="border:2px;" id="filter-show">
                    <div class="col-sm-12 col-xs-12">
                        <b ng-repeat="(key, value) in showFilterData" ng-if="value != 0 && key != 'toDate'">
                            <div class="col-sm-3" data-toggle="tooltip"> 
                                <div class="alert alert-info fade in">
                                    <button class="close" ng-click="removeDataFromFilter('{{ key}}');" data-dismiss="alert"> ×</button>
                                    <strong ng-if="key === 'fromDate'"  data-toggle="tooltip" title="From Date"><strong>From Date : </strong>  {{ showFilterData.fromDate | date : 'dd-MM-yyyy' }} <span ng-if="showFilterData.toDate">To  {{ showFilterData.toDate | date : 'dd-MM-yyyy' }}</span></strong>
                                    <strong ng-if="key === 'mobile_number'"><strong>Mobile Number : </strong>{{ value}}</strong>
                                    <strong ng-if="key != 'fromDate' && key != 'toDate' && key != 'mobile_number'" data-toggle="tooltip" title="{{ key}}"> {{ value}}</strong>
                                </div>
                            </div>
                        </b>                        
                    </div>
                </div>
                <!-- filter data-->


                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">Sr. No.</th>
                            <th style="width:15%">Sent Date & Time</th>
                            <th style="width:15%">Transaction Id</th>
                            <th style="width:10%">Mobile Number</th>
                            <th style="width:20%">SMS Body</th>
<!--                            <th style="width:10%">SMS Type</th>-->
                            <th style="width:10%">Delivered Status</th>
                            <th style="width:15%">SMS Send By</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr role="row" dir-paginate="listSms in smslogslist | filter:search | itemsPerPage:itemsPerPage" total-items="{{ smslogslength}}">
                            <td>{{itemsPerPage * (pageNumber - 1) + $index + 1}}</td>
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
                            <td colspan="7"  ng-show="(smslogslist|filter:search).length == 0" align="center">Record Not Found</td>   
                        </tr>
                    </tbody>
                </table><br>
                <div class="DTTTFooter">
                    <div class="col-sm-6">
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{pageNumber}}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                            <dir-pagination-controls max-size="5" class="pull-right pagination" on-page-change="pageChanged(newPageNumber,0,'managesmsLogs',itemsPerPage)" template-url="/dirPagination" ng-if="smslogslength"></dir-pagination-controls>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!--<div data-ng-include="'/Marketing/showFilter'"></div>-->
    </div>

    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="smsFilter" role="form" ng-submit="getFilteredData(filterData, 1, [[ config('global.recordsPerPage')]])"> 

            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>


            <div class="row">
                <div class="col-xs-12" ng-controller="DatepickerDemoCtrl">
                    <div class="form-group">
                        <label for="">From Date</label>
                        <span class="input-icon icon-right">
                            <p class="input-group">
                                <input type="text" ng-model="filterData.fromDate" name="fromDate" id="fromDate" class="form-control" datepicker-popup='dd-MM-yyyy' is-open="opened" max-date="dt" datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </span>
                    </div>
                </div>
                <div class=" col-xs-12" ng-controller="DatepickerDemoCtrl">
                    <div class="form-group">
                        <label for=""> To Date</label>
                        <span class="input-icon icon-right">
                            <p class="input-group">
                                <input type="text" ng-model="filterData.toDate"  name="toDate" id="toDate" class="form-control" datepicker-popup='dd-MM-yyyy' is-open="opened" max-date="dt" datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </span>
                    </div>
                </div>
            </div>  

            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="">Mobile Number </label>
                        <input type="text" ng-model="filterData.mobile_number" name="mobile_number" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  maxlength="10">
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

</div>


