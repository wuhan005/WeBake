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

<div class="uk-flex">
    <div class="uk-card uk-width-1-5">

<!-- Nav -->
    <div class="uk-card uk-card-body">
    <h3><?php echo($this->db->get_single_option('project_name')); ?></h3>
    <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
        <li class="uk-active"><a href="#"><span class="uk-margin-small-right" uk-icon="icon: home"></span> 主页</a></li>
        <li class="uk-nav-header">项目</li>
        <?php foreach($this->db->get_all_module() as $key => $value){?>
            <li><a href="/index.php/Module?id=<?php echo($value['module_ID']); ?>"><?php echo($value['module_FriendlyName']);?></a></li>

        <?php }?>
        <li class="uk-nav-divider"></li>
        <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: unlock"></span> 登出</a></li>
    </ul>
    </div>

    </div>
<div class="uk-card uk-card-body uk-margin-left uk-width-4-5">