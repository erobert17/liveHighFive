<!-- #menu -->
        <ul id="menu" class="bg-blue dker">
            <li {!! (Request::is('index')? 'class="active"':"") !!}>
                <a href="{{ URL::to('index') }} ">
                    <i class="fa fa-home"></i>
                    <span class="link-title">&nbsp;Dashboard</span>
                </a>
            </li>
            <li {!! (Request::is('general_components')|| Request::is('transitions') || Request::is('buttons')|| Request::is('icons')|| Request::is('animations')|| Request::is('sliders')|| Request::is('notifications')|| Request::is('p_notify')|| Request::is('modal')|| Request::is('sortable')|| Request::is('sweet_alert')|| Request::is('cropper')|| Request::is('jstree')|| Request::is('grids_layout') ? 'class="active"' : '') !!}>
                <a href="javascript:;">
                    <i class="fa fa-anchor"></i>
                    <span class="link-title">&nbsp; Components</span>
                    <span class="fa arrow"></span>
                </a>
                <ul>
                    <li {!! (Request::is('general_components') ? 'class="active"' : '') !!}>
                        <a href="{{ URL::to('general_components') }}">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; General Components
                        </a>
                    </li>
                    <li {!! (Request::is('transitions') ? 'class="active"' : '') !!}>
                        <a href="{{ URL::to('transitions') }}">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Transitions
                        </a>
                    </li>
                    <li {!! (Request::is('buttons') ? 'class="active"' : '') !!}>
                        <a href="{{ URL::to('buttons') }}">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Buttons
                        </a>
                    </li>
                    <li {!! (Request::is('icons') ? 'class="active"' : '') !!}>
                        <a href="{{ URL::to('icons') }}">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Icons
                        </a>
                    </li>
                    <li {!! (Request::is('animations') ? 'class="active"' : '') !!}>
                        <a href="{{ URL::to('animations') }}">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Animations
                        </a>
                    </li>

                    <li {!! (Request::is('sliders') ? 'class="active"' : '') !!}>
                        <a href="{{ URL::to('sliders') }}">
                            <i class="fa fa-angle-right"></i>
                            &nbsp;  Sliders
                        </a>
                    </li>
                    <li {!! (Request::is('notifications') ? 'class="active"' : '') !!}>
                        <a href="{{ URL::to('notifications') }}">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Notifications
                        </a>
                    </li>
                    <li {!! (Request::is('p_notify') ? 'class="active"' : '') !!}>
                        <a href="{{ URL::to('p_notify') }}">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; P-Notify
                        </a>
                    </li>
                    <li {!! (Request::is('cropper') ? 'class="active"' : '') !!}>
                        <a href="{{ URL::to('cropper') }}">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Cropper
                        </a>
                    </li>
                    <li {!! (Request::is('jstree') ? 'class="active"' : '') !!}>
                        <a href="{{ URL::to('jstree') }}">
                            <i class="fa fa-angle-right"></i>
                            &nbsp;Js Tree
                        </a>
                    </li>
                    <li {!! (Request::is('modal') ? 'class="active"' : '') !!}>
                        <a href="{{ URL::to('modal') }}">
                            <i class="fa fa-angle-right"></i>
                            &nbsp;  Modals
                        </a>
                    </li>
                    <li {!! (Request::is('sortable') ? 'class="active"' : '') !!}>
                        <a href="{{ URL::to('sortable') }}">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Sortable
                        </a>
                    </li>
                    <li {!! (Request::is('sweet_alert') ? 'class="active"' : '') !!}>
                        <a href="{{ URL::to('sweet_alert') }}">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Sweet alerts
                        </a>
                    </li>
                    <li {!! (Request::is('grids_layout') ? 'class="active"' : '') !!}>
                        <a href="{{ URL::to('grids_layout') }}">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Grid View
                        </a>
                    </li>
                </ul>
            </li>
            <li {!! (Request::is ('widgets')|| Request::is('widgets2')? 'class="active"':"" )!!}>
                <a href="javascript:;">
                    <i class="fa fa-th-large"></i>
                    <span class="link-title">&nbsp; Widgets</span>
                    <span class="fa arrow"></span>
                </a>
                <ul>
                    <li {!! (Request::is('widgets')? 'class="active"':"") !!}>
                        <a href="{{URL::to('widgets')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Widgets1
                        </a>
                    </li>
                    <li {!! (Request::is('widgets2')? 'class="active"':"") !!}>
                        <a href="{{URL::to('widgets2')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Widgets2
                        </a>
                    </li>
                </ul>
            </li>
            <li {!! (Request::is ('form_elements')|| Request::is('form_layouts')|| Request::is('form_validations')|| Request::is('form_editors')|| Request::is('radio_checkbox')|| Request::is('form_wizards')|| Request::is('datetime_picker')|| Request::is('ratings')? 'class="active"':"" )!!}>
                <a href="javascript:;">
                    <i class="fa fa-pencil"></i>
                    <span class="link-title">&nbsp; Forms</span>
                    <span class="fa arrow"></span>
                </a>
                <ul>
                    <li {!! (Request::is('form_elements')? 'class="active"':"") !!}>
                        <a href="{{URL::to('form_elements')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Form Elements
                        </a>
                    </li>
                    <li {!! (Request::is('form_layouts')? 'class="active"':"") !!}>
                        <a href="{{URL::to('form_layouts')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Form Layouts
                        </a>
                    </li>
                    <li {!! (Request::is('form_validations')? 'class="active"':"") !!}>
                        <a href="{{URL::to('form_validations')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Form Validations
                        </a>
                    </li>
                    <li {!! (Request::is('form_editors')? 'class="active"':"") !!}>
                        <a href="{{URL::to('form_editors')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Form Editors
                        </a>
                    </li>
                    <li {!! (Request::is('radio_checkbox')? 'class="active"':"") !!}>
                        <a href="{{URL::to('radio_checkbox')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Radio and Checkbox
                        </a>
                    </li>
                    <li {!! (Request::is('form_wizards')? 'class="active"':"") !!}>
                        <a href="{{URL::to('form_wizards')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Wizards
                        </a>
                    </li>
                    <li {!! (Request::is('datetime_picker')? 'class="active"':"") !!}>
                        <a href="{{URL::to('datetime_picker')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Date Time Picker
                        </a>
                    </li>
                    <li {!! (Request::is('ratings')? 'class="active"':"") !!}>
                        <a href="{{URL::to('ratings')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Ratings
                        </a>
                    </li>
                </ul>
            </li>
            <li {!! (Request::is('simple_tables')|| Request::is('simple_datatables')|| Request::is('datatables') || Request::is('advanced_tables')? 'class="active"':"")!!}>
            <a href="#">
                    <i class="fa fa-th"></i>
                    <span class="link-title">&nbsp; Tables</span>
                    <span class="fa arrow"></span>
                </a>
                <ul>
                    <li {!! (Request::is('simple_tables')? 'class="active"':"") !!}>
                        <a href="{{URL::to('simple_tables')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Simple Tables
                        </a>
                    </li>
                    <li {!! (Request::is('simple_datatables')? 'class="active"':"") !!}>
                        <a href="{{URL::to('simple_datatables')}} ">
                            <i class="fa fa-angle-right"></i>
                            <span class="link-title">&nbsp; Simple Data Tables</span>

                        </a>
                        </li>
                    <li {!! (Request::is('datatables')? 'class="active"':"") !!}>
                        <a href="{{URL::to('datatables')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Data Tables
                        </a>
                    </li>
                    <li {!! (Request::is('advanced_tables')? 'class="active"':"") !!}>
                        <a href="{{URL::to('advanced_tables')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Advanced Tables
                        </a>
                    </li>
                </ul>
            </li>
            <li {!! (Request::is('charts')|| Request::is('advanced_charts') || Request::is('chartist')|| Request::is('rickshaw')? 'class="active"':"")!!}>
            <a href="#">
                    <i class="fa fa-bar-chart"></i>
                    <span class="link-title">&nbsp; Charts</span>
                    <span class="fa arrow"></span>
                </a>
                <ul>
                    <li {!! (Request::is('charts')? 'class="active"':"") !!}>
                        <a href="{{URL::to('charts')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Flot Charts
                        </a>
                    </li>
                    <li {!! (Request::is('advanced_charts')? 'class="active"':"") !!}>
                        <a href="{{URL::to('advanced_charts')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Advanced Charts
                        </a>
                    </li>
                    <li {!! (Request::is('chartist')? 'class="active"':"") !!}>
                        <a href="{{URL::to('chartist')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Chartist
                        </a>
                    </li>
                    <li {!! (Request::is('rickshaw')? 'class="active"':"") !!}>
                        <a href="{{URL::to('rickshaw')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Rickshaw Charts
                        </a>
                    </li>
                </ul>
            </li>
            <li {!! (Request::is('users')|| Request::is('add_user') || Request::is('view_user')|| Request::is('delete_user')? 'class="active"':"")!!}>
            <a href="#">
                    <i class="fa fa-user"></i>
                    <span class="link-title">&nbsp; Users</span>
                    <span class="fa arrow"></span>
                </a>
                <ul>
                    <li {!! (Request::is('users')? 'class="active"':"") !!}>
                        <a href="{{URL::to('users')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; User Grid
                        </a>
                    </li>
                    <li {!! (Request::is('add_user')? 'class="active"':"") !!}>
                        <a href="{{URL::to('add_user')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Add User
                        </a>
                    </li>
                    <li {!! (Request::is('view_user')? 'class="active"':"") !!}>
                        <a href="{{URL::to('view_user')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; User Profile
                        </a>
                    </li>
                    <li {!! (Request::is('delete_user')? 'class="active"':"") !!}>
                        <a href="{{URL::to('delete_user')}} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Delete User
                        </a>
                    </li>
                </ul>
            </li>
            <li {!! (Request::is('calendar')? 'class="active"':"") !!}>
                <a href="{{ URL::to('calendar') }} ">
                    <i class="fa fa-calendar"></i>
                    <span class="link-title">&nbsp; Calendar</span>
                    <span class="badge badge-pill badge-primary float-right calendar_badge">7</span>
                </a>
            </li>
            <li {!! (Request::is('gallery')? 'class="active"':"") !!}>
                <a href="{{ URL::to('gallery') }} ">
                    <i class="fa fa-picture-o"> </i>
                    &nbsp; Gallery
                </a>
            </li>
            <li {!! (Request::is('mail_compose')|| Request::is('mail_inbox') || Request::is('mail_view')|| Request::is('mail_sent')|| Request::is('mail_spam')|| Request::is('mail_draft')|| Request::is('mail_trash') ? 'class="active"' : '') !!}>
            <a href="#">
                    <i class="fa fa-envelope-o"></i>
                    <span class="link-title">&nbsp; Email</span>
                    <span class="fa arrow"></span>
                </a>
                <ul>
                    <li {!! (Request::is('mail_compose')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('mail_compose') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Compose
                        </a>
                    </li>
                    <li {!! (Request::is('mail_inbox')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('mail_inbox') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Inbox
                        </a>
                    </li>
                    <li {!! (Request::is('mail_view')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('mail_view') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; View
                        </a>
                    </li>
                    <li {!! (Request::is('mail_sent')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('mail_sent') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp;  Sent
                        </a>
                    </li>
                    <li {!! (Request::is('mail_spam')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('mail_spam') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Spam
                        </a>
                    </li>
                    <li {!! (Request::is('mail_draft')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('mail_draft') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Draft
                        </a>
                    </li>
                    <li {!! (Request::is('mail_trash')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('mail_trash') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp;  Trash
                        </a>
                    </li>
                </ul>
            </li>
            <li {!! (Request::is('maps')|| Request::is('jqvmaps') ? 'class="active"' : '') !!}>
            <a href="#">
                    <i class="fa fa-map-marker"></i>
                    <span class="link-title">&nbsp; Maps</span>
                    <span class="fa arrow"></span>
                </a>
                <ul>
                    <li {!! (Request::is('maps')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('maps') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Google Maps
                        </a>
                    </li>
                    <li {!! (Request::is('jqvmaps')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('jqvmaps') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Vector Maps
                        </a>
                    </li>
                </ul>
            </li>
            <li {!! (Request::is('404')|| Request::is('500') || Request::is('login')|| Request::is('register')|| Request::is('lockscreen')|| Request::is('invoice')|| Request::is('blank') ? 'class="active"' : '') !!}>
                <a href="javascript:;">
                    <i class="fa fa-file"></i>
                    <span class="link-title">&nbsp; Pages</span>
                    <span class="fa arrow"></span>
                </a>
                <ul>
                    <li {!! (Request::is('404')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('404') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; 404
                        </a>
                    </li>
                    <li {!! (Request::is('500')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('500') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; 500
                        </a>
                    </li>
                    <li {!! (Request::is('login')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('login') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Login
                        </a>
                    </li>
                    <li {!! (Request::is('register')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('register') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Register
                        </a>
                    </li>
                    <li {!! (Request::is('lockscreen')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('lockscreen') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Lock Screen
                        </a>
                    </li>
                    <li {!! (Request::is('invoice')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('invoice') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Invoice
                        </a>
                    </li>
                    <li {!! (Request::is('blank')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('blank') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Blank Page
                        </a>
                    </li>
                </ul>
            </li>
            <li {!! (Request::is('boxed')|| Request::is('fixed-header-boxed') || Request::is('fixed-header-menu')|| Request::is('fixed-header')|| Request::is('fixed-menu-boxed')|| Request::is('fixed-menu')|| Request::is('no-header')|| Request::is('no-left-sidebarr') ? 'class="active"' : '') !!}>
                <a href="javascript:;">
                    <i class="fa fa-th"></i>
                    <span class="link-title">&nbsp; Layouts</span>
                    <span class="fa arrow"></span>
                </a>
                <ul>
                    <li {!! (Request::is('boxed')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('boxed') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Boxed Layout
                        </a>
                    </li>
                    <li {!! (Request::is('fixed-header-boxed')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('fixed-header-boxed') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Boxed &amp; Fixed Header
                        </a>
                    </li>
                    <li {!! (Request::is('fixed-header-menu')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('fixed-header-menu') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Fixed Header &amp; Menu
                        </a>
                    </li>
                    <li {!! (Request::is('fixed-header')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('fixed-header') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Fixed Header
                        </a>
                    </li>
                    <li {!! (Request::is('fixed-menu-boxed')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('fixed-menu-boxed') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Boxed &amp; Fixed Menu
                        </a>
                    </li>
                    <li {!! (Request::is('no-header')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('no-header') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; No Header
                        </a>
                    </li>
                    <li {!! (Request::is('no-left-sidebar')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('no-left-sidebar') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; No Left Sidebar
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="fa fa-sitemap"></i>
                    <span class="link-title">&nbsp; Multi Level Menu</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-angle-right"></i>
                            &nbsp;Level 1
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu sub-submenu">
                            <li>
                                <a href="javascript:;">
                                    <i class="fa fa-angle-right"></i>
                                    &nbsp;Level 2
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="fa fa-angle-right"></i>
                                    &nbsp;Level 2
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="fa fa-angle-right"></i>
                                    &nbsp;Level 2
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="sub-menu sub-submenu">
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-angle-right"></i>
                                            &nbsp;Level 3
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-angle-right"></i>
                                            &nbsp;Level 3
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-angle-right"></i>
                                            &nbsp;Level 3
                                            <span class="fa arrow"></span>
                                        </a>
                                        <ul class="sub-menu sub-submenu">
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-angle-right"></i>
                                                    &nbsp;Level 4
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-angle-right"></i>
                                                    &nbsp;Level 4
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-angle-right"></i>
                                                    &nbsp;Level 4
                                                    <span class="fa arrow"></span>
                                                </a>
                                                <ul class="sub-menu sub-submenu">
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="fa fa-angle-right"></i>
                                                            &nbsp;Level 5
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="fa fa-angle-right"></i>
                                                            &nbsp;Level 5
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="fa fa-angle-right"></i>
                                                            &nbsp;Level 5
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-angle-right"></i>
                                            &nbsp;Level 4
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="fa fa-angle-right"></i>
                                    &nbsp;Level 2
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-angle-right"></i>
                            &nbsp;Level 1
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-angle-right"></i>
                            &nbsp;Level 1
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu sub-submenu">
                            <li>
                                <a href="javascript:;">
                                    <i class="fa fa-angle-right"></i>
                                    &nbsp;Level 2
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="fa fa-angle-right"></i>
                                    &nbsp;Level 2
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="fa fa-angle-right"></i>
                                    &nbsp;Level 2
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- end menu -->