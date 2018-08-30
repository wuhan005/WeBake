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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input name="field_1_1" class="uk-input uk-form-width-medium" type="text"></td>
                        <td>编号</td>
                        <td>
                            数字(number)
                        </td>
                    </tr>
                    <tr>
                        <td><input name="field_2_1" class="uk-input uk-form-width-medium" type="text"></td>
                        <td><input name="field_2_2" class="uk-input uk-form-width-medium" type="text"></td>
                        <td>
                            <select name="field_2_3" class="uk-select" id="form-stacked-select">
                                <option value="string">字符串(string)</option>
                                <option value="number">数字(number)</option>
                                <option value="boolean">布尔(boolean)</option>
                            </select>
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
    $('#row').val(row);
    $('#AddNewModule').click(function(){
        row++;
        var newRow = '<tr><td><input name="field_' + row + '_1" class="uk-input uk-form-width-medium" type="text"></td><td><input name="field_' + row +'_2" class="uk-input uk-form-width-medium" type="text"></td><td><select name="field_' + row + '_3" class="uk-select" id="form-stacked-select"><option value="string">字符串(string)</option><option value="number">数字(number)</option><option value="boolean">布尔(boolean)</option></select></td></tr>';
        $('#KeyTable').append(newRow);
        $('#row').val(row);
    })

    $('#DeleteModule').click(function(e){
        console.log(e)
    })
</script>