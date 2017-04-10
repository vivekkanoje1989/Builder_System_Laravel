<div class="row" ng-controller="blocktypesController" ng-init="manageBlockTypes(); getProjectNames()">  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Block Types</span>
                <a data-toggle="modal" data-target="#blocktypesModal" ng-click="initialModal(0,'','','','')" class="btn btn-info">Create Block Types</a>&nbsp;&nbsp;&nbsp;
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
                            <a href="javascript:void(0);" ng-click="orderByField ='block_name'; reverseSort = !reverseSort">Block type
                              <span ng-show="orderByField == 'block_name'">
                              <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                            </a></th> 
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td ><input type="text" ng-model="search" class="form-control"  placeholder="Search"></td>                           
                            
                            <td></td>
                        </tr>
                        <tr role="row" ng-repeat="list in BlockTypesRow| filter:search | orderBy:orderByField:reverseSort" >
                            <td>{{ $index + 1}}</td>                          
                            <td>{{ list.block_name }}</td> 
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit block type" style="display: block;" data-toggle="modal" data-target="#blocktypesModal"><a href="javascript:void(0);" ng-click="initialModal({{ list.id}},'{{ list.block_name}}',{{ list.project_id}},$index)"><i class="fa fa-pencil"></i></a></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
   
<div class="modal fade" id="blocktypesModal" role="dialog" tabindex="-1">    
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <form novalidate ng-submit="blocktypesForm.$valid && doblocktypesAction()" name="blocktypesForm">
                     <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken='<?php echo csrf_token(); ?>'" class="form-control">
                   
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!blocktypesForm.project_type_id.$dirty && blocktypesForm.project_type_id.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="id" name="id">
                            <label>Project type<span class="sp-err">*</span></label>
                             <span class="input-icon icon-right">
                                <select class="form-control" ng-model="project_type_id" name="project_type_id" required>
                                    <option value="">Select project type</option>
                                    <option  ng-repeat="list in getProjectNamesRow" value="{{list.id}}" selected>{{list.project_type}}</option>
                                </select>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="blocktypesForm.project_type_id.$error">
                                    <div ng-message="required">Project type is required</div>
                                </div>
                            </span>
                            <br/><br/>
                     <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!blocktypesForm.block_name.$dirty && blocktypesForm.block_name.$invalid)}">
                           <label>Block name<span class="sp-err">*</span></label>      
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="block_name" name="block_name"  ng-change="errorMsg = null" required>
                            
                                <div class="help-block" ng-show="sbtBtn" ng-messages="blocktypesForm.block_name.$error">
                                    <div ng-message="required">Block type is required</div>
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

