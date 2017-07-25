<div class="row" ng-controller="dashboardCtrl" ng-init="getMyRequest()">    
    <div class="col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">My Request</span>                
            </div>
            <div class="widget-body table-responsive">
                <div class="row">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="search">Search:</label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="search" name="search" class="form-control">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label for="search">Records per page:</label>
                            <input type="text" minlength="1" maxlength="3" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" style="width:30%;" class="form-control" ng-model="itemsPerPage">
                        </div>
                    </div>
                </div>          
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                        <tr>
                            <th style="width:5%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'id'; reverseSort = !reverseSort">Sr. No.
                                    <span ng-show="orderByField == 'id'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>                          
                            <th style="width:15%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'in_date'; reverseSort = !reverseSort">Date
                                    <span ng-show="orderByField == 'in_date'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>
                            <th style="width:15%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'job_eligibility'; reverseSort = !reverseSort">Request Type
                                    <span ng-show="orderByField == 'job_eligibility'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>
                            <th style="width:15%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'first_name'; reverseSort = !reverseSort">Application To
                                    <span ng-show="orderByField == 'first_name'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>
                            <th style="width:20%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'from_date'; reverseSort = !reverseSort">From
                                    <span ng-show="orderByField == 'from_date'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th> 
                            <th style="width:10%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'to_date'; reverseSort = !reverseSort">To
                                    <span ng-show="orderByField == 'to_date'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>
                            <th style="width:10%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'application_close_date'; reverseSort = !reverseSort">Description
                                    <span ng-show="orderByField == 'application_close_date'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>
                                <th style="width:10%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'status'; reverseSort = !reverseSort">Status
                                    <span ng-show="orderByField == 'status'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr role="row" dir-paginate="list in myRequest| filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort" >
                            <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}} </td>
                            <td>{{list.in_date}}</td> 
                            <td> {{list.request_type}}</td>
                            <td>{{list.first_name + " "+ list.last_name }}</td>
                            <td>{{list.from_date}}</td> 
                            <td>{{list.to_date}}</td>
                            <td><a href="" data-toggle="modal" data-target="#myModal" class="btn btn-info" ng-click="view_description({{list}})">View Description</a></td>
                            <td>{{list.status === 1 ? "Leave" : "Approved" }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="DTTTFooter">
                    <div class="col-sm-6">
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{noOfRows}}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                            <dir-pagination-controls class="pagination" on-page-change="pageChangeHandler(newPageNumber)" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" role="dialog" tabindex="-1">    
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">Request Description</h4>
                </div>
                <table class="table table-stripped table-bordered" style="margin:20px 20px 20px 20px; width:90%;">
                    <tr><td>Date</td><td>{{in_date}}</td></tr>
                    <tr><td>Request Type</td><td>{{request_type}}</td></tr>
                    <tr><td>To</td><td>{{to_name}}</td></tr>
                    <tr><td>CC</td><td>{{cc_name}}</td></tr>
                    <tr><td>Description</td><td>{{req_desc}}</td></tr>
                </table>
                 <br/>
            </div>
        </div>
    </div>
</div>
