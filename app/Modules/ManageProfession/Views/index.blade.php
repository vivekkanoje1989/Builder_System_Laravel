<div class="row" ng-controller="manageProfessionCtrl" ng-init="manageProfession()">  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Profession</span>
                <a href="" data-toggle="modal" data-target="#professionModal" ng-click="initialModal(0,'','')" class="btn btn-info">Create New Profession</a>&nbsp;&nbsp;&nbsp;
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
                            <th style="width: 70%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'profession'; reverseSort = !reverseSort">Profession Name
                                <span ng-show="orderByField == 'profession'">
                                  <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                </span>
                                </a>
                            </th> 
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'status'; reverseSort = !reverseSort">Status
                                <span ng-show="orderByField == 'status'">
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
                        <tr role="row" ng-repeat="list in professionRow| filter:search |orderBy:orderByField:reverseSort" ng-class="{'selected':$index == selectedRow}" ng-click="setClickedRow($index)">
                            <td>{{$index + 1}}</td>
                            <td>{{ list.profession}}</td> 
                            <td>{{ list.status == 1 ? "Active" : "Inactive" }}</td> 
                             <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit profession" style="display: block;" data-toggle="modal" data-target="#professionModal"><a href="javascript:void(0);" ng-click="initialModal({{ list.id}},'{{list.profession}}','{{list.status}}',$index)"><i class="fa fa-pencil"></i></a></div>
                            </td> 
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="professionModal" role="dialog" tabindex="-1">   
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <form novalidate ng-submit="professionForm.$valid && doprofessionAction()" name="professionForm">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken='<?php echo csrf_token(); ?>'" class="form-control">
                   
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!professionForm.profession_name.$dirty && professionForm.profession_name.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="id" name="id">
                            <label>Profession name<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="profession" name="profession_name"  ng-change="errorMsg = null" required>
                                
                                <div class="help-block" ng-show="sbtBtn" ng-messages="professionForm.profession_name.$error">
                                    <div ng-message="required">Profession is required</div>
                                    <div ng-if="errorMsg">{{errorMsg}}</div>
                                </div>
                            </span>
                        </div>
                         <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!professionForm.status.$dirty && professionForm.status.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="id" name="id">
                            <label>Status<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select name="status" ng-model="status" class="form-control" required>
                                    <option value="">Select status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="professionForm.status.$error">
                                    <div ng-message="required">Status is required</div>
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

