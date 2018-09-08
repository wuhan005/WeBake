<?php defined('ABSPATH') OR exit('No direct script access allowed');?>

<div class="uk-container uk-container-small">
    <h2>添加新的 API 接口</h2>

    <form id="apiForm" action="/wb-develop/action.php?do=AddAPI" method="POST" class="uk-form-horizontal uk-margin-large">
        <div id="alertBox" class="uk-alert-warning" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p id="alertLog">表单中有必填字段为空，请检查。</p>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">用途介绍</label>
            <div class="uk-form-controls">
                <input name="name" class="uk-input" id="form-horizontal-text" type="text" required>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">URL</label>
            <div class="uk-form-controls">
                <input name="url" class="uk-input" id="form-horizontal-text" type="text" required>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">类型</label>
            <div class="uk-form-controls">
                <select id="type" name="type" class="uk-select" id="form-stacked-select" onchange="apiTypeChange()" required>
                    <option value="read">读取</option>
                    <option value="action">请求</option>
                </select>
            </div>
        </div>

<!-- Read type's api's setting. -->
        <div uk-alert>
            <div id="readSetting" class="uk-margin">
                <label class="uk-form-label" for="form-horizontal-text">显示条数</label>
                <div class="uk-form-controls">
                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                        <label><input id="all" class="uk-radio" onchange="displayTypeSettingChange()" type="radio" name="showAmount" checked value="all" required> 全部</label>
                        <label><input id="part" class="uk-radio" onchange="displayTypeSettingChange()" type="radio" name="showAmount" value="part" required> 部分分页</label>
                    </div>
                </div>
            </div>

            <div id="partDisplaySetting" class="uk-margin">
                <label class="uk-form-label" for="form-horizontal-text">每页条数</label>
                <div class="uk-form-controls">
                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                        <input id="countPerPage" name="countPerPage" class="uk-input" id="form-horizontal-text" type="text" required>
                    </div>
                </div>

                <label class="uk-form-label" for="form-horizontal-text">页面参数名称</label>
                <div class="uk-form-controls">
                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                        <input id="nowPageName" name="nowPageName" class="uk-input" id="form-horizontal-text" type="text" value="page" required>
                    </div>
                </div>
            </div>  
        </div>
        
        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">请求方式</label>
            <div class="uk-form-controls">
                <select name="method" class="uk-select" id="form-stacked-select" required>
                    <option value="get">GET</option>
                    <option value="post">POST</option>
                </select>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">数据来源模块</label>
            <div class="uk-form-controls">
                <select name="module" class="uk-select" id="form-stacked-select" required>
                    <?php foreach($this->db->get_all_module() as $key => $value){?>
                        <option value="<?php echo($value['module_ID'])?>"><?php echo($value['module_Name'])?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="uk-margin">
                <button type="submit" class="uk-button uk-button-primary uk-align-right">添加</button>
        </div>
    </form>
</div>

<script>

$('#partDisplaySetting').hide();
$('#alertBox').hide();

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