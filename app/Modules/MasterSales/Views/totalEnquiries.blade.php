<div class="widget flat radius-bordered " ng-controller="enquiryController" ng-init="getTotalEnquiries()">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Total Enquiries</span>
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                </div>
            </div>        
            <div data-ng-include=" '[[ config('global.getUrl') ]]/MasterSales/listingTable' "></div>
        </div>
    </div> 
</div>
<!-- Modal -->
<div class="modal fade" id="historyDataModal" role="dialog" tabindex='-1'>
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header navbar-inner">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center">Enquiry History</h4>
            </div>
            <input type="text" ng-model="idd" name="idd" id="idd">
            <div class="modal-body">
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">SR No.</th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'first_name'; reverseSort = !reverseSort">FollowUp By 
                                    <span ng-show="orderByField == 'first_name'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'designation'; reverseSort = !reverseSort">Last FollowUp Date & Time 
                                    <span ng-show="orderByField == 'designation'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'reporting_to_id'; reverseSort = !reverseSort">Remark
                                    <span ng-show="orderByField == 'reporting_to_id'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'team_lead_id'; reverseSort = !reverseSort">Next FollowUp Date & Time
                                    <span ng-show="orderByField == 'team_lead_id'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'department_name'; reverseSort = !reverseSort">Enquiry Status
                                    <span ng-show="orderByField == 'department_name'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="history in historyList | filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
                            <td>{{ $index + 1}}</td>
                            <td>
                                {{ history.first_name}} {{ history.last_name}}
                            </td>
                            <td>
                                {{ history.last_followup_date}}
                            </td>
                            <td>
                                {{history.remarks}}
                            </td>
                            <td>
                                {{ history.next_followup_date}} at {{ history.next_followup_time}}
                            </td>
                            <td>
                                {{history.sales_status}}
                            </td>
                        </tr>
                        <tr ng-if="!historyList.length" align="center"><td colspan="6"> Records Not Found</td>

                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>