        <!-- #menu -->
        <script type="text/javascript">
            $(document).ready(function(){
                $('ul#menu li').click(function(){
                    if( $(this).hasClass( "active" ) == true ){
                        $(this).removeClass("active");
                        $(this).find('ul').removeClass("in");
                    }else{
                        $(this).addClass("active");
                        $(this).find('ul').addClass("in");
                    }
                });
            });
        </script>

        <ul id="menu" class="bg-blue dker">
                
                @role('admin', true)
                    <a href="javascript:;">
                        <span class="link-title">&nbsp; Users</span>
                    </a>
                    <ul>
                
                        <li>
                            <a href="{{ url('/users')}}">
                                <i class="fa fa-fw fa-group" aria-hidden="true"></i>
                                View Users
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/users/create')}}">
                                <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                Create New User
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/users/deleted')}}">
                                <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                Deleted Users
                            </a>
                        </li>
                
                    </ul>

                @endrole



                <ul>

                    <li class="">
                        <a href="/home">
                            <i class="fa fa-pencil"></i>
                            <span class="link-title">&nbsp; Dashboard </span>
                        </a>
                    </li>

                    <li class="">
                        <a href="/allLandingPages">
                            <i class="fa fa-pencil"></i>
                            <span class="link-title">&nbsp; Your Landing Pages </span>
                            <?php //allLandingPages
                            if (strpos(url()->current(), 'edit/landingPage') !== false || 
                                strpos(url()->current(),'landingPageStats') !== false || 
                                strpos(url()->current(),'allLandingPages') !== false ||
                                strpos(url()->current(),'landingPage2Stats') !== false  ||
                                strpos(url()->current(),'landingPage3Stats') !== false  ||
                                strpos(url()->current(),'landingPage4Stats') !== false  ||
                                strpos(url()->current(),'landingPage5Stats') !== false  ||
                                strpos(url()->current(),'edit/landingPage/2') !== false  ||
                                strpos(url()->current(),'edit/landingPage/4') !== false  ||
                                strpos(url()->current(),'edit/landingPage/5') !== false  ||
                                strpos(url()->current(),'edit/landingPage/6') !== false  ||
                                strpos(url()->current(),'edit/landingPage/7') !== false  ||
                                strpos(url()->current(),'edit/landingPage/8') !== false  ||
                                strpos(url()->current(),'edit/landingPage/9') !== false  ||
                                strpos(url()->current(),'landingPage') !== false ||
                                strpos(url()->current(),'orders') !== false ) {
                                    echo '<span class="fa arrow"></span>';
                            }else{
                                echo '<i class="fa fa-angle-right" style="float:right;padding-top: 3px;margin-right: 15px;" aria-hidden="true"></i>';
                            }  
                            ?>
                            
                        </a>

                        <ul class="collapse" aria-expanded="true">
                            <?php 
                            $showRealestate=false;
                            $showEcommerce=false;
                            ?>
                            @role('admin', true)
                                <?php /**/ $showRealestate = true; /**/ ?>
                                <?php /**/ $showEcommerce = true; /**/ ?>
                            @endrole


                                @if(  in_array(1,$userIndustries) == true ||  $showRealestate == true  )
                                    <ul>
                                        <button class="accordion"> <a href="/edit/landingPage/1"><i class="fa fa-angle-right"></i> Home Evaluation 
                                        <?php // if this page is the allLandingPage link and is not on this page
                                            $actual_url = '';
                                            $actual_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                            if( strpos($actual_url,"/edit/landingPage") != -1 || strpos($actual_url,"allLandingPages") != -1){
                                                if(isset($difference1) && $difference1 != 0 && strpos($actual_url, "edit/landingPage/1") == Null && strpos($actual_url, "landingPageStats") == Null){
                                                    echo '<span style="position: absolute;right: -5px;" class="badge badge-pill badge-primary float-right calendar_badge menu_hide">'.$difference1.'</span>';
                                                }
                                            }
                                            
                                        ?> 
                                        </a> </button>
                                        
                                        <li class="secondaryLi dropdownPanel marginLeft2 statsTab <?php if (strpos(url()->current(), '/edit/landingPage/1') !== false || strpos(url()->current(), 'landingPageStats') !== false) {echo 'statsTabShow'; } ?>">
                                            <a href="{{ url('landingPageStats')}}">    
                                                <i class="fa fa-bar-chart" class="float: right;padding-top: 3px; margin-right: 15px;" aria-hidden="true"></i>
                                                Home Evaluation Stats 
                                                <?php
                                                    if(isset($difference1) && $difference1 != 0){
                                                        echo '<span style="position: absolute;right: -5px;" class="badge badge-pill badge-primary float-right calendar_badge menu_hide">'.$difference1.'</span>';
                                                    }
                                                ?> 
                                            </a>
                                        </li>

                                    </ul>
                                
                                    <ul>
                                        <button class="accordion"> <a href="/edit/landingPage/2"><i class="fa fa-angle-right"></i> Property Search 
                                        <?php // if this page is the allLandingPage link and is not on this page
                                            $actual_url = '';
                                            $actual_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                            if( strpos($actual_url,"/edit/landingPage") != -1 || strpos($actual_url,"allLandingPages") != -1){
                                                if(isset($difference2) && $difference2 != 0 && strpos($actual_url, "edit/landingPage/2") == Null && strpos($actual_url, "landingPage2Stats") == Null){
                                                    echo '<span style="position: absolute;right: -5px;" class="badge badge-pill badge-primary float-right calendar_badge menu_hide">'.$difference2.'</span>';
                                                }
                                            }
                                            
                                        ?> </a> </button>
                                         <li class="secondaryLi marginLeft2 statsTab <?php if (strpos(url()->current(), '/edit/landingPage/2') !== false || strpos(url()->current(), 'landingPage2Stats') !== false) {echo 'statsTabShow'; } ?>">
                                                    <a href="{{ url('landingPage2Stats')}}">    
                                                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                                        Property Search Stats

                                                        <?php
                                                        if(isset($difference2) && $difference2 != 0){
                                                            echo '<span style="position: absolute;right: -5px;" class="badge badge-pill badge-primary float-right calendar_badge menu_hide">'.$difference2.'</span>';
                                                        }
                                                        ?> 
                                                    </a>
                                        </li>
                                    </ul>

                                    <ul>
                                        <button class="accordion"> <a href="/edit/landingPage/3"><i class="fa fa-angle-right"></i> Open House LP 
                                        <?php // if this page is the allLandingPage link and is not on this page
                                            $actual_url = '';
                                            $actual_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                            if( strpos($actual_url,"/edit/landingPage") != -1 || strpos($actual_url,"allLandingPages") != -1){
                                                if(isset($difference3) && $difference3 != 0 && strpos($actual_url, "edit/landingPage/3") == Null && strpos($actual_url, "landingPage3Stats") == Null){
                                                    echo '<span style="position: absolute;right: -5px;" class="badge badge-pill badge-primary float-right calendar_badge menu_hide">'.$difference3.'</span>';
                                                }
                                            }
                                            
                                        ?></a> </button>
                                         <li class="secondaryLi marginLeft2 statsTab <?php if (strpos(url()->current(), '/edit/landingPage/3') !== false || strpos(url()->current(), 'landingPage3Stats') !== false) {echo 'statsTabShow'; } ?>">
                                                    <a href="{{ url('landingPage3Stats')}}">    
                                                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                                        Open House Stats
                                                        <?php
                                                            if(isset($difference3) && $difference3 != 0){
                                                                echo '<span style="position: absolute;right: -5px;" class="badge badge-pill badge-primary float-right calendar_badge menu_hide">'.$difference3.'</span>';
                                                            }
                                                        ?> 
                                                    </a>
                                        </li>
                                    </ul>
                                @endif

                                @if(  in_array(2,$userIndustries) == true ||  $showEcommerce == true)
                                
                                    <ul>
                                        <button class="accordion"> <a href="/edit/landingPage/4"><i class="fa fa-angle-right"></i> Countdown {!! $difference4 !!}
                                        <?php // if this page is the allLandingPage link and is not on this page
                                            $actual_url = '';
                                            $actual_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                            if( strpos($actual_url,"/edit/landingPage") != -1 || strpos($actual_url,"allLandingPages") != -1){
                                                if(isset($difference4) && $difference4 != 0 && strpos($actual_url, "edit/landingPage/4") == Null && strpos($actual_url, "landingPage4Stats") == Null){
                                                    echo '<span style="position: absolute;right: -5px;" class="badge badge-pill badge-primary float-right calendar_badge menu_hide">'.$difference4.'</span>';
                                                }
                                            }
                                            
                                        ?></a> </button>
                                        <li class="marginLeft2 statsTab <?php 
                                        if (strpos(url()->current(), '/edit/landingPage/4') !== false 
                                            ) {echo 'statsTabShow'; } ?>">
                                            <a href="{{ url('landingPage4Stats')}}">    
                                                <i class="fa fa-bar-chart" class="float: right;padding-top: 3px; margin-right: 15px;" aria-hidden="true"></i>
                                                Countdown Stats
                                                <?php
                                                            if(isset($difference4) && $difference4 != 0){
                                                                echo '<span style="position: absolute;right: -5px;" class="badge badge-pill badge-primary float-right calendar_badge menu_hide">'.$difference4.'</span>';
                                                            }
                                                ?> 
                                            </a>
                                        </li>

                                    </ul>

                                    <ul>
                                        <button class="accordion"> <a href="/edit/landingPage/5"><i class="fa fa-angle-right"></i> Product Coupon 

                                        <?php // if this page is the allLandingPage link and is not on this page
                                            $actual_url = '';
                                            $actual_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                            if( strpos($actual_url,"/edit/landingPage") != -1 || strpos($actual_url,"allLandingPages") != -1){
                                                if(isset($difference5) && $difference5 != 0 && strpos($actual_url, "edit/landingPage/5") == Null && strpos($actual_url, "landingPage5Stats") == Null){
                                                    echo '<span style="position: absolute;right: -5px;" class="badge badge-pill badge-primary float-right calendar_badge menu_hide">'.$difference5.'</span>';
                                                }
                                            }
                                            
                                        ?> </a> </button>
                                        <li class="secondaryLi dropdownPanel marginLeft2 statsTab <?php if (strpos(url()->current(), '/edit/landingPage/5') !== false /*|| strpos(url()->current(), 'landingPageStats') !== false*/) {echo 'statsTabShow'; } ?>">
                                            <a href="{{ url('landingPage5Stats')}}">    
                                                <i class="fa fa-bar-chart" class="float: right;padding-top: 3px; margin-right: 15px;" aria-hidden="true"></i>
                                                Product Coupon Stats
                                                <?php
                                                            if(isset($difference5) && $difference5 != 0){
                                                                echo '<span style="position: absolute;right: -5px;" class="badge badge-pill badge-primary float-right calendar_badge menu_hide">'.$difference5.'</span>';
                                                            }
                                                ?> 
                                            </a>
                                        </li>

                                    </ul>

                                    <ul>
                                        <button class="accordion"> <a href="/edit/landingPage/6"><i class="fa fa-angle-right"></i> Single Item Shopping Cart 
                                        <?php // if this page is the allLandingPage link and is not on this page
                                            $actual_url = '';
                                            $actual_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                            if( strpos($actual_url,"/edit/landingPage") != -1 || strpos($actual_url,"allLandingPages") != -1){
                                                if(isset($difference6) && $difference6 != 0 && strpos($actual_url, "edit/landingPage/6") == Null && strpos($actual_url, "landingPage6Stats") == Null){
                                                    echo '<span style="position: absolute;right: -5px;" class="badge badge-pill badge-primary float-right calendar_badge menu_hide">'.$difference6.'</span>';
                                                }
                                            }
                                            
                                        ?></a> </button>
                                        <li class="secondaryLi dropdownPanel marginLeft2 statsTab <?php if (strpos(url()->current(), '/edit/landingPage/6') !== false ) {echo 'statsTabShow'; } ?>">
                                            <a href="{{ url('orders')}}">    
                                                <i class="fa fa-bar-chart" class="float: right;padding-top: 3px; margin-right: 15px;" aria-hidden="true"></i>
                                                Orders
                                                <?php
                                                            if(isset($difference6) && $difference6 != 0){
                                                                echo '<span style="position: absolute;right: -5px;" class="badge badge-pill badge-primary float-right calendar_badge menu_hide">'.$difference6.'</span>';
                                                            }
                                                ?> 
                                            </a>
                                            
                                        </li>

                                    </ul>

                                    <ul>
                                        <button class="accordion"> <a href="/edit/landingPage/7"><i class="fa fa-angle-right"></i> Digital Download 
                                        <?php // if this page is the allLandingPage link and is not on this page
                                            $actual_url = '';
                                            $actual_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                            if( strpos($actual_url,"/edit/landingPage") != -1 || strpos($actual_url,"allLandingPages") != -1){
                                                if(isset($difference7) && $difference7 != 0 && strpos($actual_url, "edit/landingPage/7") == Null && strpos($actual_url, "landingPage7Stats") == Null){
                                                    echo '<span style="position: absolute;right: -5px;" class="badge badge-pill badge-primary float-right calendar_badge menu_hide">'.$difference7.'</span>';
                                                }
                                            }
                                            
                                        ?></a> </button>
                                        <li class="secondaryLi dropdownPanel marginLeft2 statsTab <?php if (strpos(url()->current(), '/edit/landingPage/7') !== false ) {echo 'statsTabShow'; } ?>">
                                            <a href="{{ url('landingPage7Stats')}}">    
                                                <i class="fa fa-bar-chart" class="float: right;padding-top: 3px; margin-right: 15px;" aria-hidden="true"></i>
                                                Digital Download Stats
                                                <?php
                                                            if(isset($difference7) && $difference7 != 0){
                                                                echo '<span style="position: absolute;right: -5px;" class="badge badge-pill badge-primary float-right calendar_badge menu_hide">'.$difference7.'</span>';
                                                            }
                                                ?> 
                                            </a>
                                            
                                        </li>

                                    </ul>
                                @endif

                                @if(  in_array(2,$userIndustries) == true ||  in_array(1,$userIndustries) == true)
                                    
                                    <ul>
                                        <button class="accordion"> <a href="/edit/landingPage/8"><i class="fa fa-angle-right"></i> Appointments 
                                        <?php // if this page is the allLandingPage link and is not on this page
                                            $actual_url = '';
                                            $actual_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                            if( strpos($actual_url,"/edit/landingPage") != -1 || strpos($actual_url,"allLandingPages") != -1){
                                                if(isset($difference8) && $difference8 != 0 && strpos($actual_url, "edit/landingPage/8") == Null && strpos($actual_url, "landingPage8Stats") == Null){
                                                    echo '<span style="position: absolute;right: -5px;" class="badge badge-pill badge-primary float-right calendar_badge menu_hide">'.$difference9.'</span>';
                                                }
                                            }
                                            
                                        ?></a> </button>
                                        <li class="secondaryLi dropdownPanel marginLeft2 statsTab <?php if (strpos(url()->current(), '/edit/landingPage/8') !== false ) {echo 'statsTabShow'; } ?>">
                                            <a href="{{ url('landingPage8Stats')}}">    
                                                <i class="fa fa-bar-chart" class="float: right;padding-top: 3px; margin-right: 15px;" aria-hidden="true"></i>
                                                Appointment Stats
                                                <?php
                                                            if(isset($difference8) && $difference8 != 0){
                                                                echo '<span style="position: absolute;right: -5px;" class="badge badge-pill badge-primary float-right calendar_badge menu_hide">'.$difference8.'</span>';
                                                            }
                                                ?> 
                                            </a>
                                            
                                        </li>

                                    </ul>

                                    <ul>
                                        <button class="accordion"> <a href="/edit/landingPage/9"><i class="fa fa-angle-right"></i> Join Email List 
                                        <?php // if this page is the allLandingPage link and is not on this page
                                            $actual_url = '';
                                            $actual_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                            if( strpos($actual_url,"/edit/landingPage") != -1 || strpos($actual_url,"allLandingPages") != -1){
                                                if(isset($difference9) && $difference9 != 0 && strpos($actual_url, "edit/landingPage/9") == Null && strpos($actual_url, "landingPage9Stats") == Null){
                                                    echo '<span style="position: absolute;right: -5px;" class="badge badge-pill badge-primary float-right calendar_badge menu_hide">'.$difference8.'</span>';
                                                }
                                            }
                                            
                                        ?></a> </button>
                                        <li class="secondaryLi dropdownPanel marginLeft2 statsTab <?php if (strpos(url()->current(), '/edit/landingPage/9') !== false ) {echo 'statsTabShow'; } ?>">
                                            <a href="{{ url('landingPage9Stats')}}">    
                                                <i class="fa fa-bar-chart" class="float: right;padding-top: 3px; margin-right: 15px;" aria-hidden="true"></i>
                                                Email List Stats
                                                <?php
                                                            if(isset($difference9) && $difference9 != 0){
                                                                echo '<span style="position: absolute;right: -5px;" class="badge badge-pill badge-primary float-right calendar_badge menu_hide">'.$difference9.'</span>';
                                                            }
                                                ?> 
                                            </a>
                                            
                                        </li>

                                    </ul>

                                @endif
                            
                        </ul>
                        
                            
                    </li>


                    <script>
                    
                    var acc = document.getElementsByClassName("accordion");
                    var i;

                    for (i = 0; i < acc.length; i++) {
                        acc[i].onclick = function(){
                            this.classList.toggle("active");
                            var panel = this.nextElementSibling;
                            if (panel.style.display === "block") {
                                panel.style.display = "none";
                            } else {
                                panel.style.display = "block";
                            }
                        }
                    }

                    $(document).ready(function(){

                        var thisUrl = window.location.href;
                        
                        if(thisUrl.indexOf('home') != -1 ){
                            $('li:contains("Dashboard")').addClass("active");
                            
                        }

                        if(thisUrl.indexOf('edit/landing') != -1 
                            || thisUrl.indexOf('allLandingPages') != -1 
                            || thisUrl.indexOf('Stats') != -1 
                            || thisUrl.indexOf('orders') != -1){
                            $('li:contains("Your Landing Pages")').addClass("active");
                            $('li:contains("Your Landing Pages")').children('ul:first').removeClass("collapse");
                            $('li:contains("Your Landing Pages")').next('li.secondaryLi').removeClass('secondaryLi');
                            
                        }

                        if(thisUrl.indexOf('edit/landingPage/1') != -1){
                            
                            $('ul button:contains("Home Evaluation")').addClass('active');
                            $('ul button:contains("Home Evaluation")').next('li.secondaryLi').css('display','block !important');
                            $('ul button:contains("Home Evaluation")').next('li.secondaryLi').removeClass('secondaryLi');
                            
                        }


                        if(thisUrl.indexOf('edit/landingPage/2') != -1){
                                                     
                            $('ul button:contains("Property Search")').addClass('active');                            
                            $('ul button:contains("Property Search")').next('li.secondaryLi').css('display','block !important');
                            $('ul button:contains("Property Search")').next('li.secondaryLi').removeClass('secondaryLi');
                            
                        }

                        if(thisUrl.indexOf('edit/landingPage/3') != -1){
                            $('ul button:contains("Open House")').addClass('active');
                            $('ul button:contains("Open House")').next('li.secondaryLi').css('display','block !important');
                            $('ul button:contains("Open House")').next('li.secondaryLi').removeClass('secondaryLi');
                            
                        }


                        //Ecommerce
                        if(thisUrl.indexOf('edit/landingPage/4') != -1){    
                            $('ul button:contains("Countdown")').addClass('active');
                            $('ul button:contains("Countdown")').next('li.secondaryLi').css('display','block !important');
                            $('ul button:contains("Countdown")').next('li.secondaryLi').removeClass('secondaryLi');
                        }

                        if(thisUrl.indexOf('edit/landingPage/5') != -1){
                            
                            $('ul button:contains("Coupon")').addClass('active');
                            $('ul button:contains("Coupon")').next('li.secondaryLi').css('display','block !important');
                            $('ul button:contains("Coupon")').next('li.secondaryLi').removeClass('secondaryLi');
                        }

                        if(thisUrl.indexOf('edit/landingPage/6') != -1){
                            
                            $('ul button:contains("Single Item Shopping Cart")').addClass('active');
                            $('ul button:contains("Single Item Shopping Cart")').next('li.secondaryLi').css('display','block !important');
                            $('ul button:contains("Single Item Shopping Cart")').next('li.secondaryLi').removeClass('secondaryLi');
                        }

                        if(thisUrl.indexOf('edit/landingPage/7') != -1){
                            
                            $('ul button:contains("Digital Download")').addClass('active');
                            $('ul button:contains("Digital Download")').next('li.secondaryLi').css('display','block !important');
                            $('ul button:contains("Digital Download")').next('li.secondaryLi').removeClass('secondaryLi');
                        }

                        if(thisUrl.indexOf('edit/landingPage/8') != -1){
                            
                            $('ul button:contains("Appointments")').addClass('active');
                            $('ul button:contains("Appointments")').next('li.secondaryLi').css('display','block !important');
                            $('ul button:contains("Appointments")').next('li.secondaryLi').removeClass('secondaryLi');
                        }

                        if(thisUrl.indexOf('edit/landingPage/9') != -1){
                            
                            $('ul button:contains("Join Email List")').addClass('active');
                            $('ul button:contains("Join Email List")').next('li.secondaryLi').css('display','block !important');
                            $('ul button:contains("Join Email List")').next('li.secondaryLi').removeClass('secondaryLi');
                        }

                        /* Stats pages */
                        if(thisUrl.indexOf('landingPageStats') != -1){
                            
                            $('ul button:contains("Home Evaluation")').addClass('active');
                            $('ul button:contains("Home Evaluation")').next('li.secondaryLi').addClass('active');
                            $('ul button:contains("Home Evaluation")').next('li.secondaryLi').css('display','block !important');
                            $('ul button:contains("Home Evaluation")').next('li.secondaryLi').removeClass('secondaryLi');
                        }

                        if(thisUrl.indexOf('landingPage2Stats') != -1){
                            
                            $('ul button:contains("Property Search")').addClass('active');
                            $('ul button:contains("Property Search")').next('li.secondaryLi').addClass('active');
                            $('ul button:contains("Property Search")').next('li.secondaryLi').css('display','block !important');
                            $('ul button:contains("Property Search")').next('li.secondaryLi').removeClass('secondaryLi');
                        }

                        if(thisUrl.indexOf('landingPage3Stats') != -1){
                            
                            $('ul button:contains("Open House LP")').addClass('active');
                            $('ul button:contains("Open House LP")').next('li.secondaryLi').addClass('active');
                            $('ul button:contains("Open House LP")').next('li.secondaryLi').css('display','block !important');
                            $('ul button:contains("Open House LP")').next('li.secondaryLi').removeClass('secondaryLi');
                        }

                        // stats
                        if(thisUrl.indexOf('landingPage4Stats') != -1){
                            $('ul button:contains("Countdown")').addClass('active');
                            $('ul button:contains("Countdown")').next('li.secondaryLi').addClass('active');
                            $('ul button:contains("Countdown")').next('li.secondaryLi').css('display','block !important');
                            $('ul button:contains("Countdown")').next('li.secondaryLi').removeClass('secondaryLi');

                            $('li:contains("Countdown Stats")').addClass("active");
                            $('li:contains("Countdown Stats")').addClass("statsTabShow");
                            
                        }
                        if(thisUrl.indexOf('landingPage5Stats') != -1){
                            
                            $('ul button:contains("Product Coupon")').addClass('active');
                            $('ul button:contains("Product Coupon")').next('li.secondaryLi').addClass('active');
                            $('ul button:contains("Product Coupon")').next('li.secondaryLi').css('display','block !important');
                            $('ul button:contains("Product Coupon")').next('li.secondaryLi').removeClass('secondaryLi');
                            
                            $('li:contains("Product Coupon Stats")').addClass("statsTabShow");
                        }

                        if(thisUrl.indexOf('landingPage7Stats') != -1){
                            
                            $('ul button:contains("Digital Download")').addClass('active');
                            $('ul button:contains("Digital Download")').next('li.secondaryLi').addClass('active');
                            $('ul button:contains("Digital Download")').next('li.secondaryLi').css('display','block !important');
                            $('ul button:contains("Digital Download")').next('li.secondaryLi').removeClass('secondaryLi');
                            
                            $('li:contains("Digital Download Stats")').addClass("statsTabShow");
                        }

                        if(thisUrl.indexOf('landingPage8Stats') != -1){
                            
                            $('ul button:contains("Appointments")').addClass('active');
                            $('ul button:contains("Appointments")').next('li.secondaryLi').addClass('active');
                            $('ul button:contains("Appointments")').next('li.secondaryLi').css('display','block !important');
                            $('ul button:contains("Appointments")').next('li.secondaryLi').removeClass('secondaryLi');
                            

                            $('li:contains("Appointment Stats")').addClass("statsTabShow");
                        }

                        if(thisUrl.indexOf('landingPage9Stats') != -1){
                            
                            $('ul button:contains("Join Email List")').addClass('active');
                            $('ul button:contains("Join Email List")').next('li.secondaryLi').addClass('active');
                            $('ul button:contains("Join Email List")').next('li.secondaryLi').css('display','block !important');
                            $('ul button:contains("Join Email List")').next('li.secondaryLi').removeClass('secondaryLi');
                            
                            $('li:contains("Email List Stats")').addClass("statsTabShow");
                        }

                         //Shopping Cart

                        if(thisUrl.indexOf('orders') != -1){
                            
                            $('ul button:contains("Single Item Shopping Cart")').addClass('active');
                            $('ul button:contains("Single Item Shopping Cart")').next('li.secondaryLi').addClass('active');
                            $('ul button:contains("Single Item Shopping Cart")').next('li.secondaryLi').css('display','block !important');
                            $('ul button:contains("Single Item Shopping Cart")').next('li.secondaryLi').removeClass('secondaryLi');


                            $('li:contains("Orders")').addClass("active");
                            $('li:contains("Orders")').addClass("statsTabShow");
                        }

                        if(thisUrl.indexOf('profile') != -1 || thisUrl.indexOf('branding') != -1 ){
                            $('a:contains("Branding")').parent('li').addClass('active');
                        }


                    });
                    </script>

                </ul>


                <li>
                    <a href="{{ url('/branding')}}">
                            
                        <span class="link-title">&nbsp; Branding </span>
                            
                    </a>
                </li>

            
        </ul>
<!-- end menu -->