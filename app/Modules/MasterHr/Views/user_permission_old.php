

<style>
    .tickets-list{
        list-style-type: none;
    }
</style>
<div class="row">
    <div class="widget flat radius-bordered ">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>User Permissions</h5>
            <div class="widget-body bordered-top bordered-sky col-lg-12 col-sm-12 col-xs-12">
                <div id="customer-form" ng-controller="hrController" ng-init="userPermissions([[ $empId ]])">
                    <ul class="tickets-list">
                        <li class="ticket-item" ng-repeat="parent in menuItems">
                            <input class="checkbox-slider slider-icon parentLevel" type="checkbox" id="parent_{{$index}}" data-level="parent" ng-checked="{{parent.checked}}" ng-click="accessControl([[ $empId ]],'parent_{{$index}}',[],[{{parent.submenu_ids}}])">
                            <span class="text"></span>
                            <label for="definpu"><h4><b>{{ parent.name }}</b></h4></label>
                            <ul class="tickets-list" ng-if='parent.total_submenu == 1'>    
                                <li class="ticket-item" ng-repeat="child1 in parent.submenu">
                                    <input class="checkbox-slider slider-icon" type="checkbox" ch1 id="child1_{{child1.id}}" data-level="first" ng-checked="{{child1.checked}}" ng-click="accessControl([[ $empId ]],'child1_{{child1.id}}',[],[{{child1.id}}])">
                                    <span class="text"></span>&nbsp;&nbsp; <span class="ver-allign">{{ child1.name }}</span>
                                </li>
                            </ul>
                            <ul class="tickets-list" ng-if='parent.total_submenu !== 1'>    
                                <li class="ticket-item" ng-repeat="child1 in parent.submenu">
                                    <input class="checkbox-slider slider-icon liChild" type="checkbox" re1 ng-if='child1.total_submenu == 1' id="child1_{{child1.id}}" data-level="first" ng-checked="{{child1.checked}}" ng-click="accessControl([[ $empId ]],'child1_{{child1.id}}',[],[{{child1.id}}])">
                                    <input class="checkbox-slider slider-icon liChild" type="checkbox" re2 ng-if='child1.total_submenu != 1' id="child1_{{child1.id}}" data-level="first" ng-checked="{{child1.checked}}" ng-click="accessControl([[ $empId ]],'child1_{{child1.id}}',[{{child1.id}}],[{{ child1.submenu_ids }}])">
                                    <span class="text"></span>&nbsp;&nbsp; <span class="ver-allign">{{ child1.name }}</span>
                                    <ul class="tickets-list" ng-if='child1.total_submenu == 1'>    
                                        <li class="ticket-item" ng-repeat="child2 in child1.submenu">
                                            <input class="checkbox-slider slider-icon liChild" type="checkbox" id="child2_{{child2.id}}" ng-checked="{{child2.checked}}" data-level="second" ng-click="accessControl([[ $empId ]],'child2_{{child2.id}}',[{{child1.id}}],[{{child2.id}}])">
                                            <span class="text"></span>&nbsp;&nbsp; <span class="ver-allign">{{ child2.name }}</span>
                                        </li>
                                    </ul>
                                    <ul class="tickets-list" ng-if='child1.total_submenu !== 1'>    
                                        <li class="ticket-item" ng-repeat="child2 in child1.submenu">
                                            <input class="checkbox-slider slider-icon liChild" type="checkbox" ng-if='child2.total_submenu == 1' id="child2_{{child2.id}}" data-level="second" ng-checked="{{child2.checked}}" ng-click="accessControl([[ $empId ]],'child2_{{child2.id}}',[{{child1.id}}],[{{child2.id}}])">
                                            <input class="checkbox-slider slider-icon liChild" type="checkbox" ng-if='child2.total_submenu != 1' id="child2_{{child2.id}}" data-level="second" ng-checked="{{child2.checked}}" ng-click="accessControl([[ $empId ]],'child2_{{child2.id}}',[{{child1.id}},{{child2.id}}],[{{ child2.submenu_ids }}])">
                                            <span class="text"></span>&nbsp;&nbsp; <span class="ver-allign">{{ child2.name }} </span>
                                            <ul class="tickets-list" ng-if='child2.total_submenu == 1'>    
                                                <li class="ticket-item" ng-repeat="child3 in child2.submenu">
                                                    <input class="checkbox-slider slider-icon liChild" type="checkbox" id="child3_{{child3.id}}" ng-checked="{{child3.checked}}" data-level="third" ng-click="accessControl([[ $empId ]],'child2_{{child3.id}}',[{{child1.id}},{{child2.id}}],[{{child3.id}}])">
                                                    <span class="text"></span>&nbsp;&nbsp; <span class="ver-allign">{{ child3.name }}</span>
                                                </li>
                                            </ul>
                                            <ul class="tickets-list" ng-if='child2.total_submenu !== 1'> 
                                                <li class="ticket-item" ng-repeat="child3 in child2.submenu">
                                                    <input class="checkbox-slider slider-icon liChild" type="checkbox" ng-if='child3.total_submenu == 1' id="child3_{{child3.id}}" data-level="third" ng-checked="{{child3.checked}}" ng-click="accessControl([[ $empId ]],'child3_{{child3.id}}',[{{child1.id}},{{child2.id}}],[{{child3.id}}])">
                                                    <input class="checkbox-slider slider-icon liChild" type="checkbox" ng-if='child3.total_submenu != 1' id="child3_{{child3.id}}" data-level="third" ng-checked="{{child3.checked}}" ng-click="accessControl([[ $empId ]],'child3_{{child3.id}}',[{{child1.id}},{{child2.id}},{{child3.id}}],[{{ child3.submenu_ids }}])">
                                                    <span class="text"></span>&nbsp;&nbsp; <span class="ver-allign">{{ child3.name }}</span>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('document').ready(function(){
    
//    $("#parent_0").click(function(){
//       alert("hhh"); 
//    });
//    console.log($('input[type=checkbox][data-level="parent"]').is(':checked'));
//    $('.parentLevel').on("click",function() {
//        var checked = $(this).is(':checked');
//        alert("in if");
//        if(checked)
//        {
//            alert("in if");
//            $(this).parent().find('input[type=checkbox][data-level="first"]').prop('checked', true);
//            
//        }
//        else
//        {
//            $(this).parent().find('input[type=checkbox][data-level="first"]').prop('checked', false);
//        }
//    }); 
});
</script>


