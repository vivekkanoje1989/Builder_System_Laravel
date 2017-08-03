<!-- Enquiry History Modal -->
<div class="modal-body">
    <table class="table table-hover table-striped table-bordered" at-config="config">
         <thead class="bord-bot">
            <tr>
                <th class="enq-table-th" style="width:3%">SR</th>
                <th class="enq-table-th" style="width: 13%;">
                    Follow-up By 
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
            <tbody ng-repeat="history in historyList track by $index| filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
            <!--<tr>    
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
            <tr ng-if="!historyList.length" align="center"><td colspan="7"> Records Not Found</td>
            </tr> -->

            <tr role="row" >
                <td style="width:4%" rowspan="2">
                    {{ $index + 1}}
                </td>
                <td style="width: 10%;">
                    {{ history.first_name}}  {{ history.last_name}}
                </td>
                <td style="width: 10%">
                    {{ history.last_followup_date | split:'@':0}}<br/> @ {{ history.last_followup_date | split:'@':1 }}
                </td>

                <td style="width: 10%">
                    {{ history.next_followup_date}} <br/>@ {{ history.next_followup_time}}
                </td>
                <td style="width: 8%">
                    {{history.sales_status}} <span>/</span><br/>
                    {{history.enquiry_sales_substatus}}
                </td>
                <td style="width: 16%">
                    <span data-toggle="tooltip" title="{{history.remarks| removeHTMLTags}}">{{history.remarks| removeHTMLTags | limitTo : 150 }} </span>  
                    <span ng-if="history.remarks.length > 150" data-toggle="tooltip" title="{{history.remarks| removeHTMLTags}}">...</span>
                </td>
            </tr>
            <tr ng-if="history.call_recording_url != '' && history.call_recording_url != 'None' && history.call_recording_url != None">
                <td colspan="7">
                    <audio id="recording_{{ history.id}}" controls></audio>
                </td>
            </tr>
            <tr ng-if="!historyList.length" align="center"><td colspan="6"> Records Not Found</td>

            </tr>
        </tbody>
    </table>
</div>