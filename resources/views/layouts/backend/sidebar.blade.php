<!-- Page Sidebar Header-->
<div class="sidebar-header-wrapper">
    <input type="text" class="searchinput" />
    <i class="searchicon fa fa-search"></i>
    <div class="searchhelper">Search Reports, Charts, Emails or Notifications</div>
</div>
<!-- /Page Sidebar Header -->
<!-- Sidebar Menu -->

<ul class="nav sidebar-menu" ng-controller="adminController" id="cstmenu">
    <li ng-repeat="parent in getMenu.mainMenu" ui-sref-active="{{ parent.uiSrefActive }}" class="{{ parent.liclass }}" ng-if="parent.name !== 'BMS Other Permission'">
        <a ng-if='!parent.has_submenu' ui-sref="{{ parent.slug }}" class="{{ parent.anchorClass }}" ng-Click="checkPermission('{{ parent.slug }}')">
            <p class="{{ parent.icon }}"></p>
            <span class="menu-text"> {{ parent.name }} </span>
            <i class="menu-expand"></i>
        </a>
        <a  ng-if='parent.has_submenu' href="#" class="{{ parent.anchorClass }} abcd" >
            <p class="{{ parent.icon }}" ></p>
            <span class="menu-text"> {{ parent.name }} </span>
            <i class="menu-expand"></i>
        </a>
        <ul ng-if='parent.has_submenu' class="{{ parent.submenuClass }}">
            <li ng-repeat="child1 in parent.submenu" ui-sref-active="{{ child1.uiSrefActive }}" class="{{ child1.liclass }}">
                <a ui-sref="{{ child1.slug }}" class="{{ child1.anchorClass }}" ng-if='!child1.has_submenu'>
                    <span class="menu-text"> {{ child1.name }} </span>
                </a>
                <a href="#" class="{{ child1.anchorClass }}" ng-if='child1.has_submenu'>
                    <span class="menu-text"> {{ child1.name }} </span>
                    <i class="menu-expand"></i>
                </a>
                <ul ng-if='child1.has_submenu' class="{{ child1.submenuClass }}">
                    <li ng-repeat="child2 in child1.submenu" ui-sref-active="{{ child2.uiSrefActive }}">
                        <a ng-if='!child2.has_submenu' ui-sref="{{ child2.slug }}" class="{{ child2.anchorClass }}">
                            <span class="menu-text"> {{ child2.name }} </span>
                        </a>
                        <a ng-if='child2.has_submenu' href="#" class="{{ child2.anchorClass }}">
                            <span class="menu-text"> {{ child2.name }} </span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul ng-if='child2.has_submenu' class="{{ child2.submenuClass }}">
                            <li ng-repeat="child3 in child2.submenu" ui-sref-active="{{ child3.uiSrefActive }}">
                                <a ng-if='!child3.has_submenu' ui-sref="{{ child3.slug }}" class="{{ child3.anchorClass }}">
                                    <span class="menu-text"> {{ child3.name }} </span>
                                </a>
                                <a ng-if='child3.has_submenu' href="#" class="{{ child3.anchorClass }}">
                                    <span class="menu-text"> {{ child3.name }} </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
</ul>
<!-- /Sidebar Menu -->

<toaster-container toaster-options="{'time-out': 2000,'position-class': 'toast-center', 'close-button':true}"></toaster-container>

<script>
$(document).ready(function(){
    setTimeout(function(t){  
        $("ul#cstmenu > li > a").click(function (t) {
            $('ul#cstmenu > li > ul.submenu').not($(this).siblings()).slideUp();
            $('#cstmenu > li > ul > li > ul').not($(this).siblings()).slideUp();
            $('#cstmenu > li > ul > li > ul > li > ul').not($(this).siblings()).slideUp();
            $(this).siblings("ul.submenu").slideToggle();
            
            $(this).parent().addClass("open");
            $(this).nextAll().removeClass("open");
            $(this).prevAll().removeClass("open");
            
            /*var n = $("#sidebar").hasClass("menu-compact");console.log($(this).siblings());
            var i = $(t.target).closest("a"),
                    u, r, f;
            if (i && i.length != 0) {
                if (!i.hasClass("menu-dropdown")) return n && i.get(0).parentNode.parentNode == this && (u = i.find(".menu-text").get(0), t.target != u && !$.contains(u, t.target)) ? !1 : void 0;
                if (r = i.next().get(0), !$(r).is(":visible")) {
                    if (f = $(r.parentNode).closest("ul"), n && f.hasClass("sidebar-menu")) return;
                    f.find("> .open > .submenu").each(function() {
                        this == r || $(this.parentNode).hasClass("active") || $(this).slideUp(200).parent().removeClass("open")
                    })
                }
                
            return n && $(r.parentNode.parentNode).hasClass("sidebar-menu") ? !1 : ($(r).slideToggle(200).parent().toggleClass("open"), !1)
            }*/
        });

        $("#cstmenu > li > ul > li > a").click(function (t) {
            $('#cstmenu > li > ul > li > ul').not($(this).siblings()).slideUp();
            $(this).siblings("ul.submenu").slideToggle();
            $(this).parent().addClass("open");
            //$('#cstmenu > li > ul > li ').not($(this).siblings()).removeClass("open");
          
            
            
            /*var n = $("#sidebar").hasClass("menu-compact");
            var i = $(t.target).closest("a"),
                    u, r, f;
            if (i && i.length != 0) {
                if (!i.hasClass("menu-dropdown")) return n && i.get(0).parentNode.parentNode == this && (u = i.find(".menu-text").get(0), t.target != u && !$.contains(u, t.target)) ? !1 : void 0;
                if (r = i.next().get(0), !$(r).is(":visible")) {
                    if (f = $(r.parentNode).closest("ul"), n && f.hasClass("sidebar-menu")) return;
                    f.find("> .open > .submenu").each(function() {
                        this == r || $(this.parentNode).hasClass("active") || $(this).slideUp(200).parent().removeClass("open")
                    })
                }
                return n && $(r.parentNode.parentNode).hasClass("sidebar-menu") ? !1 : ($(r).slideToggle(200).parent().toggleClass("open"), !1)
            }*/
        });

        $("#cstmenu > li > ul > li > ul > li > a").click(function (t) {
            $('#cstmenu > li > ul > li > ul > li > ul').not($(this).siblings()).slideUp();
            $(this).siblings("ul.submenu").slideToggle();
            console.log($(this).siblings("li.open"));
            $(this).parent().addClass("open");
            $('#cstmenu > li > ul > li > ul > li > ul').not($(this).siblings()).removeClass("open");
            
            
            
           /* var n = $("#sidebar").hasClass("menu-compact");
            var i = $(t.target).closest("a"),
                    u, r, f;
            if (i && i.length != 0) {
                if (!i.hasClass("menu-dropdown")) return n && i.get(0).parentNode.parentNode == this && (u = i.find(".menu-text").get(0), t.target != u && !$.contains(u, t.target)) ? !1 : void 0;
                if (r = i.next().get(0), !$(r).is(":visible")) {
                    if (f = $(r.parentNode).closest("ul"), n && f.hasClass("sidebar-menu")) return;
                    f.find("> .open > .submenu").each(function() {

                        this == r || $(this.parentNode).hasClass("active") || $(this).slideUp(200).parent().removeClass("open")
                    })
                }
                return n && $(r.parentNode.parentNode).hasClass("sidebar-menu") ? !1 : ($(r).slideToggle(200).parent().toggleClass("open"), !1)
            }*/
        });
    }, 1000); 
});
</script>