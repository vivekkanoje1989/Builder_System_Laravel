<div class="row" ng-controller="cloudtelephonyController" ng-init="managevLists('','index')">    
    <div class="col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Virtual Numbers</span>
            </div>
            <div class="widget-body table-responsive">
                <input type="text" ng-model="search" class="form-control" style="width:25%;" placeholder="Search"><br>
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">Sr. No.</th>
                            <th style="width:7%">Virtual Number</th>
                            <th style="width:7%">Source</th>
                            <th style="width:7%">Sub Source</th>
                            <th style="width:10%">Forwarding Type</th>
                            <th style="width:10%">Menu</th>
                            <th style="width:20%">Employee</th>
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="listNumber in listNumbers | filter:search | itemsPerPage:itemsPerPage">
                            <td>{{ $index + 1}}</td>
                            <td>{{ listNumber.virtual_display_number }}</td>
                            <td>{{listNumber.source_name}}</td>
                            <td ng-if="listNumber.sub_source_id==0">--</td>
                             <td ng-if="listNumber.sub_source_id!=0">{{listNumber.subsource}}</td>
                                                       
                            <td ng-if="listNumber.forwarding_type_id==1">Parallel Forwarding</td>
                            <td ng-if="listNumber.forwarding_type_id==2">Sequential Forwarding</td>
                            <td ng-if="listNumber.forwarding_type_id==3">Round Robin Forwarding</td>
                            <td ng-if="listNumber.forwarding_type_id==0">--</td>

                            <td ng-if="listNumber.menu_status==1">
                               <span ng-bind-html=" listNumber.ext_name"></span>
                            </td>
                            <td ng-if="listNumber.menu_status==0">No</td>
                             <td><span ng-bind-html=" listNumber.employee_name"></span></td>


                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit" style="display: block;"><a href="[[ config('global.backendUrl') ]]#/virtualnumber/update/{{ listNumber.id }}"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5"  ng-show="(listNumbers|filter:search).length==0" align="center">Record Not Found</td>   
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


