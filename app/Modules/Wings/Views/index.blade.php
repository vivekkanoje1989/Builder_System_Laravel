
<div class="row" ng-controller="wingsController"  ng-init="manageWings([[ $id ]])">
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Wings</span>
                <a href="#/[[config('global.getUrl')]]/wings/create" class="btn btn-info">Create Wings</a>&nbsp;&nbsp;&nbsp;
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
                            <th style="width:5%">SR No.</th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField='project_name.project_name'; reverseSort = !reverseSort">Project 
                                    <span ng-show="orderByField == 'project_name.project_name'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField='wing_name'; reverseSort = !reverseSort">Name 
                                    <span ng-show="orderByField == 'wing_name'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th> 
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField='company_name.legal_name'; reverseSort = !reverseSort">Company 
                                    <span ng-show="orderByField == 'company_name.legal_name'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            
                            <th style="width: 20%">Stationary</th>
                            <th style="width: 5%">Floors</th>
                            <th style="width: 5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="listWing in listWings | filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
                            <td>{{ itemsPerPage * (noOfRows-1)+$index+1 }}</td>
                            <td>{{ listWing.project_name.project_name }}</td>
                            <td>{{ listWing.wing_name }}</td>                            
                            <td>{{ listWing.company_name.legal_name }}</td>
                            <td>{{ listWing.stationary_name.stationary_set_name }}</td>
                            <td>{{ listWing.number_of_floors }}</td>                            
                            <td class="fa-div">                                
                                <div class="fa-hover" tooltip-html-unsafe="Edit Wings" style="display: block;"><a href="#/[[config('global.getUrl')]]/wings/update/{{ listWing.id }}"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;</div>                                
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="DTTTFooter">
                    <div class="col-sm-6">
                        <!--<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing {{itemsPerPage * (noOfRows-1)+1}} to of {{ listUsersLength }} entries</div>-->
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

