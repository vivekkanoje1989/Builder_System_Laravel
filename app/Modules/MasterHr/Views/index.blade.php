<div class="row" ng-controller="DataTableCtrl">
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Simple DataTable</span>
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body">
                <table ui-jq="dataTable" ui-options="simpleTableOptions" class="table table-striped" id="manageUsers">
                    <thead>
                        <tr>
                            <th style="width:5%">SR No.</th>
                            <th style="width: 5%">Employee Id</th>
                            <th style="width: 10%">Employee Name</th>
                            <th style="width: 10%">Designation</th>
                            <th style="width: 10%">Reporting To</th>
                            <th style="width: 10%">Team Lead</th>
                            <th style="width: 10%">Department's</th>
                            <th style="width: 10%">Joining Date</th>
                            <th style="width: 10%">Status of User</th>
                            <th style="width: 10%">Last Login</th>
                            <th style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
