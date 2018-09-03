<?php defined('ABSPATH') OR exit('No direct script access allowed');?>

<div class="uk-container uk-container-small">
    <h2>添加新的模块</h2>

    <form action="/wb-develop/action.php?do=AddModule" method="POST" class="uk-form-horizontal uk-margin-large">

        <input id="row" name="row" type="hidden">
        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">模块名</label>
            <div class="uk-form-controls">
                <input name="name" class="uk-input" id="form-horizontal-text" type="text">
            </div>
        </div>

         <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">显示名称</label>
            <div class="uk-form-controls">
                <input name="friendlyname" class="uk-input" id="form-horizontal-text" type="text">
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
                        <th>选项(使用 , 分割)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="field_1">
                        <td><input name="field_1_1" class="uk-input uk-form-width-medium" type="text"></td>
                        <td>编号</td>
                        <td>
                            数字(number)
                        </td>
                        <td>
                            /
                        </td>
                    </tr>
                    <tr id="field_2">
                        <td><input name="field_2_1" class="uk-input uk-form-width-medium" type="text"></td>
                        <td><input name="field_2_2" class="uk-input uk-form-width-medium" type="text"></td>
                        <td>
                            <select id="field_select" name="field_2_3" onChange="onTypeChange(2)" class="uk-select" id="form-stacked-select">
                                <option value="string">字符串 (string)</option>
                                <option value="textarea">长文本 (textarea)</option>
                                <option value="number">数字 (number)</option>
                                <option value="boolean">布尔 (boolean)</option>
                                <option value="select">单选 (select)</option>
                                <option value="checkbox">多选 (checkbox)</option>
                                <option value="upload">上传 (upload)</option>
                            </select>
                        </td>
                        <td>
                            <input id="field_2_4" name="field_2_4" class="uk-input uk-form-width-medium" type="text" style="display:none;">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="uk-margin">
                <button type="submit" class="uk-button uk-button-primary uk-align-right">添加</button>
        </div>

    </form>
</div>

<script>
    var row = 2;

    $('#row').val(row);     //Set the row hidden input.
    
    $('#AddNewModule').click(function(){
        row++;

        //Clone the field, set it own ID.
        var newRow = $('#field_2').clone();
        $(newRow).attr('id','field_' + row);

        //Set the field new name.
        $(newRow).find("input[name='field_2_1']").attr('name', 'field_' + row + '_1');
        $(newRow).find("input[name='field_2_2']").attr('name', 'field_' + row + '_2');
        $(newRow).find("select[name='field_2_3']").attr('name', 'field_' + row + '_3');
        $(newRow).find("input[name='field_2_4']").attr('name', 'field_' + row + '_4');
        $(newRow).find('#field_2_4').attr('id', 'field_' + row + '_4');

        //Clean the value.
        newRow.find('input').each(function(i){
            if($(this).attr('type') != 'button'){     //Clean value except button.
                $(this).val('');
            }
        });

        //Change the 'onTypeChange()' parm.
        $(newRow).find('select').each(function(i){
            $(this).attr('onChange', 'onTypeChange(' + row + ')')
        });

        //Hide the option
        $(this).find('#field_' + row + '_4').hide();

        $('#KeyTable').append(newRow);
        $('#row').val(row);
    })

    //Judge if show the more option field.
    function onTypeChange(fieldID){
        var selectValue = $("select[name='field_" + fieldID +"_3']").val();

        switch (selectValue){
            case 'boolean':
                showOptionField(fieldID, '是,否（使用 , 分割）');
            break;
            case 'select':
                showOptionField(fieldID, '选项一,选项二（使用 , 分割）');
            break;
            case 'checkbox':
                showOptionField(fieldID, '选项一,选项二（使用 , 分割）');
            break;
            case 'upload':
                showOptionField(fieldID, '允许上传的文件格式：png,jepg,jpg（使用 , 分割）');
            break;
            default:
                $('#field_' + fieldID + '_4').hide();
        }
    }

    function showOptionField(fieldID, placeHolder, defaultValue){
        $('#field_' + fieldID + '_4').attr('placeholder', placeHolder);
        $('#field_' + fieldID + '_4').show();
    }

    $('#DeleteModule').click(function(e){
        console.log(e)
    })
</script>