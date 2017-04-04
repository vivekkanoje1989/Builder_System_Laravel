<div class="row" ng-controller="dashboardCtrl" ng-init="getRequestForMe()">  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Requests for Me</span>
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body table-responsive">     
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <label for="search">Search:</label>
                        <input type="text" ng-model="search" class="form-control" style="width:25%;" placeholder="Search">
                    </div>

                    <div class="col-sm-6 col-xs-12">
                        <label for="search">Records per page:</label>
                        <input type="number" min="1" max="50" style="width:25%;" class="form-control" ng-model="itemsPerPage">
                    </div>
                </div><br>           
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                        <tr>
                            <th style="width:5%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'id'; reverseSort = !reverseSort">SR No.
                                    <span ng-show="orderByField == 'id'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>                          
                            <th style="width:15%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'created_at'; reverseSort = !reverseSort">Date
                                    <span ng-show="orderByField == 'created_at'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>
                            <th style="width:15%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'job_eligibility'; reverseSort = !reverseSort">Request Type
                                    <span ng-show="orderByField == 'job_eligibility'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>
                            <th style="width:15%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'first_name'; reverseSort = !reverseSort">Application From
                                    <span ng-show="orderByField == 'first_name'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>
                            <th style="width:20%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'from_date'; reverseSort = !reverseSort">From
                                    <span ng-show="orderByField == 'from_date'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th> 
                            <th style="width:10%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'to_date'; reverseSort = !reverseSort">To
                                    <span ng-show="orderByField == 'to_date'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>
                            <th style="width:10%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'application_close_date'; reverseSort = !reverseSort">Description
                                    <span ng-show="orderByField == 'application_close_date'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>
                            <th style="width:10%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'status'; reverseSort = !reverseSort">Status
                                    <span ng-show="orderByField == 'status'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="list in myRequest| filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort" >
                            <td>{{$index + 1}}</td>
                            <td>{{list.created_at}}</td> 
                            <td> {{list.request_type}}</td>
                            <td>{{list.first_name + " " + list.last_name}}</td>
                            <td>{{list.from_date}}</td> 
                            <td>{{list.to_date}}</td>
                            <td><a href="" data-toggle="modal" data-target="#myModal" class="btn btn-info" ng-click="view_description({{list.id}},'{{list.created_date}}','{{list.request_type}}','{{list.from_date}}','{{list.to_date}}','{{list.req_desc}}','{{list.first_name}}','{{list.last_name}}')">View Description</a></td>
                            <td><a href="" data-toggle="modal" data-target="#newModal" class="btn btn-info" ng-click="statusChange({{list.id}},'{{list.created_date}}','{{list.request_type}}','{{list.from_date}}','{{list.to_date}}','{{list.req_desc}}','{{list.first_name}}','{{list.last_name}}',$index);" >Select status</a></td>
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
                    <h4 class="modal-title" align="center">Requests (Request Description)</h4>
                </div>
                <table class="table table-stripped table-bordered" style="margin:20px 20px 20px 20px; width:90%;">
                    <tr><td>Date</td><td>{{created_date}}</td></tr>
                    <tr><td>Request Type</td><td>{{request_type}}</td></tr>
                    <tr><td>To</td><td>{{to_name}}</td></tr>
                    <tr><td>CC</td><td>{{cc_name}}</td></tr>
                    <tr><td>Description</td><td>{{req_desc}}</td></tr>
                </table>
                <br/>
            </div>
        </div>
    </div>
    <div class="modal fade" id="newModal" role="dialog" tabindex="-1">    
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">Assign status</h4>
                </div>
                <form novalidate ng-submit="requestForForm.$valid && changeStatus()" name="requestForForm">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken='<?php echo csrf_token(); ?>'" class="form-control">
                   
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!requestForForm.status.$dirty && requestForForm.status.$invalid)}">
                            <span class="input-icon icon-right">
                                <select ng-model="status" class="form-control" name="status" required>
                                    <option value="">Select status</option>
                                    <option value="1">Requested</option>
                                    <option value="2">Rejected</option>
                                    <option value="3">Accepted</option>
                                </select>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="requestForForm.status.$error">
                                    <div ng-message="required">Status is required</div>
                                </div>
                                <br/>
                            </span>
                            <br/>
                            <span class="input-icon icon-right">
                                <textarea class="form-control" ng-model="reply" name="reply" placeholder="Reply"></textarea>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer" align="center">
                        <button type="Submit" class="btn btn-sub" ng-click="sbtBtn = true">Submit</button>
                    </div> 
                </form>           
            </div>
        </div>
    </div>
</div>
