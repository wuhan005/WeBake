<?php include_once('wb-header.php');?>

<h2><?php echo($this->db->get_module_by_id($_GET['id'])['module_FriendlyName']);?> · 添加数据</h2>
<form action="/index.php/Action?do=AddData" method="POST" class="uk-form-horizontal uk-margin-large">
    <input name="mid" value="<?php echo($_GET['id']);?>" type="hidden">

    <?php 
    $key = $this->db->get_module_by_id($_GET['id'])['module_Key'];
    $key = json_decode($key, true);

    foreach($key as $index => $value){
        if($index != 0){?>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text"><?php echo($value[1]);?></label>
            <div class="uk-form-controls">
                <?php if($value[2] == 'string'){?>
                    <input name="<?php echo($value[0]);?>" class="uk-input uk-form-width-large" id="form-horizontal-text" type="text">
                <?php }else if($value[2] == 'number'){?>
                    <input name="<?php echo($value[0]);?>" class="uk-input uk-form-width-large" id="form-horizontal-text" type="number">
                <?php }else if($value[2] == 'boolean'){?>
                    <input name="<?php echo($value[0]);?>" class="uk-input uk-form-width-large" id="form-horizontal-text" type="number">
                <?php }?>
            </div>
        </div>

    <?php } }?>

    <div class="uk-margin">
        <button type="submit" class="uk-button uk-button-primary uk-align-right">添加数据</button>
    </div>
</form>

<?php include_once('wb-footer.php');?>