
<div class="row" ng-controller="cloudtelephonyController" ng-init="manageLists('','index')">
    
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <a href="[[ config('global.backendUrl') ]]#/cloudtelephony/create" class="btn btn-primary">Create New</a><br><br>
            <div class="widget-header ">
                <span class="widget-caption">Manage Virtual Numbers</span>
            </div>
            <div class="widget-body table-responsive">
                <input type="text" ng-model="search" class="form-control" style="width:25%;" placeholder="Search"><br>
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">Sr. No.</th>
                            <th style="width: 15%">Client Name</th>
                            <th style="width: 10%">Virtual Number</th>
                            <th style="width: 10%">Default Number</th>
                            <th style="width: 10%">Activation Date</th>
                            <th style="width: 10%">Incoming Call Status</th>
                            <th style="width: 10%">Outbound Call Status</th>
                            <th style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="listNumber in listNumbers | filter:search | itemsPerPage:itemsPerPage">
                            <td>{{ $index + 1}}</td>
                            <td>{{ listNumber.marketing_name }}</td>
                            <td>{{ listNumber.virtual_number }}</td>
                            <td ng-if="listNumber.default_number == 1">Yes</td>
                            <td ng-if="listNumber.default_number == 0">No</td>
                            <td>{{ listNumber.activation_date | date:'dd-MM-yyyy' }}</td>
                            <td ng-if="listNumber.incoming_call_status == 1">Yes</td>
                            <td ng-if="listNumber.incoming_call_status == 0">No</td>
                            <td ng-if="listNumber.outbound_call_status == 1">Yes</td>
                            <td ng-if="listNumber.outbound_call_status == 0">No</td>
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit" style="display: block;"><a href="[[ config('global.backendUrl') ]]#/cloudtelephony/update/{{ listNumber.id }}"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;</div>
                            </td>
                        </tr>
                         <tr>
                                <td colspan="11"  ng-show="(listNumbers|filter:search).length==0" align="center">Record Not Found</td>   
                        </tr>
                    </tbody>
                </table>
                <div class="DTTTFooter">
                    <div class="col-sm-6">
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to {{ itemsPerPage }} of {{ listNumbersLength }} entries</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                            <dir-pagination-controls class="pagination" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


