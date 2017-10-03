<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div ng-if="notFound">No wings found</div>
        <tabset justified="true" ng-show="wingList">
            <tab ng-repeat="wlist in wingList" heading="{{wlist.wing_name}}" ng-click="getInventoryDetails(projectData.prid,{{wlist.id}},'', '')" class="themeprimary">
                <br/>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <table class="table table-hover table-striped table-bordered table-responsive tableHeader" at-config="config">
                            <thead class="bord-bot">
                                <tr>
                                    <th style="width:5%">Sr. No.</th> 
                                    <th style="width:5%">Wing</th> 
                                    <th style="width:10%">Block</th> 
                                    <th style="width:20%">Sub Type</th> 
                                    <th style="width:25%">Description</th> 
                                    <th style="width:5%">Qty</th> 
                                    <th style="width:10%">Availability</th> 
                                    <th style="width:10%">Show On Website</th> 
                                    <th style="width:5%">Action</th> 
                                </tr>
                                <tr ng-if="inventoryList" ng-repeat="idata in inventoryList | unique: 'block_type_id'">
                                    <td>{{$index+1}}</td>
                                    <td>{{wlist.wing_name}}</td>
                                    <td>{{idata.block_type_id}}</td>
                                    <td>{{idata.block_sub_type}}</td>
                                    <td>{{idata.block_description}}</td>
                                    <td>{{idata.block_quantity}}</td>
                                    <td>{{idata.block_availablity == 1 ? "Yes" : "No"}}</td>
                                    <td>{{idata.show_on_website == 1 ? "Yes" : "No"}}</td>
                                    <td>
                                        <button type="button" ng-click="getWingData({{inventoryList}}, '{{idata.id}}','{{wlist.id}}','{{wlist.wing_name}}')" data-toggle="modal" data-target="#inventoryDataModal" class="btn btn-primary btn-xs">
                                            <i class="fa fa-pencil"></i>Edit
                                        </button>
                                    </td>
                                </tr>
                                <tr ng-if="inventoryList==''">
                                    <td colspan="9" align="center"><strong>Records not found</strong></td>
                                </tr>
                            </thead>
                        </table>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="form-group" align="right">
                                    <label for=""></label>
                                    <span class="input-icon icon-right">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#inventoryDataModal" ng-click="getWingData()">Add</button>
                                        <button type="button" class="btn btn-primary" ng-click="cancel_inventory()">Cancel</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </tab>
        </tabset>
    </div>
</div>


<!--Project Inventory Modal-->
<div class="modal fade modal-primary" id="inventoryDataModal" role="dialog" tabindex='-1' data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header navbar-inner">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center">{{modalHeading}}</h4>
            </div>
            <div data-ng-include="'/projects/inventoryForm'"></div>
        </div>
    </div>
</div>




