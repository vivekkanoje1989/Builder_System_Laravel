<div class="row" ng-controller="blogsCtrl" ng-init="manageBlogs()">  
  <div>
          <flash-message duration="5000"></flash-message>
  </div>
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Blog Management</span>
                <a title="Create blog" class="btn btn-primary" href="#/[[config('global.getUrl')]]/website_settings/create" >Create blogs</a>
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
                            <tr>
                            <th style="width:5%">
                            <a href="javascript:void(0);" ng-click="orderByField ='id'; reverseSort = !reverseSort">SR No.
                              <span ng-show="orderByField == 'id'">
                              <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                            </a></th>                       
                            <th style="width:90%">
                            <a href="javascript:void(0);" ng-click="orderByField ='name'; reverseSort = !reverseSort">Name.
                              <span ng-show="orderByField == 'name'">
                              <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                            </a></th>
                                          
                            <th style="width: 5%">Actions</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td> <input type="text" ng-model="search" class="form-control" style="width:100%;" placeholder="Search"></td>
                            
                            <td></td>
                        </tr>
                        <tr role="row" ng-repeat="item in blogsRow| filter:search  | orderBy:orderByField:reverseSort">
                            <td>{{$index+1}}</td>
                            <td>{{item.blog_title}}</td>  
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit contact" style="display: block;" data-toggle="modal"><a href="#/[[config('global.getUrl')]]/website_settings/update/{{ item.blog_id }}"><i class="fa fa-pencil"></i></a></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

