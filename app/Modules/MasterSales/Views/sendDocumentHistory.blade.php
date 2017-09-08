<table class="table table-hover table-striped table-bordered" at-config="config">
         <thead class="bord-bot">
            <tr>
                <th class="enq-table-th" style="width:5%">SR</th>
                <th class="enq-table-th" style="width: 30%;">
                   Project
                </th>
                <th class="enq-table-th" style="width: 30%">
                    Send Documents
                </th>
                <th class="enq-table-th" style="width: 30%">
                    Send Date
                </th>                
            </tr>
        </thead>
        <tbody ng-repeat="history in sendList track by $index| orderBy:orderByField:reverseSort">
            <tr role="row" >
                <td style="width:4%" rowspan="2">
                    {{ $index + 1}}
                </td>
                <td style="width: 30%;">
                    {{ history.project_id}}
                </td>
                <td style="width: 30%;">
<!--                    <div ng-repeat="(key,data) in history.send_documents track by $index">
                        {{ $index+1 }}.{{key}}
                    </div>-->
                    {{history.send_documents}}
                </td>
                <td style="width: 30%;">
                     {{ history.send_datetime}}
                </td>
            </tr>
        </tbody>
</table>