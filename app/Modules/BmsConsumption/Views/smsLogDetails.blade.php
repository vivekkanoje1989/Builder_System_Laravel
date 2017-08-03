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
    .smslog th{
        text-align:center;
    }
    .smslog td{
        text-align:center;
    }
</style>
<div class="row" ng-controller="smsController" ng-init="smsLogsDetails([[$transactionId]], 1)">

    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">
                    Details View Of Transaction Id :- [[$transactionId]] </span>
            </div>
            <div class="widget-body table-responsive">
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot smslog">
                        <tr>
                            <th style="width:5%">Sr. No.</th>
                            <th style="width: 10%">Sent Date & Time</th>
                            <th style="width: 10%">Mobile Number</th>
                            <th style="width: 30%">SMS Body</th>
                            <th style="width: 5%">Excel file</th>
                            <th style="width: 10%">Employee</th>
                            <th style="width: 5%">SMS Type</th>
                            <th style="width: 5%">Delivery Status</th>
                            <th style="width: 10%">Date & Time</th>
                            <th style="width: 5%">Reason</th>
                            <th style="width: 5%">Credits Billed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="smslog" dir-paginate="smsLogDetails in smsLogsDetails | filter:search | itemsPerPage: itemsPerPage" total-items="{{ smsLogLength}}">
                            <td>{{ itemsPerPage * (pageNumber - 1) + $index + 1}}</td>  
                            <td>{{ smsLogDetails.dateTime}}</td>
                            <td>{{ smsLogDetails.mobile}}</td>
                            <td>{{ smsLogDetails.sms_body}}</td>
                            <td>-</td>
                            <td>{{ employee_name}}</td>
                            <td>{{ smsLogDetails.sms_type}}</td>
                            <td>{{ smsLogDetails.status}}</td>
                            <td>{{ smsLogDetails.dateTime}}</td>
                            <td>{{ smsLogDetails.status}}</td>
                            <td>{{ smsLogDetails.credits_deducted}}</td>

                        </tr>
                        <tr>
                            <td colspan="8"  ng-show="(smsLogsDetails|filter:search).length == 0" align="center">Record Not Found</td>   
                        </tr>
                    </tbody>
                </table><br>
                <!--                <div class="DTTTFooter">
                                    <div class="col-sm-6">
                                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{pageNumber}}</div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                                            <dir-pagination-controls class="pull-right pagination" on-page-change="pageChanged(newPageNumber,'smsLogsLists')" template-url="/dirPagination"></dir-pagination-controls>
                                        </div>
                                    </div>
                                </div>-->
            </div>
        </div>
    </div>

</div>

