<?php include_once('wb-header.php');?>

<h2>修改数据</h2>

<form action="/index.php/Action?do=EditData" method="POST" class="uk-form-horizontal uk-margin-large">
    <input name="id" value="<?php echo($_GET['id']);?>" type="hidden">
    <input name="mid" value="<?php echo($this->db->get_data_by_id($_GET['id'])['data_Module']);?>" type="hidden">

    <?php
    //Get the data.
    $data = $this->db->get_data_by_id($_GET['id'])['data_Content'];
    $data = json_decode($data, true);

    //Get the data's module. Used to display the friendly name.
    $key = $this->db->get_module_by_id($this->db->get_data_by_id($_GET['id'])['data_Module'])['module_Key'];
    $key = json_decode($key, true);
    ?>

    <?php 
    foreach($key as $index => $value){
        if($index != 0){?>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text"><?php echo($value[1]);?></label>
            <div class="uk-form-controls">
                <?php if($value[2] == 'string'){?>
                    <input name="<?php echo($value[0]);?>" class="uk-input uk-form-width-large" id="form-horizontal-text" type="text" value="<?php echo($data[$value[0]]); ?>">
                <?php }else if($value[2] == 'number'){?>
                    <input name="<?php echo($value[0]);?>" class="uk-input uk-form-width-large" id="form-horizontal-text" type="number" value="<?php echo($data[$value[0]]); ?>">
                <?php }else if($value[2] == 'boolean'){?>
                    <input name="<?php echo($value[0]);?>" class="uk-input uk-form-width-large" id="form-horizontal-text" type="number" value="<?php echo($data[$value[0]]); ?>">
                <?php }?>
            </div>
        </div>

    <?php } }?>

    <div class="uk-margin">
        <a href="/index.php/Module?id=<?php echo($this->db->get_data_by_id($_GET['id'])['data_Module']);?>" class="uk-button uk-button-default uk-align-right">取消</a>
        <button type="submit" class="uk-button uk-button-primary uk-align-right">修改数据</button>
    </div>
</form>

<?php include_once('wb-footer.php');?>