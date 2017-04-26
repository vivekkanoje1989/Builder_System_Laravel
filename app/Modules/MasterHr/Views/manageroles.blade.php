<div class="row" ng-controller="hrController" ng-init="manageRoles()">
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Users</span>
               
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body table-responsive">
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">Sr No.</th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);">Role</a>
                            </th>
                            <th style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" ng-repeat="list in roleList">
                            <td>{{$index+1}}</td>
                            <td>{{list.role_name}}</td>
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="User Permissions" tooltip-placement="top" style="display: block;"><a href="#/[[config('global.getUrl')]]/role/permissions/{{ list.id }}"><i class="fa fa-user-plus"></i></a> &nbsp;&nbsp;</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

