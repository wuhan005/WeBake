<div class="uk-container uk-container-small">
    <h2>模块</h2>
    <a class="uk-button uk-button-primary uk-align-right" href="/wb-develop/index.php/AddModule">添加</a>

    <?php if(!empty($this->db->get_all_module())){?>
        <table class="uk-table uk-table-divider">
            <thead>
                <tr>
                    <th>#</th>
                    <th>模块名</th>
                    <th>包含字段</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
            <?php foreach($this->db->get_all_module() as $key => $value){?>
                <tr>
                    <td><?php echo($value['module_ID']); ?></td>
                    <td><?php echo($value['module_Name']); ?></td>
                    <td>
                    <?php 
                    foreach(json_decode($value['module_Key'], true) as $module_key => $module_value){?>
                        <span><?php echo($module_value[0]);?></span>
                    <?php }?>
                    </td>
                    <td>修改 | <span class="uk-text-danger">删除</span></td>
                </tr>
            <?php }?>
            </tbody>
        </table>

        <?php }else{ ?>
            <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                <div>
                    <div class="uk-card uk-card-default uk-card-body">当前数据库内无任何模块，添加一个吧。</div>
                </div>
            </div>
        <?php } ?>
</div>