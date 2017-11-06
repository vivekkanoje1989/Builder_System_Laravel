<div class="row" ng-controller="apiController" >
    <div class="col-xs-12 col-md-12" ng-init="manageApis('', 'index')">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Push API</span>
                
            </div>
            <div class="widget-body table-responsive">
             
                 <div class="row table-toolbar">
                    <a href="[[ config('global.backendUrl') ]]#/pushapi/create" class="btn btn-default">Add New Api</a>
                     <div class="btn-group pull-right filterBtn">
                        <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2">
                            <span>Actions</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a href="" ng-click="ApiExportToxls()" ng-show="exportData == '1'">Export</a>
                                </li>

                            </ul>
                        </a>
                    </div>
                    <div  class="dataTables_filter">
                        <label>
                            <input type="search" class="form-control input-sm" ng-model="search" name="search" >
                        </label>
                    </div>
                    <!-- filter data--> 
                    <div class="row" style="border:2px;" id="filter-show">
                        <div class="col-sm-12 col-xs-12">
                            <b ng-repeat="(key, value) in searchData">
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'punch_line'" data-toggle="tooltip" title="Punch Line"><strong> Punch Line : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'legal_name'" data-toggle="tooltip" title="Legal Name"><strong> Legal Name : </strong> {{ value}}</strong>
                                    </div>
                                </div>
                            </b>                        
                        </div>
                    </div>
                    <!-- filter data-->
                    <div class="dataTables_length" >
                        <label>
                            <select class="form-control" ng-model="itemsPerPage" name="itemsPerPage" onchange="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
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
                </div>
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">Sr. No.</th>
                            <th style="width: 10%">
                               API Name 
                            </th>
                            <th style="width: 10%">
                                Key 
                            </th>
                            <th style="width: 10%">
                                Created By 
                            </th>
                            <th style="width: 10%">
                                  Document
                            </th>
                            <th style="width: 10%">
                               Status
                            </th>
                            <th style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="list in listApis| filter:search |filter:searchData | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
                            <td>{{ itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                            <td>{{ list.api_name}}</td>
                            <td>{{ list.key}}</td>
                            <td>{{ list.first_name +' '+list.last_name }}</td>
                            <td><p ng-if="list.pdf_name"> <a target="_blank" href="<?php echo config('global.s3Path')."/Push-Apis/"; ?>{{ list.pdf_name}}">Download</a></p></td>
                            <td ng-if="list.status == 1">Active</td>
                            <td ng-if="list.status == 2">Deactive</td>
                            <td class="fa-div">
                                
                                <div class="fa-hover" tooltip-html-unsafe="Edit API" style="display: block;"><a href="[[ config('global.backendUrl') ]]#/pushapi/edit/{{ list.id}}"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;</div>
                                
                            </td>

                        </tr>
                        <tr>
                            <td colspan="10"  ng-show="(listUsers|filter:search).length == 0" align="center">Record Not Found</td>   
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
