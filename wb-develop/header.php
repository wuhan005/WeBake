<?php defined('ABSPATH') OR exit('No direct script access allowed');?>

<!DOCTYPE html>
<html>
    <head>
        <title>WeBake - 开发者模式</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/static/css/uikit.min.css" />
        <script src="/static/js/uikit.min.js"></script>
        <script src="/static/js/uikit-icons.min.js"></script>
        <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
        <script src="/static/js/jquery.validate.min.js"></script>
        <script src="/static/js/messages_zh.min.js"></script>
    </head>
    <body>
    <div class="uk-container uk-container-large">
        <!-- Nav Bar-->
        <nav class="uk-navbar">
            <ul class="uk-navbar-nav">
                <li class="<?php if($this->nowPage == 'Index'){echo('uk-active');}?>"><a href="/wb-develop/index.php">仪表盘</a></li>
                <li class="<?php if($this->nowPage == 'Module'){echo('uk-active');}?>"><a href="/wb-develop/index.php/Module">模块</a></li>
                <li class="<?php if($this->nowPage == 'API'){echo('uk-active');}?>"><a href="/wb-develop/index.php/API">API 接口</a></li>
                <li class="<?php if($this->nowPage == 'Client'){echo('uk-active');}?>"><a href="/wb-develop/index.php/Client">管理后台设置</a></li>
                <li class="<?php if($this->nowPage == 'Setting'){echo('uk-active');}?>"><a href="/wb-develop/index.php/Setting">项目设置</a></li>
                <li><a href="/index.php/Dashboard">客户后台</a></li>
                <li><a href="/index.php/Action?do=Logout">登出</a></li>
            </ul>
        </nav>
    </div>
    
<!-- Main Content Begin -->