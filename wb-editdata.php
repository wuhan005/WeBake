<?php defined('ABSPATH') OR exit('No direct script access allowed');?>

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

    function isCheck($fieldValue, $dataValue){
        if(is_array($dataValue)){
            if(in_array($fieldValue, $dataValue)){
                echo('checked');
            }
        }else{
            if($fieldValue == $dataValue){
                echo('checked');
            }
        }
    }
    ?>

    <?php 
    foreach($key as $index => $value){
        if($index != 0){?>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text"><?php echo($value[1]);?></label>
            <div class="uk-form-controls">
                <?php if($value[2] == 'string'){?>
                    <input name="<?php echo($value[0]);?>" class="uk-input uk-form-width-large" id="form-horizontal-text" type="text" value="<?php echo($data[$value[0]]); ?>">

                <?php }else if($value[2] == 'textarea'){?>
                    <textarea name="<?php echo($value[0]);?>" class="uk-textarea" rows="5" value="<?php echo($data[$value[0]]); ?>"></textarea>

                <?php }else if($value[2] == 'number'){?>
                    <input name="<?php echo($value[0]);?>" class="uk-input uk-form-width-large" id="form-horizontal-text" type="number"  value="<?php echo($data[$value[0]]); ?>">

                <?php }else if($value[2] == 'boolean'){?>
                    <label><input class="uk-radio" type="radio" name="<?php echo($value[0]);?>" value="<?php echo($value[3][0]);?>" <?php isCheck($value[3][0], $data[$value[0]]);?>> <?php echo($value[3][0]);?></label>
                    <label><input class="uk-radio" type="radio" name="<?php echo($value[0]);?>" value="<?php echo($value[3][1]);?>" <?php isCheck($value[3][1], $data[$value[0]]);?>> <?php echo($value[3][1]);?></label>

                <?php }else if($value[2] == 'select'){?>
                    <?php foreach($value[3] as $radioKey => $radioValue){?>
                        <label>
                            <input
                                class="uk-radio"
                                type="radio"
                                name="<?php echo($value[0]);?>"
                                value="<?php echo($radioValue); ?>"
                                <?php
                                //Check tbe box is select or not.
                                //The field maybe added later, and the data wasn't existed.
                                if(isset($data[$value[0]])){
                                    isCheck($radioValue, $data[$value[0]]);
                                }
                                ?>
                            >
                            <?php echo($radioValue);?>
                        </label>
                        <br>
                    <?php }?>

                <?php }else if($value[2] == 'checkbox'){?>
                    <?php foreach($value[3] as $radioKey => $radioValue){?>
                        <label>
                            <input
                                class="uk-checkbox"
                                type="checkbox"
                                name="<?php echo($value[0] . '[]');?>"
                                value="<?php echo($radioValue);?>"
                                <?php 
                                //Check tbe box is select or not.
                                //The field maybe added later, and the data wasn't existed.
                                if(isset($data[$value[0]])){
                                    isCheck($radioValue, $data[$value[0]]);
                                }
                                ?>
                            >
                                <?php echo($radioValue);?>
                        </label>
                        <br>
                    <?php }?>

                <?php }else if($value[2] == 'upload'){?>
                    <div uk-form-custom="target: true" class="uk-form-custom uk-first-column">
                        <input type="file">
                        <input class="uk-input uk-form-width-medium" type="text" placeholder="选择文件" disabled="">
                     </div>
                    <button class="uk-button uk-button-default">上传</button>

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