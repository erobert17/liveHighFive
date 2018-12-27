<!DOCTYPE html>

<html lang="<?php echo e(config('app.locale')); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title>GrowYourLeads.com</title>
        <meta name="Realestate sales" content="ecommerce solutions">
        <meta name="Growyourleads.com" content="GrowYourLeads">
        <link rel="shortcut icon" href="http://growyourleads.com/favicon.ico">

        
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        
        <?php echo $__env->yieldContent('template_linked_fonts'); ?>

        
        <!--<link href="<?php echo e(mix('/css/app.css')); ?>" rel="stylesheet">-->

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        
        
        <link rel="stylesheet" media="all" type="text/css" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" media="all" type="text/css" href="<?php echo e(asset('css/jquery-ui-timepicker-addon.css')); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/jquery.datetimepicker.css')); ?>">

        <script type="text/javascript" src="<?php echo e(asset('js/jquery-te-1.4.0.min.js')); ?>"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/jquery-te-1.4.0.css')); ?>">

        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('/css/bootstrap-3-vert-offset-shim.css')); ?>">
        <link rel="shortcut icon" href="<?php echo e(asset('assets/img/logo1.ico')); ?>"/>
        
        <link type="text/css" rel="stylesheet" href="<?php echo e(asset('assets/css/components.css')); ?>"/>
        <link type="text/css" rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/main.css')); ?>">

        
        <!-- copy button-->
        <script type="text/javascript" src="<?php echo e(asset('assets/js/clipboard.min.js')); ?>"></script>
        
        <?php echo $__env->yieldContent('template_linked_css'); ?>

        <style type="text/css">
            <?php echo $__env->yieldContent('template_fastload_css'); ?>

            <?php if(Auth::User() && (Auth::User()->profile) && (Auth::User()->profile->avatar_status == 0)): ?>
                .user-avatar-nav {
                    background: url(<?php echo e(Gravatar::get(Auth::user()->email)); ?>) 50% 50% no-repeat;
                    background-size: auto 100%;
                    width:30px !important;
                    height:30px !important;
                }
            <?php endif; ?>

        </style>

        
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>;
        </script>

        

        <?php echo $__env->yieldContent('head'); ?>

    </head>

    <body>
        <div id="app">

            <div class="container-fluid">

                <?php echo $__env->make('partials.form-status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            </div>

            <?php if(Auth::check()): ?>
              <?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php else: ?>
              <!-- use this for non logged in visitors page-->
              <?php echo $__env->yieldContent('content'); ?>
            <?php endif; ?>
            

        </div>

        
        
        <script src="<?php echo e(asset('js/appExtra.js')); ?>"></script>
        

        <!-- Datetime picker Must come after appExtra.js-->
        <script type="text/javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/jquery-ui-timepicker-addon.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/jquery-ui-timepicker-addon-i18n.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/jquery-ui-sliderAccess.js')); ?>"></script>
  
    

        <?php echo $__env->yieldContent('footer_scripts'); ?>

    </body>


</html>
