<div class="row" ng-controller="testimonialsCtrl" ng-init="managedTestimonials()">  
  <div>
          <flash-message duration="5000"></flash-message>
  </div>
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Testimonials</span>
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body table-responsive">     
            <div class="row">
                    <div class="col-sm-6 col-xs-12">
                      <label for="search">Search:</label>
                      <input type="text" ng-model="search" class="form-control" style="width:25%;" placeholder="Search">
                    </div>

                    <div class="col-sm-6 col-xs-12">
                      <label for="search">Records per page:</label>
                      <input type="number" min="1" max="50" style="width:25%;" class="form-control" ng-model="itemsPerPage">
                    </div>
                </div><br>           
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">
                            <a href="javascript:void(0);" ng-click="orderByField ='id'; reverseSort = !reverseSort">SR No.
                              <span ng-show="orderByField == 'id'">
                              <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                            </a></th>                          
                            <th style="width: 30%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'block_stages'; reverseSort = !reverseSort">Person name
                                <span ng-show="orderByField == 'block_stages'">
                                  <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                </span>
                                </a>
                            </th> 
                            <th style="width: 30%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'block_stages'; reverseSort = !reverseSort">Mobile No
                                <span ng-show="orderByField == 'block_stages'">
                                  <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                </span>
                                </a>
                            </th> 
                            <th style="width: 30%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'block_stages'; reverseSort = !reverseSort">Testimonial
                                <span ng-show="orderByField == 'block_stages'">
                                  <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                </span>
                                </a>
                            </th> 
                            <th style="width: 30%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'block_stages'; reverseSort = !reverseSort">Date & Time
                                <span ng-show="orderByField == 'block_stages'">
                                  <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                </span>
                                </a>
                            </th> 
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                         <tr role="row" dir-paginate="list in ApprovedTestimonialsRow|  filter:search | itemsPerPage:itemsPerPage |orderBy:orderByField:reverseSort">
                             <td>{{itemsPerPage * (noOfRows-1)+$index+1}}</td>
                            <td>{{ list.person_name}}</td>  
                            <td>{{ list.mobile_no }}</td>  
                            <td>{{list.testimonial}}</td>
                             <td>{{list.created_at}}</td>
                           <td class="fa-div">
                                 <div class="fa-hover" tooltip-html-unsafe="Edit" style="display: block;" ><a href="#/[[config('global.getUrl')]]/testimonial-manage/update/{{ list.testimonial_id }}"><i class="fa fa-pencil"></i></a></div>
                            </td> 
                        </tr>
                    </tbody>
                </table>
                <div class="DTTTFooter">
                    <div class="col-sm-6">
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{noOfRows}}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                            <dir-pagination-controls class="pagination" on-page-change="pageChangeHandler(newPageNumber)" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

