<div class="row" ng-controller="autoassignEnquiriesCtrl" ng-init="manageEnquiries()">  
  <div>
          <flash-message duration="5000"></flash-message>
  </div>
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Auto Assign Web Enquiries</span>
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
                            <td colspan="2">Auto Assign Web Enquiries</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td>
                                <select id="employee_id" class="form-control" ng-model="employee_id">
                                    <option value="">Select Employee</option> 
        	                <option ng-repeat = "item in EnquirieRow" value="{{item.id}}">{{item.first_name}}</option>
                                 </select>
                            </td>
                        </tr>
                        <tr><td>
                            
                            </td>
                            <td>
                                <input type="button" value="submit" class="btn btn-primary" ng-click="doautoenquiriesAction()">
                            </td> 
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

