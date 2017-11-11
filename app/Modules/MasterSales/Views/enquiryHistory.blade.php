<div class="modal-body"> 
    <div>
            <label>
                <input type="checkbox" name="chk_enquiry_history" ng-click="getModulesWiseHist(history_enquiryId,1)" id="chk_enquiry_history" class="chk_enquiry_history">
                <span class="text">All</span>
            </label>
            &nbsp;&nbsp;
            <label>
                <input type="checkbox" name="chk_enquiry_history" ng-click="getModulesWiseHist(history_enquiryId,0)" data-id="1" class="chk_followup_history_all" id="chk_presales">
                <span class="text">Pre Sales</span>
            </label>
            &nbsp;&nbsp;
            <label>
                <input type="checkbox" name="chk_cc_follouwp_history" ng-click="getModulesWiseHist(history_enquiryId,0)" data-id="2"  class="chk_followup_history_all" id="chk_Customer_Care">
                <span class="text">Customer Care</span>
            </label>
            <hr class="enq-hr-line">           
                1) <span>PS = Pre Sales</span> &nbsp;&nbsp;2) <span>CC = Customer Care</span>            
            <hr class="enq-hr-line">    
    </div>
    <div style="height: auto;max-height: 605px;margin-top: 0px;    overflow-x: hidden;overflow-y: scroll;">
        <table class="table table-hover table-striped table-bordered" at-config="config" >
        <thead class="bord-bot">
            <tr>
                <th class="enq-table-th" style="width:3%">SR</th>
                <th class="enq-table-th" style="width: 13%;">
                    Followup By 
                </th>
                <th class="enq-table-th" style="width: 13%">
                    Last  
                </th>
                <th class="enq-table-th" style="width: 13%">
                    Next
                </th>
                <th class="enq-table-th" style="width: 20%">
                    Status
                </th>
                <th class="enq-table-th" style="width: 38%">
                    Remarks
                </th>
            </tr>
        </thead>
        <tbody ng-repeat="history in historyList track by $index | filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
            <tr role="row" >
                <td style="width:4%" rowspan="2">
                    {{ $index + 1}}
                </td>
                <td style="width: 10%;">
                    <div>
                        {{ history.first_name}}  {{ history.last_name}}    
                        <span>
                            <b>({{history.short_name}})</b>
                        </span>
                    </div>
                    
                </td>
                <td style="width: 10%">
                    {{ history.last_followup_date | split:'@':0}}<br/> @ {{ history.last_followup_date | split:'@':1 }}
                </td>
                

                <td style="width: 10%">
                    <span ng-if="history.next_followup_date !=null && history.next_followup_date !='00-00-0000'">
                        {{ history.next_followup_date}} <br/>@ {{ history.next_followup_time}}
                    </span>
                    <span ng-if="history.next_followup_date == null || history.next_followup_date =='00-00-0000'">
                        <center>  -</center>
                    </span>
                    
                </td>
                <td style="width: 8%">
                    <div ng-show="history.cc_presales_status != null">
                        {{history.cc_presales_status}} <span ng-if="history.cc_presales_substatus != null ">/<br/></span>
                        {{history.cc_presales_substatus}}
                    </div>
                    <div ng-show="history.sales_status != null">
                            {{history.sales_status}} <span ng-if="history.enquiry_sales_substatus != null ">/<br/></span>
                            {{history.enquiry_sales_substatus}}
                    </div>
                    <div ng-show="history.cc_presales_status == null && history.sales_status == null">
                        N/A
                    </div>
                    
                </td>               
                <td style="width: 16%">
                    <span data-toggle="tooltip" title="{{history.remarks| removeHTMLTags}}">{{history.remarks| removeHTMLTags | limitTo : 150 }} </span>  
                    <span ng-if="history.remarks.length > 150" data-toggle="tooltip" title="{{history.remarks| removeHTMLTags}}">...</span>
                </td>
            </tr>
            <tr ng-if="history.call_recording_url != '' && history.call_recording_url != 'None' && history.call_recording_url != None">
                <td colspan="7">
                    <audio style="width: 600px;" id="recording_{{ history.id}}" controls></audio>
                </td>
            </tr>            
        </tbody>
        <tr ng-if="historyList.length == 0">
            <td colspan="6" class="text-align-center">
                --Record Not Found--
            </td>
        </tr>
    </table>
    </div>
</div>
<style>
    .errMsg{
        color:red;
    }
</style>