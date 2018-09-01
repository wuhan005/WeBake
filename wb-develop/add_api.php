<div class="uk-container uk-container-small">
    <h2>添加新的 API 接口</h2>

    <form action="/wb-develop/action.php?do=AddAPI" method="POST" class="uk-form-horizontal uk-margin-large">

        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">名称</label>
            <div class="uk-form-controls">
                <input name="name" class="uk-input" id="form-horizontal-text" type="text">
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">标签</label>
            <div class="uk-form-controls">
                <input name="meta" class="uk-input" id="form-horizontal-text" type="text">
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">类型</label>
            <div class="uk-form-controls">
                <select id="type" name="type" class="uk-select" id="form-stacked-select" onchange="apiTypeChange()">
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
                        <label><input id="all" class="uk-radio" onchange="displayTypeSettingChange()" type="radio" name="showAmount" checked value="all"> 全部</label>
                        <label><input id="part" class="uk-radio" onchange="displayTypeSettingChange()" type="radio" name="showAmount" value="part"> 部分分页</label>
                    </div>
                </div>
            </div>

            <div id="partDisplaySetting" class="uk-margin">
                <label class="uk-form-label" for="form-horizontal-text">每页条数</label>
                <div class="uk-form-controls">
                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                        <input name="countPerPage" class="uk-input" id="form-horizontal-text" type="text">
                    </div>
                </div>

                <label class="uk-form-label" for="form-horizontal-text">页面参数名称</label>
                <div class="uk-form-controls">
                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                        <input name="nowPageName" class="uk-input" id="form-horizontal-text" type="text" value="page">
                    </div>
                </div>
            </div>  
        </div>
        
        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">请求方式</label>
            <div class="uk-form-controls">
                <select name="method" class="uk-select" id="form-stacked-select">
                    <option value="get">GET</option>
                    <option value="post">POST</option>
                </select>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">版本</label>
            <div class="uk-form-controls">
                <input name="version" class="uk-input" id="form-horizontal-text" type="text" value="v1">
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">数据来源模块</label>
            <div class="uk-form-controls">
                <select name="module" class="uk-select" id="form-stacked-select">
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

    }else if(displayType == 'all'){
        $('#partDisplaySetting').hide();
    }
}
</script>