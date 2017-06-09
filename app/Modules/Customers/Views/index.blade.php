<div class="row" ng-controller="customerCtrl" ng-init="manageCustomer()">  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Customer Data</span>
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body table-responsive">     
                <div class="row">
                    <div class="col-sm-3 col-xs-12">
                        <label for="search">Search:</label>
                        <input type="text" ng-model="search" class="form-control" placeholder="Search">
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <label for="search">Records per page:</label>
                        <input type="number" min="1" max="50" style="width:30%;" class="form-control" ng-model="itemsPerPage">
                    </div>
                </div><br>           
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">Sr. No.</th>    
                            <th style="width:5%">Title</th>
                            <th style="width:20%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'first_name'; reverseSort = !reverseSort">Customer Name
                                    <span ng-show="orderByField == 'first_name'">
                                    <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a>
                            </th>
                            <th style="width:20%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'profession_name'; reverseSort = !reverseSort">Profession
                                    <span ng-show="orderByField == 'profession_name'">
                                    <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a>
                            </th>  
                            <th style="width:20%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'source_name'; reverseSort = !reverseSort">Source
                                    <span ng-show="orderByField == 'source_name'">
                                    <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a>
                            </th> 
                            <th style="width:10%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'email_privacy_status'; reverseSort = !reverseSort">Email Status
                                    <span ng-show="orderByField == 'email_privacy_status'">
                                    <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a>
                            </th> 
                            <th style="width:10%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'sms_privacy_status'; reverseSort = !reverseSort">SMS Status
                                    <span ng-show="orderByField == 'sms_privacy_status'">
                                    <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a>
                            </th> 
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="list in customerDataRow| filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
                            <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                            <td>{{list.get_title.title}}</td>
                            <td>{{list.first_name + " " + list.last_name}}</td>     
                            <td>{{list.get_profession.profession}}</td>     
                            <td>{{list.get_source.sales_source_name}}</td>     
                            <td>{{(list.email_privacy_status == 1) ? "Yes" : "No"}}</td>     
                            <td>{{(list.sms_privacy_status == 1) ? "Yes" : "No"}}</td>     
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit" style="display: block;"><a href="[[ config('global.backendUrl') ]]#/customers/update/{{ list.id}}"><i class="fa fa-pencil"></i></a></div>
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

