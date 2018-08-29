<?php include_once('wb-header.php');?>

<div class="uk-card uk-card-body uk-width-1-5@s">
    <h3><?php echo($this->db->get_single_option('project_name')); ?></h3>
    <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
        <li class="uk-active"><a href="#"><span class="uk-margin-small-right" uk-icon="icon: home"></span> 主页</a></li>
        <li class="uk-nav-header">项目</li>
        <?php foreach($this->db->get_all_module() as $key => $value){?>
            <li><a href="/index.php/Module?id=<?php echo($value['module_ID']); ?>"><?php echo($value['module_Name']);?></a></li>

        <?php }?>
        <li class="uk-nav-divider"></li>
        <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: unlock"></span> 登出</a></li>
    </ul>
</div>

<?php include_once('wb-footer.php');?>