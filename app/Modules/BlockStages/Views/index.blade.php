<div class="row" ng-controller="blockstagesCtrl" ng-init="blockStages(); getProjectTypes();">  
<div>
          <flash-message duration="5000"></flash-message>
</div>
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Block stages</span>
                <a href="" data-toggle="modal" data-target="#blockstagesModal" ng-click="initialModal(0,'','')" class="btn btn-info">Create New Block stages</a>&nbsp;&nbsp;&nbsp;
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
                            <th style="width:5%">
                            <a href="javascript:void(0);" ng-click="orderByField ='id'; reverseSort = !reverseSort">SR No.
                              <span ng-show="orderByField == 'id'">
                              <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                            </a></th>                          
                            <th style="width: 30%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'block_stages'; reverseSort = !reverseSort">Block Stage
                                <span ng-show="orderByField == 'block_stage_name'">
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
                        <tr role="row" ng-repeat="list in BlockStageRow| filter:search |orderBy:orderByField:reverseSort" ng-class="{'selected':$index == selectedRow}" ng-click="setClickedRow($index)">
                            <td>{{$index + 1}}</td>
                            <td>{{ list.block_stage_name }}</td>                          
                             <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit" style="display: block;" data-toggle="modal" data-target="#blockstagesModal"><a href="javascript:void(0);" ng-click="initialModal({{ list.id}},'{{list.block_stage_name}}',{{list.project_type_id}},$index)"><i class="fa fa-pencil"></i></a></div>
                            </td> 
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="blockstagesModal" role="dialog" tabindex="-1">   
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <form novalidate ng-submit="blockStagesForm.$valid && doblockstagesAction()" name="blockStagesForm">
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!blockStagesForm.block_stages.$dirty && blockStagesForm.block_stages.$invalid) && (!blockStagesForm.project_type_id.$dirty && blockStagesForm.project_type_id.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="id" name="id">
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="project_type_id" name="project_type_id" >
                                    <option value="">Select project type</option>
                                    <option  ng-repeat="item in ProjectTypesRow" value="{{item.id}}">{{item.project_type}}</option>
                                </select>
                                <i class="fa fa-user thm-color circular"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="blockStagesForm.project_type_id.$error">
                                    <div ng-message="required">Project type is required</div>
                                </div>
                            </span>
                            <br/><br/>
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="block_stages" name="block_stages" placeholder="Block Stages" ng-change="errorMsg = null" required>
                                <i class="fa fa-user thm-color circular"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="blockStagesForm.block_stages.$error">
                                    <div ng-message="required">Block stage is required</div>
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

