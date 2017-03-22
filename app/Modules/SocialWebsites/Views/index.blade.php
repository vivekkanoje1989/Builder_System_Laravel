<div class="row" ng-controller="socialwebsitesCtrl" ng-init="manageSocialWebsite()">  
  <div>
          <flash-message duration="5000"></flash-message>
  </div>
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Social Websites Management</span>
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
                            <th style="width:35%">
                            <a href="javascript:void(0);" ng-click="orderByField ='name'; reverseSort = !reverseSort">Name.
                              <span ng-show="orderByField == 'name'">
                              <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                            </a></th>
                             <th style="width:35%">
                            <a href="javascript:void(0);" ng-click="orderByField ='link'; reverseSort = !reverseSort">Link.
                              <span ng-show="orderByField == 'link'">
                              <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                            </a></th>
                             <th style="width:35%">
                            <a href="javascript:void(0);" ng-click="orderByField ='status'; reverseSort = !reverseSort">Status.
                              <span ng-show="orderByField == 'status'">
                              <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                            </a></th>
                                                       
                            <th style="width: 5%">Actions</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td colspan="3"> <input type="text" ng-model="search" class="form-control" style="width:100%;" placeholder="Search"></td>
                            
                            <td></td>
                        </tr>
                        <tr role="row" ng-repeat="item in socialwebsiteRow| filter:search  | orderBy:orderByField:reverseSort">
                            <td>{{$index+1}}</td>
                            <td>{{item.name}}</td>     
                              <td>{{item.link}}</td>     
                                <td>{{item.status}}</td>     
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit contact" style="display: block;" data-toggle="modal" data-target="#contactUsModal"><a href="javascript:void(0);" ng-click="initialModal({{ item.id}},'{{item.name}}','{{item.link}}','{{item.status}}',{{$index}})"><i class="fa fa-pencil"></i></a></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="contactUsModal" role="dialog" tabindex="-1">    
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <form novalidate ng-submit="socialwebsiteForm.$valid && dosocialwebsiteAction()" name="socialwebsiteForm">
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!socialwebsiteForm.name.$dirty && socialwebsiteForm.name.$invalid) && (!socialwebsiteForm.link.$dirty && socialwebsiteForm.link.$invalid) && (!socialwebsiteForm.status.$dirty && socialwebsiteForm.status.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="id" name="id">
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="name" name="name" placeholder="Name" ng-change="errorMsg = null" required>
                                <i class="fa fa-user thm-color circular"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="socialwebsiteForm.name.$error">
                                    <div ng-message="required">This field is required</div>
                                    <div ng-if="errorMsg">{{errorMsg}}</div>
                                </div>
                                <br/>
                            </span>
                            
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="link" name="link" placeholder="Link"  required>
                                <i class="fa fa-user thm-color circular"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="socialwebsiteForm.link.$error">
                                    <div ng-message="required">This field is required</div>
                                </div>
                                <br/>
                            </span>
                             
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="status" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <i class="fa fa-user thm-color circular"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="socialwebsiteForm.status.$error">
                                    <div ng-message="required">This field is required</div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer" align="center">
                        <button type="Submit" class="btn btn-sub" ng-click="sbtBtn = true">Submit</button>
                    </div> 
                </form>           
            </div>
        </div>
    </div>
</div>

