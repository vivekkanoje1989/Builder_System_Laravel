<!-- Enquiry History Modal -->
<div class="modal fade" id="historyDataModal" role="dialog" tabindex='-1'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header navbar-inner">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center">Enquiry History</h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">SR No.</th>
                            <th style="width: 10%">FollowUp By</th>
                            <th style="width: 10%">Last FollowUp Date & Time</th>
                            <th style="width: 10%">Remark</th>
                            <th style="width: 10%">Next FollowUp Date & Time</th>
                            <th style="width: 10%">Enquiry Category</th>
                            <th style="width: 10%">Enquiry Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" ng-repeat="history in historyList">
                            <td>{{ $index + 1}}</td>
                            <td>
                                {{ history.first_name}} {{ history.last_name}}
                            </td>
                            <td>
                                {{ history.last_followup_date}}
                            </td>
                            <td>
                                {{history.remarks | htmlToPlaintext}}
                            </td>
                            <td>
                                {{ history.next_followup_date}} at {{ history.next_followup_time}}
                            </td>
                            <td>
                                {{history.enquiry_category}}
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