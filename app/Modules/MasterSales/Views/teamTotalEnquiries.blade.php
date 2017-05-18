<div class="widget flat radius-bordered " ng-controller="enquiryController" ng-init="getTeamTotalEnquiries()">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Team Total Enquiries</span>
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                </div>
            </div>        
            <div data-ng-include=" '[[ config('global.getUrl') ]]/MasterSales/listingTable' "></div>
        </div>
    </div> 
</div>