
<div class="row" ng-controller="cloudtelephonyController" ng-init="managevLists('','index')">
    
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Virtual Numbers</span>
                
<!--                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose disabled></a>
                </div>-->
            </div>
            <div class="widget-body table-responsive">
                <input type="text" ng-model="search" class="form-control" style="width:25%;" placeholder="Search"><br>
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">SR No.</th>
                            <th style="width: 10%">Virtual Number</th>
                            <th style="width: 10%">Default Number</th>
                            <th style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="listNumber in listNumbers | filter:search | itemsPerPage:itemsPerPage">
                            <td>{{ $index + 1}}</td>
                            <td>{{ listNumber.virtual_number }}</td>
                            <td ng-if="listNumber.default_number == 1">Yes</td>
                            <td ng-if="listNumber.default_number == 0">No</td>
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit" style="display: block;"><a href="#/[[config('global.getUrl')]]/virtualnumber/update/{{ listNumber.id }}"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="DTTTFooter">
                    <div class="col-sm-6">
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to {{ itemsPerPage }} of {{ listNumbersLength }} entries</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                            <dir-pagination-controls class="pagination" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


