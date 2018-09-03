<?php defined('ABSPATH') OR exit('No direct script access allowed');?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo($this->db->get_single_option('project_name')); ?> - WeBake</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/static/css/uikit.min.css" />
        <script src="/static/js/uikit.min.js"></script>
        <script src="/static/js/uikit-icons.min.js"></script>
        <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
    

<!-- Backgroung -->
<div class="uk-background-muted uk-background-cover uk-background-norepeat uk-height-large uk-panel" style="background-image: url(/static/images/background.PNG);" uk-height-viewport="offset-bottom: 0">
<!-- Nav bar -->
<nav class="uk-navbar-container tm-navbar-container uk-navbar-transparent uk-sticky uk-sticky-fixed uk-container-expand uk-light" uk-navbar>
    <div class="uk-navbar-left">
        <a class="uk-navbar-item uk-logo" href="#">WeBake · <?php echo($this->db->get_single_option('project_name'));?></a>
        <ul class="uk-navbar-nav">
            <li>
                <a href="#">
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- Login form -->
<div class="uk-width-1-1">
    <div class="uk-margin-large-right uk-position-center-right uk-card uk-card-default uk-card-body uk-width-medium">
        <h3>登录</h3>

        <!-- Alert -->
        <?php if(isset($_GET['error'])){?>
            <div class="uk-alert-danger" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p>登录失败，请重试。</p>
            </div>
        <?php }?>

        <?php if(isset($_GET['logout'])){?>
            <div class="uk-alert-warning" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p>您已登出。</p>
            </div>
        <?php }?>

        <!-- Form -->
        <form action="/index.php/Action?do=Login" method="POST">
            <div class="uk-margin">
                <div class="uk-inline">
                    <span class="uk-form-icon" uk-icon="icon: user"></span>
                    <input name="name" class="uk-input" type="text">
                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-inline">
                    <span class="uk-form-icon" uk-icon="icon: lock"></span>
                    <input name="password" class="uk-input" type="password">
                </div>
            </div>
            <button class="uk-button uk-button-primary uk-margin-small-bottom uk-align-center">登录</button>
        </form>
    </div>
</div>

    <!-- Footer -->
    <div class="uk-margin-small-bottom uk-position-bottom-center uk-light" style="color:#fff;">
            <span>
                <?php echo($this->db->get_single_option('copyright')); ?>
            </span>
            /
            <span>Made with 
                <svg style="width: 1em; height: 1em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1919"><path d="M859.8 191.2c-80.8-84.2-212-84.2-292.8 0L512 248.2l-55-57.2c-81-84.2-212-84.2-292.8 0-91 94.6-91 248.2 0 342.8L512 896l347.8-362C950.8 439.4 950.8 285.8 859.8 191.2z" p-id="1920" fill="#d81e06" data-spm-anchor-id="a313x.7781069.0.i0"></path></svg>
                by John Wu.
            </span>
    </div>

</div>



</body>
</html>