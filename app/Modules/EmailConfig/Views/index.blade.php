<div class="row" ng-controller="emailconfigCtrl" ng-init="manageEmailConfig('index')">
    <div class="col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Configure Email Accounts</span>                
            </div>
            <div class="widget-body table-responsive"><br/>  
                <div class="row table-toolbar">
                    <!--                    <a href="[[ config('global.backendUrl') ]]#/customalerts/create " class="btn btn-default">Create New Template</a>&nbsp;&nbsp;&nbsp;-->

                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
<!--                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Excel" ng-click="configEmailExportToxls()" ng-show="exportData == '1'" >
                            <span>Export</span>
                        </a>-->
                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2">
                            <span>Actions</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a href="" ng-click="configEmailExportToxls()" ng-show="exportData == '1'" >Export</a>
                                </li>
                            </ul>
                        </a>
                    </div>

                    <div  class="dataTables_filter">
                        <label>
                            <input type="search" class="form-control input-sm" ng-model="search" name="search" >
                        </label>
                    </div>

                    <div class="dataTables_length" >
                        <label>
                            <select class="form-control" ng-model="itemsPerPage" name="itemsPerPage" onchange="if (/\D/g.test(this.value))this.value = this.value.replace(/\D/g, '')">
                               <option value="30">30</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                                <option value="300">300</option>
                                <option value="400">400</option>
                                <option value="500">500</option>
                                <option value="600">600</option>
                                <option value="700">700</option>
                                <option value="800">800</option>
                                <option value="900">900</option>
                                <option value="999">999</option>
                            </select>
                        </label>
                    </div>
                    <table class="table table-hover table-striped table-bordered tableHeader" at-config="config">
                        <thead class="bord-bot">
                            <tr>
                                <th style="width: 5%;">Sr. No.</th>
                                <th style="width: 10%;">
                                     <a href="javascript:void(0);" ng-click="orderByField('email')">Email Id
                                        <span ><img ng-hide="(sortKey == 'email' &&(reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'email' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'email' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%;">Password
                                </th>
                                <th style="width: 10%;">Service Provider
                                </th>                            
                                <th style="width: 10%;">
                                    <a href="javascript:void(0);" ng-click="orderByField('deptName')">Departments
                                        <span ><img ng-hide="(sortKey == 'deptName' &&(reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'deptName' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'deptName' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 5%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" dir-paginate="listmail in listmails | filter:search | filter:searchData| itemsPerPage:itemsPerPage | orderBy:sortKey:reverseSort">
                                <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                                <td>{{listmail.email}}</td>
                                <td><input type="password" value="{{listmail.password}}" style="border:none;background: transparent;" disabled></td>
                                <td>Gmail</td>          
                                <td>{{ listmail.deptName}}</td>
                                <td class="">
                                    <span class="" tooltip-html-unsafe="Edit Account"><a href="[[ config('global.backendUrl') ]]#/emailConfig/update/{{ listmail.id}}" class=" btn-info btn-xs"><i class="fa fa-edit"></i>Edit</a></span>
                                    <span  ng-show="deleteBtn == '1'" class="" tooltip-html-unsafe="Delete"><a href="" ng-click="confirm({{listmail.id}},{{$index}})" class="btn-danger btn-xs"><i class="fa fa-trash-o"></i>Delete</a></span>
                                </td>
                            </tr>
                             <tr>
                                <td colspan="6"  ng-show="(listmails|filter:search | filter:searchData ).length == 0" align="center">Record Not Found</td>   
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
</div>