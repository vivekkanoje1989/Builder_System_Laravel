<div class="row" ng-controller="highestEducationCtrl" ng-init="manageHighestEducation()">  
 <div>
          <flash-message duration="5000"></flash-message>
 </div>
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Highest Education</span>
                <a href="" data-toggle="modal" data-target="#highesteducModal" ng-click="initialModal(0,'','')" class="btn btn-info">Create New Education</a>&nbsp;&nbsp;&nbsp;
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
                                <a href="javascript:void(0);" ng-click="orderByField = 'education_title'; reverseSort = !reverseSort">Education Title
                                <span ng-show="orderByField == 'education_title'">
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
                        <tr role="row" ng-repeat="list in educationRow| filter:search |orderBy:orderByField:reverseSort" ng-class="{'selected':$index == selectedRow}" ng-click="setClickedRow($index)">
                            <td>{{$index + 1}}</td>
                            <td>{{ list.education_title}}</td>                          
                             <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit highest education" style="display: block;" data-toggle="modal" data-target="#highesteducModal"><a href="javascript:void(0);" ng-click="initialModal({{ list.education_id}},'{{list.education_title}}',{{$index}})"><i class="fa fa-pencil"></i></a></div>
                            </td> 
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="highesteducModal" role="dialog" tabindex="-1">    
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <form novalidate ng-submit="highesteducForm.$valid && doHighestEducationAction()" name="highesteducForm">
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!highesteducForm.blood_group.$dirty && highesteducForm.education_title.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="education_id" name="education_id">
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="education_title" name="education_title" placeholder="Highest Education" ng-change="errorMsg = null" required>
                                <i class="fa fa-user thm-color circular"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="highesteducForm.education_title.$error">
                                    <div ng-message="required">Education title is required</div>
                                    <div ng-if="errorMsg">{{errorMsg}}</div>
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

