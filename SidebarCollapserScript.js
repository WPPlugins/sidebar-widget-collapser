function InitializeSidebarItems() {

    var savedSettings = SideBarWidgetGetCookie('CollapsedSidebarItems');

    if(savedSettings!=null) {

        SBCS.CollapsedItems = (unescape(savedSettings)).evalJSON();
    }
    if(SBCS.CollapsedItems==null || SBCS.CollapsedItems.length==0) {

        SBCS.CollapsedItems = $A(new Array());

        $A(SBCS.widgetidsdefaultcollapse.split(",")).each(
            function(widgetID) {
                SBCS.CollapsedItems.push(widgetID);
            }
        );

    }

    SBCS.SaveCollapsedItems = function() {
        SideBarWidgetSetCookie('CollapsedSidebarItems',
            escape(Object.toJSON(SBCS.CollapsedItems.uniq().compact())));
    };

    $A(SBCS.sidebarID.split(",")).each(
        function(sidebarID) {
            InitializeSidebar($(sidebarID));
        }
    );

}

function InitializeSidebar(sidebar) {

    if(sidebar) {

        // For each list in the sidebar - should only be one in most cases
        $A(sidebar.getElementsByTagName(SBCS.sidebarListEl)).each(
            function(list) {

                if(list.parentNode==sidebar) {

                    list.select(SBCS.sidebarListItemEl+'.'+SBCS.sidebarListItemPartialClassName).each(
                        function(sideBarItem) {

                            if(sideBarItem.parentNode==list) {

                                // Configure Title Element
                                sideBarItem.select('.'+SBCS.sidebarWidgetTitlePartialClassName).each(
                                    function(title) {

                                        sideBarItem.Title = title;

                                        var toggleLink = document.createElement('a');
                                        toggleLink.className = "SideBarWidgetToggle";
                                        toggleLink.setAttribute('href','#');
                                        sideBarItem.ToggleLink = toggleLink;
                                        title.appendChild(toggleLink);
                                    }
                                );

                                // Configure wrapper div
                                var wrapper = document.createElement('div');
                                wrapper.className = "SideBarWidgetContentWrapper";
                                sideBarItem.Wrapper = wrapper;

                                $A(sideBarItem.childNodes).each(
                                    function(child) {

                                        if(child!=sideBarItem.Title) {

                                            sideBarItem.removeChild(child);
                                            wrapper.appendChild(child);
                                        }
                                    }
                                );
                                sideBarItem.appendChild(wrapper);

                                sideBarItem.IsCollapsed = function() {
                                    return SBCS.CollapsedItems.indexOf(this.id) != -1;
                                }

                                sideBarItem.Hide = function() {

                                    this.select('div.SideBarWidgetContentWrapper').each(
                                        function(child) {

                                            //$(child).hide();
                                            Effect.SlideUp($(child), {transition: Effect.Transitions.sinoidal} );

                                            sideBarItem.select('.SideBarWidgetToggle').each(
                                                function(link) {

                                                    if ( !link.hasClassName('sbwcollapsed') ) {
                                                        link.addClassName('sbwcollapsed');
                                                    }

                                                    while(link.hasChildNodes()) {
                                                        link.removeChild(link.lastChild);
                                                    }
                                                    link.appendChild( document.createTextNode(SBCS.show) );

                                                    sideBarItem.Title.stopObserving('click');
                                                    sideBarItem.Title.observe('click',sideBarItem.Show.bind(sideBarItem));
                                                }
                                            );
                                        }
                                    );

                                    SBCS.CollapsedItems.push(this.id);
                                    SBCS.SaveCollapsedItems();
                                }

                                sideBarItem.Show = function() {

                                    this.select('div.SideBarWidgetContentWrapper').each(
                                        function(child) {

                                            //$(child).show();
                                            Effect.SlideDown($(child), {transition: Effect.Transitions.sinoidal} );

                                            sideBarItem.select('.SideBarWidgetToggle').each(
                                                function(link) {

                                                    if ( link.hasClassName('sbwcollapsed') ) {
                                                        link.removeClassName('sbwcollapsed');
                                                    }

                                                    while(link.hasChildNodes()) {
                                                        link.removeChild(link.lastChild);
                                                    }
                                                    link.appendChild( document.createTextNode(SBCS.hide) );

                                                    sideBarItem.Title.stopObserving('click');
                                                    sideBarItem.Title.observe('click',sideBarItem.Hide.bind(sideBarItem));
                                                }
                                            );
                                        }
                                    );

                                    SBCS.CollapsedItems = SBCS.CollapsedItems.without(this.id);
                                    SBCS.SaveCollapsedItems();
                               }

                                if(sideBarItem.IsCollapsed()) {
                                    sideBarItem.Hide();
                                }
                                else {
                                    sideBarItem.Show();
                                }
                            }
                        }
                    );

                }
            }
        );
	}
}

function SideBarWidgetSetCookie(name, value, expires, path, domain, secure)
{
    document.cookie= name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires.toGMTString() : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}
function SideBarWidgetGetCookie(name)
{
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1)
    {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else
    {
        begin += 2;
    }
    var end = document.cookie.indexOf(";", begin);
    if (end == -1)
    {
        end = dc.length;
    }
    return unescape(dc.substring(begin + prefix.length, end));
}

document.observe("dom:loaded", InitializeSidebarItems);