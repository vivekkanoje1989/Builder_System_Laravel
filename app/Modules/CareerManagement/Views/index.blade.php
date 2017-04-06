<div class="row" ng-controller="careerCtrl" ng-init="manageCareers()">  
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
                                <a href="javascript:void(0);" ng-click="orderByField = 'job_title'; reverseSort = !reverseSort">Job title
                                    <span ng-show="orderByField == 'job_title'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>
                            <th style="width:25%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'job_eligibility'; reverseSort = !reverseSort">Eligibility
                                    <span ng-show="orderByField == 'job_eligibility'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>
                            <th style="width:20%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'application_start_date'; reverseSort = !reverseSort">Application start date
                                    <span ng-show="orderByField == 'application_start_date'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>
                            <th style="width:20%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'application_close_date'; reverseSort = !reverseSort">Application close date
                                    <span ng-show="orderByField == 'application_close_date'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th> 
                            <th style="width:15%">
                                <a href="javascript:void(0);"reverseSort = !reverseSort">Go to
                                </a></th>                            
                            <th style="width: 5%">Edit</th>
                            <th style="width: 5%">Delete</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr role="row" dir-paginate="list in careerRow| filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort" >
                            <td>{{$index + 1}}</td>
                            <td>{{list.job_title}}</td> 
                            <td>{{list.job_eligibility}}</td> 
                            <td>{{list.application_start_date}}</td> 
                            <td>{{list.application_close_date}}</td>
                            <td><a href="#/[[config('global.getUrl')]]/manage-job/show/{{ list.id}}" class="btn btn-primary">View Application</a></td>
                            <td class="fa-div">	
                                <div class="fa-hover" tooltip-html-unsafe="Edit" style="display: block;" ><a href="#/[[config('global.getUrl')]]/manage-job/update/{{ list.id}}"><i class="fa fa-pencil"></i></a></div>
                            </td>
                            <td class="fa-div">	
                                <div class="fa-hover" tooltip-html-unsafe="Delete" style="display: block;"><a ng-click="deleteJob({{list.id}},{{$index}})"><i class="fa fa-trash-o"></i></a></div>
                            </td>
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
