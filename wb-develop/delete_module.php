<?php defined('ABSPATH') OR exit('No direct script access allowed');?>

<div class="uk-container uk-container-small">
    <h2>删除数据</h2>
        
    <div class="uk-alert-danger" uk-alert>
        <p>您确定要删除 <?php echo($this->db->get_module_by_id($_GET['id'])['module_Name']) ?> [<?php echo($this->db->get_module_by_id($_GET['id'])['module_FriendlyName']) ?>] 模块吗？该操作无法被恢复。数据无价，请谨慎操作。</p>
    </div>

    <p>模块名：<?php echo($this->db->get_module_by_id($_GET['id'])['module_Name']);?></p>
    <p>显示名称：<?php echo($this->db->get_module_by_id($_GET['id'])['module_FriendlyName']);?></p>
    <p>包含字段：</p>

    <table class="uk-table uk-table-divider">
    <thead>
        <tr>
            <th>字段名</th>
            <th>显示名称</th>
            <th>类型</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo(json_decode($this->db->get_module_by_id($_GET['id'])['module_Key'], true)[0][0]);?></td>
            <td>编号</td>
            <td>number</td>
        </tr>  
        <?php foreach(json_decode($this->db->get_module_by_id($_GET['id'])['module_Key'], true) as $key => $value){?>
        <tr>
            <?php if($key != 0){?>
                <td><?php echo($value[0]);?></td>
                <td><?php echo($value[1]);?></td>
                <td><?php echo($value[2]);?></td>
            <?php }?>
        </tr>
        <?php }?>
    </tbody>
    </table>

    <form action="/wb-develop/action.php?do=DeleteModule" method="POST">
        <input name="mid" type="hidden" value="<?php echo($_GET['id']);?>">
        <a href="/wb-develop/index.php/Module" class="uk-button uk-button-default uk-align-right">取消</a>
        <button type="submit" class="uk-button uk-button-danger uk-align-right">确认删除</button>
    </form>
</div>