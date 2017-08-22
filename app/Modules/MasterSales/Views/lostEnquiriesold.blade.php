<div class="widget flat radius-bordered " ng-controller="enquiryController" ng-init="getLostEnquiries()">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">{{pageHeading}}</span>
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                </div>
            </div>   
            <div data-ng-include=" '/MasterSales/enquiryListing' "></div>           
        </div>
    </div> 
    <!-- Enquiry Filter modal -->
    <div data-ng-include=" '/MasterSales/showFilter'" ng-click="procName('proc_get_lost_enquiries')"></div>
</div>