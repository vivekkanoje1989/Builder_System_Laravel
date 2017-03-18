<div class="row" ng-controller="contactUsCtrl" ng-init="manageContactUs()">  
  <div>
          <flash-message duration="5000"></flash-message>
  </div>
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Office Addresses</span>
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
                            <a href="javascript:void(0);" ng-click="orderByField ='address'; reverseSort = !reverseSort">Address.
                              <span ng-show="orderByField == 'address'">
                              <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                            </a></th>
                             <th style="width:35%">
                            <a href="javascript:void(0);" ng-click="orderByField ='telephone'; reverseSort = !reverseSort">Telephone.
                              <span ng-show="orderByField == 'telephone'">
                              <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                            </a></th>
                             <th style="width:35%">
                            <a href="javascript:void(0);" ng-click="orderByField ='email'; reverseSort = !reverseSort">Email.
                              <span ng-show="orderByField == 'email'">
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
                        <tr role="row" ng-repeat="item in contactUsRow| filter:search  | orderBy:orderByField:reverseSort">
                            <td>{{$index+1}}</td>
                            <td>{{item.address}}</td>     
                              <td>{{item.telephone}}</td>     
                                <td>{{item.email}}</td>     
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit contact" style="display: block;" data-toggle="modal" data-target="#contactUsModal"><a href="javascript:void(0);" ng-click="initialModal({{ item.id}},'{{item.address}}','{{item.telephone}}','{{item.email}}',{{$index}})"><i class="fa fa-pencil"></i></a></div>
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
                <form novalidate ng-submit="contactUsForm.$valid && doContactusAction()" name="contactUsForm">
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!contactUsForm.address.$dirty && contactUsForm.address.$invalid) && (!contactUsForm.telephone.$dirty && contactUsForm.telephone.$invalid) && (!contactUsForm.email.$dirty && contactUsForm.email.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="id" name="id">
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="address" name="address" placeholder="Address" ng-change="errorMsg = null" required>
                                <i class="fa fa-user thm-color circular"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.address.$error">
                                    <div ng-message="required">This field is required</div>
                                    <div ng-if="errorMsg">{{errorMsg}}</div>
                                </div>
                                <br/>
                            </span>
                            
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="telephone" name="telephone" placeholder="Telephone"  required>
                                <i class="fa fa-user thm-color circular"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.telephone.$error">
                                    <div ng-message="required">This field is required</div>
                                </div>
                                <br/>
                            </span>
                             
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="email" name="email" placeholder="Email"  required>
                                <i class="fa fa-user thm-color circular"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.email.$error">
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

