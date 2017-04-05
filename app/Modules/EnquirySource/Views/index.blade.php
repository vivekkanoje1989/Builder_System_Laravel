<div class="row" ng-controller="enquirysourceCtrl" ng-init="manageEnquirySource()">  
  <div>
          <flash-message duration="5000"></flash-message>
  </div>
    <div class="col-xs-12 col-md-12">
                <div class="widget">
                    <div class="widget-header bordered-bottom bordered-blue">
                        <span class="widget-caption">Source Name</span>
                        <a href="" data-toggle="modal" data-target="#sourceModal" ng-click="sourceinitialModal()" class="btn btn-info">Create Source</a>&nbsp;&nbsp;&nbsp;
                        <div class="widget-buttons">
                            <a href="" widget-maximize></a>
                            <a href="" widget-collapse></a>
                            <a href="" widget-dispose></a>
                        </div>
                    </div>
                    <div class="widget-body no-padding">
                 
                            <accordion>
                                <accordion-group heading="{{list.source_name}}" ng-repeat="list in EnquirySourceRow" ng-click="getSubSource({{list.id}})">
                                    {{group.content}}
                            <p style="text-align:right;"><a href="" data-toggle="modal" data-target="#subsourceModal" ng-click="initialModal(0,{{list.id}},'','')" class="btn btn-info">Create Sub Source</a></p>
                                    <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <tr>
                            <th style="width:5%">
                            <a href="javascript:void(0);" ng-click="orderByField ='id'; reverseSort = !reverseSort">SR No.
                              <span ng-show="orderByField == 'id'">
                              <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                            </a></th>                       
                            <th style="width: 30%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'sub_source'; reverseSort = !reverseSort">Sub source
                                    <span ng-show="orderByField == 'sub_source'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>                            
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td><input type="text" ng-model="search" class="form-control"  placeholder="Search"></td>                           
                            <td></td>
                        </tr>
                        <tr role="row" ng-repeat="sublist in SubEnquirySourceRow| filter:search | orderBy:orderByField:reverseSort" ng-class="{'selected':$index == selectedRow}" ng-click="setClickedRow($index)">
                            <td>{{$index + 1}}</td>
                            <td>{{ sublist.sub_source}}</td>                          
                            <td class="fa-div">
                        <div class="fa-hover" tooltip-html-unsafe="Edit User" style="display: block;" data-toggle="modal" data-target="#subsourceModal"><a href="javascript:void(0);" ng-click="initialModal({{sublist.id}},{{list.id}},'{{sublist.sub_source}}',$index)"><i class="fa fa-pencil"></i></a></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
             </accordion-group>
            </accordion>
        </div>
    </div>
</div>
            
    <div class="modal fade" id="subsourceModal" role="dialog" tabindex="-1">   
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <form novalidate ng-submit="subsourceForm.$valid && dosubsourceAction()" name="subsourceForm">
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!subsourceForm.sub_source.$dirty && subsourceForm.sub_source.$invalid) && (!subsourceForm.sub_source_status.$dirty && subsourceForm.sub_source_status.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="subid" name="subid">
                            <input type="hidden" class="form-control" ng-model="source_id" name="source_id">
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="sub_source" name="sub_source" placeholder="Sub source" ng-change="errorMsg = null" required>
                                <i class="fa fa-user thm-color circular"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="subsourceForm.sub_source.$error">
                                    <div ng-message="required">Sub source is required</div>
                                    <div ng-if="errorMsg">{{errorMsg}}</div>
                                </div>
                            </span>
                            <br/><br/>
                            <span class="input-icon icon-right">
                                <select ng-model="sub_source_status" name="sub_source_status" class="form-control">
                                    <option value="">Select source status</option>
                                     <option value="1">Active</option>
                                      <option value="0">Inactive</option>
                                </select>
                                <i class="fa fa-user thm-color circular"></i>
                                 <div class="help-block" ng-show="sbtBtn" ng-messages="subsourceForm.sub_source_status.$error">
                                    <div ng-message="required">Source status is required</div>
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


    <div class="modal fade" id="sourceModal" role="dialog" tabindex="-1">   
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <form novalidate ng-submit="sourceForm.$valid && dosourceAction()" name="sourceForm">
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!sourceForm.source_name.$dirty && sourceForm.source_name.$invalid) && (!sourceForm.source_status.$dirty && sourceForm.source_status.$invalid)}">
                           
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="source_name" name="source_name" placeholder="Source name" ng-change="errorMsg = null" required>
                                <i class="fa fa-user thm-color circular"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="sourceForm.source_name.$error">
                                    <div ng-message="required">Source is required</div>
                                    <div ng-if="errorMsg">{{errorMsg}}</div>
                                </div>
                            </span><br/><br/>
                            <span class="input-icon icon-right">
                                <select ng-model="source_status" name="source_status" class="form-control">
                                    <option value="">Select source status</option>
                                     <option value="1">Active</option>
                                      <option value="0">Inactive</option>
                                </select>
                                <i class="fa fa-user thm-color circular"></i>
                                 <div class="help-block" ng-show="sbtBtn" ng-messages="sourceForm.source_status.$error">
                                    <div ng-message="required">Source status is required</div>
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

