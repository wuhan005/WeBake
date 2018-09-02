<?php
    $error['database_error'] = '数据库连接失败！请检查配置文件！';

?>

<link rel="stylesheet" href="/static/css/uikit.min.css" />
<script src="/static/js/uikit.min.js"></script>
<div class="uk-container">
    <div class="uk-alert-danger uk-margin-top" uk-alert>
        <h2>发生错误! </h2>

        <?php if(isset($_GET['t']) AND isset($error[$_GET['t']])){?>
            <p><?php echo($error[$_GET['t']]);?></p>
        <?php }?>
        
    </div>
</div>

    <?php die();?>