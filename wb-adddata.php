<?php defined('ABSPATH') OR exit('No direct script access allowed');?>

<?php include_once('wb-header.php');?>

<h2><?php echo($this->db->get_module_by_id($_GET['id'])['module_FriendlyName']);?> · 添加数据</h2>
<form id="dataForm" action="/index.php/Action?do=AddData" method="POST" class="uk-form-horizontal uk-margin-large">
    <div id="alertBox" class="uk-alert-warning" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p id="alertLog">表单中有必填字段为空，请检查。</p>
    </div>
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
                    <input name="<?php echo($value[0]);?>" class="uk-input uk-form-width-large" id="form-horizontal-text" type="text" required>

                <?php }else if($value[2] == 'textarea'){?>
                    <textarea name="<?php echo($value[0]);?>" class="uk-textarea" rows="5" required></textarea>

                <?php }else if($value[2] == 'number'){?>
                    <input name="<?php echo($value[0]);?>" class="uk-input uk-form-width-large" id="form-horizontal-text" type="number" required>

                <?php }else if($value[2] == 'boolean'){?>
                    <label><input class="uk-radio" type="radio" name="<?php echo($value[0]);?>" value="<?php echo($value[3][0]);?>" checked required> <?php echo($value[3][0]);?></label>
                    <label><input class="uk-radio" type="radio" name="<?php echo($value[0]);?>" value="<?php echo($value[3][1]);?>" required> <?php echo($value[3][1]);?></label>

                <?php }else if($value[2] == 'select'){?>
                    <?php foreach($value[3] as $radioKey => $radioValue){?>
                        <label><input class="uk-radio" type="radio" name="<?php echo($value[0]);?>" <?php if($radioKey == 0){echo('checked');}?> required> <?php echo($radioValue);?></label><br>
                    <?php }?>

                <?php }else if($value[2] == 'checkbox'){?>
                    <?php foreach($value[3] as $radioKey => $radioValue){?>
                        <label><input class="uk-checkbox" type="checkbox" name="<?php echo($value[0] . '[]');?>" value="<?php echo($radioValue);?>" <?php if($radioKey == 0){echo('checked');}?> required> <?php echo($radioValue);?></label><br>
                    <?php }?>

                <?php }else if($value[2] == 'upload'){?>
                    <div uk-form-custom="target: true" class="uk-form-custom uk-first-column">
                        <input type="file">
                        <input class="uk-input uk-form-width-medium" type="text" placeholder="选择文件" disabled="" required>
                     </div>
                    <button class="uk-button uk-button-default">上传</button>

                <?php }?>
            </div>
        </div>

    <?php } }?>

    <div class="uk-margin">
        <button type="submit" class="uk-button uk-button-primary uk-align-right">添加数据</button>
    </div>
</form>

<script>
    $('#alertBox').hide();

    //Check the form.
    $().ready(function() {
        $("#dataForm").validate({
            submitHandler:function(form){ 
                form.submit();
            }
        });
    });

    $.validator.setDefaults({
        errorPlacement: function(error, element) {  
            $('#alertBox').show();
        }
    })
</script>

<?php include_once('wb-footer.php');?>