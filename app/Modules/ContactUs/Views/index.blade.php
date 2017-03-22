<div class="row" ng-controller="contactUsCtrl" ng-init="manageContactUs(); manageCountry(); manageLocationRow();">  
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
                            <th style="width:25%">
                            <a href="javascript:void(0);" ng-click="orderByField ='address'; reverseSort = !reverseSort">Address.
                              <span ng-show="orderByField == 'address'">
                              <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                            </a></th>
                             <th style="width:15%">
                            <a href="javascript:void(0);" ng-click="orderByField ='telephone'; reverseSort = !reverseSort">Pin code.
                              <span ng-show="orderByField == 'telephone'">
                              <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                            </a></th>
                             <th style="width:25%">
                            <a href="javascript:void(0);" ng-click="orderByField ='contact_person_name'; reverseSort = !reverseSort">Contact person.
                              <span ng-show="orderByField == 'contact_person_name'">
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
                            <td> <input type="text" ng-model="search" class="form-control" style="width:100%;" placeholder="Search"></td>
                            <td></td> 
                            <td></td>
                             <td></td>
                              <td></td>
                        </tr>
                        <tr role="row" ng-repeat="item in contactUsRow| filter:search  | orderBy:orderByField:reverseSort">
                            <td>{{$index+1}}</td>
                            <td>{{item.address}}</td>     
                              <td>{{item.pin_code}}</td> 
                             <td>{{item.contact_person_name}}</td>  
                                <td>{{item.email}}</td>     
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit" style="display: block;" data-toggle="modal" data-target="#contactUsModal"><a href="javascript:void(0);" ng-click="initialModal({{ item.id}},{{$index}})"><i class="fa fa-pencil"></i></a></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="contactUsModal" role="dialog" tabindex="-1" ng-cloak>    
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <form novalidate ng-submit="contactUsForm.$valid && doContactusAction()" name="contactUsForm">
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!contactUsForm.country_id.$dirty && contactUsForm.country_id.$invalid) && (!contactUsForm.state_id.$dirty && contactUsForm.state_id.$invalid) && (!contactUsForm.city_id.$dirty && contactUsForm.city_id.$invalid) && (!contactUsForm.location_id.$dirty && contactUsForm.location_id.$invalid)  && (!contactUsForm.contact_number1.$dirty && contactUsForm.contact_number1.$invalid)  && (!contactUsForm.contact_number2.$dirty && contactUsForm.contact_number2.$invalid)  && (!contactUsForm.contact_number3.$dirty && contactUsForm.contact_number3.$invalid) && (!contactUsForm.address.$dirty && contactUsForm.address.$invalid) && (!contactUsForm.telephone.$dirty && contactUsForm.telephone.$invalid) && (!contactUsForm.email.$dirty && contactUsForm.email.$invalid) && (!contactUsForm.contact_person_name.$dirty && contactUsForm.contact_person_name.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="id" name="id">
                            <span class="input-icon icon-right">
                                
                                 <select id="country_id" name="country_id" class="form-control" ng-model="country_id" ng-options="item.id as item.name for item in countryRow" ng-change="manageStates()" required>
        	                <option value="">Select country</option>
                                 </select>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.country_id.$error">
                                    <div ng-message="required">Country is required</div>
                                </div>
                            </span>
                            <br/><br/>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="state_id" name="state_id" ng-change="manageCity()" required>
                                     <option value="">Select state</option>
                                    <option  ng-repeat="itemone in statesRow" ng-selected="{{ state_id == itemone.id}}" value="{{itemone.id}}">{{itemone.name}}</option>
                                </select>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.state_id.$error">
                                    <div ng-message="required">State is required</div>
                                </div>
                            </span>
                            <br/><br/>
                             <span class="input-icon icon-right">
                                <select class="form-control" ng-model="city_id" name="city_id" required>
                                     <option value="">Select city</option>
                                    <option  ng-repeat="itemtwo in cityRow" ng-selected="{{ city_id == itemtwo.id}}" value="{{itemtwo.id}}">{{itemtwo.name}}</option>
                                </select>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.city_id.$error">
                                    <div ng-message="required">City is required</div>
                                </div>
                            </span>
                            <br/><br/>
                             <span class="input-icon icon-right">
                                  <select id="country_id" name="location_id" class="form-control" ng-model="location_id" ng-options="itemthree.id as itemthree.location_type for itemthree in locationRow" required>
        	                           <option value="">Select location</option>
                                  </select>
                               
                                <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.location_id.$error">
                                    <div ng-message="required">Location is required</div>
                                </div>
                            </span>
                            <br/><br/>
                            
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="address" name="address" placeholder="Address" required>
                         
                                <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.address.$error">
                                    <div ng-message="required">Address is required</div>
                                </div>
                                <br/>
                            </span>
                             <br/>
                            <span class="input-icon icon-right">
                                <input type="number" class="form-control" ng-model="contact_number1" name="contact_number1" placeholder="Contact no." ng-maxlength="10" ng-minlength="10" required>
                              
                                <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.contact_number1.$error">
                                    <div ng-message="required">Contact No. is required</div>
                                     <div ng-message="minlength">Contact No. must be 10 digits</div>
                                    <div ng-message="maxlength">Contact No. must be 10 digits</div>
                                </div>
                                <br/>
                            </span>
                              <br/>
                             <span class="input-icon icon-right">
                                <input type="number" class="form-control" ng-model="contact_number2" name="contact_number2" placeholder="Contact no." ng-maxlength="10" ng-minlength="10" required>
                        
                                <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.contact_number2.$error">
                                    <div ng-message="required">Contact No. is required</div>
                                     <div ng-message="minlength">Contact No. must be 10 digits</div>
                                    <div ng-message="maxlength">Contact No. must be 10 digits</div>
                                </div>
                                <br/>
                            </span>
                               <br/><br/>
                             <span class="input-icon icon-right">
                                <input type="number" class="form-control" ng-model="contact_number3" name="contact_number3" placeholder="Contact no." ng-maxlength="10" ng-minlength="10" required>
                               
                                <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.contact_number3.$error">
                                    <div ng-message="required">Contact No. is required</div>
                                     <div ng-message="minlength">Contact No. must be 10 digits</div>
                                    <div ng-message="maxlength">Contact No. must be 10 digits</div>
                                </div>
                                <br/>
                            </span>
                                <br/>
                                <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="contact_person_name" name="contact_person_name" placeholder="Contact personname"  required>
                               
                                <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.contact_person_name.$error">
                                    <div ng-message="required">Contact person name is required</div>
                                </div>
                                <br/>
                            </span>
                              <br/>
                             <span class="input-icon icon-right">
                                <input type="number" class="form-control" ng-model="pin_code" name="pin_code" placeholder="Pin code." ng-maxlength="6" ng-minlength="6" required>
                            
                                <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.pin_code.$error">
                                    <div ng-message="required">Pin code is required</div>
                                    <div ng-message="minlength">Pin code must be 6 digits</div>
                                    <div ng-message="maxlength">Pin code must be 6 digits</div>
                                </div>
                                <br/>
                            </span>
                              <br/>
                            <span class="input-icon icon-right">
                                <input type="email" class="form-control" ng-model="email" name="email" placeholder="Email"  required>
                              
                                <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.email.$error">
                                    <div ng-message="required">Email is required</div>
                                    <div ng-message="email">Incorrect email address</div>
                                </div>
                                <br/>
                            </span>
                               <br/>
                               <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="google_map_url" name="google_map_url"  placeholder="Map url" required>
                                
                                <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.google_map_url.$error">
                                    <div ng-message="required">Map is required</div>
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

