<?php defined('ABSPATH') OR exit('No direct script access allowed');?>

<div class="uk-container uk-container-small">
    <h2>修改 API 接口</h2>

    <form id="apiForm" action="/wb-develop/action.php?do=EditAPI" method="POST" class="uk-form-horizontal uk-margin-large">
        <div id="alertBox" class="uk-alert-warning" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p id="alertLog">表单中有必填字段为空，请检查。</p>
        </div>

        <?php
        function isSelect($type, $nowSelect , $log='selected = "selected"'){
            if($type == $nowSelect){
                echo($log);
            }
        }

        $api = $this->db->get_single_api_by_id($_GET['id']);
        ?>

        <input name="id" type="hidden" value="<?php echo($api['api_ID']);?>">

        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">用途介绍</label>
            <div class="uk-form-controls">
                <input name="name" class="uk-input" type="text" value="<?php echo($api['api_Name']);?>" required>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">URL</label>
            <div class="uk-form-controls">
                <input name="url" class="uk-input" type="text" value="<?php echo($api['api_URL']);?>" required>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">类型</label>
            <div class="uk-form-controls">
                <select id="type" name="type" class="uk-select" id="form-stacked-select" onchange="apiTypeChange()" required>
                    <option value="read" <?php isSelect('read', $api['api_Type']);?>>读取</option>
                    <option value="action" <?php isSelect('action', $api['api_Type']);?>>请求</option>
                </select>
            </div>
        </div>

<!-- Read type's api's setting. -->
        <div uk-alert>
            <div id="readSetting" class="uk-margin">
                <label class="uk-form-label" for="form-horizontal-text">显示条数</label>
                <div class="uk-form-controls">
                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                        <label><input id="all" class="uk-radio" onchange="displayTypeSettingChange()" type="radio" name="showAmount"  value="all" <?php isSelect('all', json_decode($api['api_Setting'], true)[0], 'checked');?> required> 全部</label>
                        <label><input id="part" class="uk-radio" onchange="displayTypeSettingChange()" type="radio" name="showAmount" value="part" <?php isSelect('part', json_decode($api['api_Setting'], true)[0], 'checked');?> required> 部分分页</label>
                    </div>
                </div>
            </div>

            <div id="partDisplaySetting" class="uk-margin">
                <label class="uk-form-label" for="form-horizontal-text">每页条数</label>
                <div class="uk-form-controls">
                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                        <input
                            id="countPerPage"
                            name="countPerPage"
                            class="uk-input"
                            type="text"
                            value="<?php if(isset(json_decode($api['api_Setting'])[1])){echo(json_decode($api['api_Setting'])[1]);}?>"
                            required
                        >
                    </div>
                </div>

                <label class="uk-form-label" for="form-horizontal-text">页面参数名称</label>
                <div class="uk-form-controls">
                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                        <input
                            id="nowPageName"
                            name="nowPageName"
                            class="uk-input"
                            type="text"
                            value="<?php if(isset(json_decode($api['api_Setting'])[2])){echo(json_decode($api['api_Setting'])[2]);}?>"
                            required
                        >
                    </div>
                </div>
            </div>  
        </div>
        
        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">请求方式</label>
            <div class="uk-form-controls">
                <select name="method" class="uk-select" id="form-stacked-select" required>
                    <option value="get" <?php isSelect('read', $api['api_Type']);?>>GET</option>
                    <option value="post" <?php isSelect('post', $api['api_Type']);?>>POST</option>
                </select>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">数据来源模块</label>
            <div class="uk-form-controls">
                <select name="module" class="uk-select" id="form-stacked-select" required>
                    <?php foreach($this->db->get_all_module() as $key => $value){?>
                        <option value="<?php echo($value['module_ID'])?>" <?php isSelect($value['module_ID'], $api['api_Module']);?>><?php echo($value['module_Name'])?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="uk-margin">
                <button type="submit" class="uk-button uk-button-primary uk-align-right">修改</button>
        </div>
    </form>
</div>

<script>

$('#partDisplaySetting').hide();
$('#alertBox').hide();
displayTypeSettingChange();
//At first, disable the part field checking.
$( "#countPerPage" ).validate({
    rules: {
        field: {
            required: false,
        }
    }
});
$( "#nowPageName" ).validate({
    rules: {
        field: {
            required: false,
        }
    }
});

function apiTypeChange(){
    var apiType = $('#type').val();

    if(apiType == 'read'){
        $('#readSetting').show();
        displayTypeSettingChange();

    }else if(apiType == 'action'){
        $('#readSetting').hide();

        $('#partDisplaySetting').hide();
    }

}

function displayTypeSettingChange(){
    var displayType = $("[name='showAmount']:checked").val();
    if(displayType == 'part'){
        $('#partDisplaySetting').show();

        //Active the part field checking.
        $( "#countPerPage" ).validate({
            rules: {
                field: {
                    required: true,
                }
            }
        });
        $( "#nowPageName" ).validate({
            rules: {
                field: {
                    required: true,
                }
            }
        });

    }else if(displayType == 'all'){
        $('#partDisplaySetting').hide();
        //Disable the part field checking.
        $( "#countPerPage" ).validate({
            rules: {
                field: {
                    required: false,
                }
            }
        });
        $( "#nowPageName" ).validate({
            rules: {
                field: {
                    required: false,
                }
            }
        });
    }
}

    //Check the form.
    $().ready(function() {
        $("#apiForm").validate({
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