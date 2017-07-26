<div class="row" ng-controller="emailconfigCtrl" ng-init="manageEmailConfig('index')">
    <div class="col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Configure Email Accounts</span>                
            </div>
            <div class="widget-body table-responsive"><br/>             
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width: 5%;">Sr. No.</th>
                            <th style="width: 10%;">Email Id</th>
                            <th style="width: 10%;">Password</th>
                            <th style="width: 10%;">Service Provider </th>                            
                            <th style="width: 10%;">Departments</th>
                            <th style="width: 5%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="listmail in listmails | filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
                            <td>{{itemsPerPage * (noOfRows-1)+$index+1}}</td>
                            <td>{{listmail.email }}</td>
                            <td><input type="password" value="{{listmail.password }}" style="border:none;background: transparent;" disabled></td>
                            <td>Gmail</td>          
                            <td>{{ listmail.deptName }}</td>
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit Account"><a href="[[ config('global.backendUrl') ]]#/emailConfig/update/{{ listmail.id }}"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;</div>
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