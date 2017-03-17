<div class="row" ng-controller="lostReasonsController" ng-init="manageLostReasons()">  
 <div>
          <flash-message duration="5000"></flash-message>
</div>
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Lost Reasons</span>
                <a data-toggle="modal" data-target="#lostReasonModal" ng-click="initialModal(0,'','','')" class="btn btn-info">Create New Lost Reason</a>&nbsp;&nbsp;&nbsp;
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
                             <th style="width: 30%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'reason'; reverseSort = !reverseSort">Reason
                                <span ng-show="orderByField == 'reason'">
                                  <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                </span>
                                </a>
                            </th>                             
                            
                            <th style="width:5%">
                            <a href="javascript:void(0);" ng-click="orderByField ='lost_reason_status'; reverseSort = !reverseSort">Status.
                              <span ng-show="orderByField == 'lost_reason_status'">
                              <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                            </a></th> 
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td><input type="text" ng-model="search" class="form-control"  placeholder="Search"></td>                           
                            <td></td>
                            <td></td>
                        </tr>
                        <tr role="row" ng-repeat="listLostReason in listLostReasons| filter:search | orderBy:orderByField:reverseSort" ng-class="{'selected':$index == selectedRow}" ng-click="setClickedRow($index)">
                            <td>{{ $index + 1}}</td>
                            <td>{{ listLostReason.reason}}</td>                           
                            <td>{{ (listLostReason.lost_reason_status) == 1 ? 'Active' :'In Active' }}</td> 
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit Lost Reason" style="display: block;" data-toggle="modal" data-target="#lostReasonModal"><a href="javascript:void(0);" ng-click="initialModal({{ listLostReason.id}},'{{ listLostReason.reason}}',{{ listLostReason.lost_reason_status}},$index)"><i class="fa fa-pencil"></i></a></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="lostReasonModal" role="dialog" tabindex="-1">   
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <form novalidate ng-submit="lostReasonForm.$valid && doLostReasonsAction()" name="lostReasonForm">
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!lostReasonForm.reason.$dirty && lostReasonForm.reason.$invalid) && (!lostReasonForm.lost_reason_status.$dirty && lostReasonForm.lost_reason_status.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="actionModal" name="actionModal" placeholder="actionModal" >
                               
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="reason" name="reason" placeholder="Reason" ng-change="errorMsg = null" required>
                                <i class="fa fa-user thm-color circular"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="lostReasonForm.reason.$error">
                                    <div ng-message="required">Source is required</div>
                                    <div ng-if="errorMsg">{{errorMsg}}</div>
                                </div>
                            </span><br/><br/>
                            <span class="input-icon icon-right">
                                <select ng-model="lost_reason_status" name="lost_reason_status" class="form-control">
                                    <option value="">Select status</option>
                                     <option value="1">Active</option>
                                      <option value="0">Inactive</option>
                                </select>
                                <i class="fa fa-user thm-color circular"></i>
                                 <div class="help-block" ng-show="sbtBtn" ng-messages="lostReasonForm.lost_reason_status.$error">
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

