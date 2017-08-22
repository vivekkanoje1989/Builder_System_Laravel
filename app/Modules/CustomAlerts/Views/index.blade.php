<style>
    .toggleClassActive {font-size:40px !important;cursor:pointer;color: #5cb85c !important;vertical-align: middle;margin-left: 15px;}
    .toggleClassInactive {font-size:40px !important;cursor:pointer;color: #d9534f !important;vertical-align: middle;margin-left: 15px;}
</style>
<div class="row" ng-controller="customalertsController" ng-init="manageAlerts('','index',1, [[config('global.recordsPerPage')]])">
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Custom Templates</span>
                <a href="[[ config('global.backendUrl') ]]#/customalerts/create " class="btn btn-primary">Create New Template</a>&nbsp;&nbsp;&nbsp;
            </div>
            <div class="widget-body table-responsive">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                      <label for="search">Search:</label>
                      <input type="text" ng-model="search" class="form-control" style="width:25%;" placeholder="Search">
                    </div>

                    <div class="col-sm-6 col-xs-12">
                      <label for="search">Records per page:</label>
                      <input type="text" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"   minlength="1" maxlength="3" style="width:25%;" class="form-control" ng-model="itemsPerPage">
                    </div>
                </div><br>
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">Sr. No.</th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField='friendly_name'; reverseSort = !reverseSort">Friendly Name
                                    <span ng-show="orderByField == 'friendly_name'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField='sms_body'; reverseSort = !reverseSort">SMS Body
                                    <span ng-show="orderByField == 'sms_body'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField='email_subject'; reverseSort = !reverseSort">Email Subject
                                    <span ng-show="orderByField == 'email_subject'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr dir-paginate="listAlert in listcustomAlerts | filter:search | itemsPerPage: itemsPerPage | orderBy:orderByField:reverseSort" total-items="{{ enquiriesLength }}">
                            <td>{{listAlert.sr_no}}</td>
                            <td>{{ listAlert.friendly_name }}</td>
                            <td>{{ listAlert.sms_body | htmlToPlaintext }}</td>
                            <td>{{ listAlert.email_subject | htmlToPlaintext }}</td>
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit User" style="display: block;"><a href="[[ config('global.backendUrl') ]]#/customalerts/update/{{ listAlert.id }}"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;</div>
                            </td>
                        </tr>
                        <tr><td colspan="4"  ng-show="(listcustomAlerts|filter:search).length==0" align="center">Record Not Found</td></tr>
                    </tbody>
                </table>
                <div class="DTTTFooter">
                     <div class="col-sm-6">
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{pageNumber}}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                        <dir-pagination-controls class="pull-right pagination" on-page-change="pageChanged(newPageNumber,'manageAlerts','','index', newPageNumber, itemsPerPage)" template-url="/dirPagination"></dir-pagination-controls>
                        </div>
                    </div>
                </div>
<!--                <div class="DTTTFooter">
                    <div class="col-sm-6">
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{noOfRows}}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                            <dir-pagination-controls class="pagination" on-page-change="pageChangeHandler(newPageNumber)" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                        </div>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
</div>


