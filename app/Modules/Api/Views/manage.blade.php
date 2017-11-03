<div class="row" ng-controller="apiController" >
    <div class="col-xs-12 col-md-12" ng-init="manageApis('', 'index')">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Push API</span>
                
            </div>
            <div class="widget-body table-responsive">
             
                <div class="row">
                 <div class="col-sm-6 col-xs-12">
                      <div class="col-sm-2">    
                            <input type="text" minlength="1" maxlength="3" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  class="form-control" ng-model="itemsPerPage">
                      </div>
                      <div class="col-sm-3"> 
                          <span class="input-icon icon-right">
                            <input type="text" ng-model="search" class="form-control"   oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" >
                            <i class="fa fa-search" aria-hidden="true"></i></span>
                      </div>
                  </div>
                </div><br>
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">SR No.</th>
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
                        <tr role="row" dir-paginate="list in listApis| filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
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
