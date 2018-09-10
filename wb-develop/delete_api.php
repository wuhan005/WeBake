<?php defined('ABSPATH') OR exit('No direct script access allowed');?>

<div class="uk-container uk-container-small">
    <h2>删除 API</h2>
        
    <div class="uk-alert-danger" uk-alert>
        <p>您确定要删除 <?php echo($this->db->get_single_api_by_id($_GET['id'])['api_URL']) ?> [<?php echo($this->db->get_single_api_by_id($_GET['id'])['api_Name']) ?>] 吗？该操作无法被恢复。数据无价，请谨慎操作。</p>
    </div>

    <p>名称：<?php echo($this->db->get_single_api_by_id($_GET['id'])['api_Name']);?></p>
    <p>URL：<?php echo($this->db->get_single_api_by_id($_GET['id'])['api_URL']);?></p>
    <p>类型：<?php echo($this->db->get_single_api_by_id($_GET['id'])['api_Type']);?></p>

    <form action="/wb-develop/action.php?do=DeleteAPI" method="POST">
        <input name="id" type="hidden" value="<?php echo($_GET['id']);?>">
        <a href="/wb-develop/index.php/API" class="uk-button uk-button-default uk-align-right">取消</a>
        <button type="submit" class="uk-button uk-button-danger uk-align-right">确认删除</button>
    </form>
</div>