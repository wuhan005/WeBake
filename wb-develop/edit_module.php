<?php defined('ABSPATH') OR exit('No direct script access allowed');?>

<div class="uk-container uk-container-small">
    <h2>修改模块 · <?php echo($this->db->get_module_by_id($_GET['id'])['module_Name']);?></h2>
    <form action="/wb-develop/action.php?do=EditModule" method="POST" class="uk-form-horizontal uk-margin-large">

    <?php 
    function isSelect($type, $nowSelect){
        if($type == $nowSelect){
            echo('selected = "selected"');
        }
    }
    
    $module = $this->db->get_module_by_id($_GET['id']);
    ?>

        <input name="mid" type="hidden" value="<?php echo($_GET['id']);?>">
        <input id="row" name="row" type="hidden">
        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">模块名</label>
            <div class="uk-form-controls">
                <input name="name" class="uk-input" id="form-horizontal-text" type="text" value="<?php echo($module['module_Name']);?>">
            </div>
        </div>

         <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">显示名称</label>
            <div class="uk-form-controls">
                <input name="friendlyname" class="uk-input" id="form-horizontal-text" type="text" value="<?php echo($module['module_FriendlyName']);?>">
            </div>
        </div>

        <div class="uk-margin">
        <label class="uk-form-label" for="form-horizontal-text">模块字段</label>
            <button type="button" id="AddNewModule" onclick="javascript:;" class="uk-button uk-button-primary uk-align-right">添加字段</button>
            <table id="KeyTable" class="uk-table uk-table-striped">
                <thead>
                    <tr>
                        <th>字段名</th>
                        <th>显示名称</th>
                        <th>字段类型</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input name="field_1_1" class="uk-input uk-form-width-medium" type="text" value="<?php echo(json_decode($module['module_Key'], true)[0][0]);?>"></td>
                        <td>编号</td>
                        <td>
                            数字(number)
                        </td>
                    </tr>
                    <?php foreach(json_decode($module['module_Key'], true) as $key => $value){
                        if($key != 0){
                    ?>
                        <tr>
                            <td><input name="field_<?php echo($key + 1)?>_1" class="uk-input uk-form-width-medium" type="text" value="<?php echo($value[0]);?>"></td>
                            <td><input name="field_<?php echo($key + 1)?>_2" class="uk-input uk-form-width-medium" type="text" value="<?php echo($value[1]);?>"></td>
                            <td>
                                <select name="field_<?php echo($key + 1)?>_3" class="uk-select" id="form-stacked-select">
                                    <option value="string" <?php isSelect('string', $value[2]);?>>字符串(string)</option>
                                    <option value="number" <?php isSelect('number', $value[2]);?>>数字(number)</option>
                                    <option value="boolean" <?php isSelect('boolean', $value[2]);?>>布尔(boolean)</option>
                                </select>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="uk-margin">
                <button type="submit" class="uk-button uk-button-primary uk-align-right">修改</button>
        </div>
    </form>

</div>


<script>
    var row = <?php echo(count( json_decode($module['module_Key'], true) )); ?>;
    $('#row').val(row);
    $('#AddNewModule').click(function(){
        row++;
        var newRow = '<tr><td><input name="field_' + row + '_1" class="uk-input uk-form-width-medium" type="text"></td><td><input name="field_' + row +'_2" class="uk-input uk-form-width-medium" type="text"></td><td><select name="field_' + row + '_3" class="uk-select" id="form-stacked-select"><option value="string">字符串(string)</option><option value="number">数字(number)</option><option value="boolean">布尔(boolean)</option></select></td></tr>';
        $('#KeyTable').append(newRow);
        $('#row').val(row);
    })
</script>