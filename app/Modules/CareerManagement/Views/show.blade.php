<div class="row" ng-controller="careerCtrl" ng-init = "viewApplicants(<?php echo $career_id; ?>);">  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Career</span>
                <a href="#/[[config('global.getUrl')]]/createJob/index"  class="btn btn-info">Click Here To Post New Job</a>&nbsp;&nbsp;&nbsp;
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
                                <a href="javascript:void(0);" ng-click="orderByField = 'first_name'; reverseSort = !reverseSort">First name
                                    <span ng-show="orderByField == 'first_name'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>
                            <th style="width:25%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'eligibility'; reverseSort = !reverseSort">Last name
                                    <span ng-show="orderByField == 'eligibility'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>
                            <th style="width:20%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'mobile_number'; reverseSort = !reverseSort">Mobile number
                                    <span ng-show="orderByField == 'mobile_number'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>
                            <th style="width:20%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'email_id'; reverseSort = !reverseSort">Email
                                    <span ng-show="orderByField == 'email_id'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>                           
                            <th style="width: 10%">Download Resume</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr role="row" dir-paginate="list in viewApplicantsRow| filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort" >
                            <td>{{$index + 1}}</td>
                            <td>{{list.first_name}}</td> 
                            <td>{{list.last_name}}</td> 
                            <td>{{list.mobile_number}}</td> 
                            <td>{{list.email_id}}</td> 
                            <td>
                                <a href="/download/{{list.resume_file_name}}" class="btn btn-primary">Download</a></td>

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
</div>
