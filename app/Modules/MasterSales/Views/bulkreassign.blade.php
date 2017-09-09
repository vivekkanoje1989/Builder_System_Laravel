<div class="modal-body">
    <form novalidate style="margin-left: 5%;" role="form" name="bulkForm" ng-submit="bulkForm.$valid && bulkreasignemployee(bulkData.employee_id)">               
        <div class="row" >
            <div class="col-sm-6 col-sx-12">
                <div class="form-group" >
                    <label for="">Select Employee <span class="sp-err">*</span></label>   
                    <span class="input-icon icon-right">
                        <select class="form-control"  ng-model="bulkData.employee_id" name="employee_id" id="employee_id" ng-controller="salesemployeesCtrl" required>
                            <option value="">Select Employee</option>
                            <option ng-repeat="item in salesemployeeList" value="{{item.id}}" ng-if="item.id != [[Auth::guard('admin')->user()->id]]" >{{item.first_name}} {{item.last_name}} ({{item.designation_name.designation}})</option>
                        </select>
                        <i class="fa fa-sort-desc" ng-click="dropevent(this.event)"></i>
                        <div ng-show="sbtBtn" ng-messages="bulkForm.employee_id.$error" class="help-block errMsg">
                            <div style="sp-err" ng-message="required">Please Select Employee</div>
                        </div>
                    </span>
                </div>                        
            </div>
            <div class="col-sm-3" style="margin-top:22px;">
                <button  type="submit" ng-click="sbtBtn = true" class="btn btn-primary">Reassign To</button>                    
            </div>
        </div>
    </form>
</div>