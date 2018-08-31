<?php include_once('wb-header.php');?>

<h2>删除数据</h2>

<div class="uk-alert-danger" uk-alert>
        <p>您确定要删除该条数据吗？该操作无法被恢复。数据无价，请谨慎操作。</p>
</div>

<form action="/index.php/Action?do=DeleteData" method="POST" class="uk-form-horizontal uk-margin-large">
    <input name="id" value="<?php echo($_GET['id']);?>" type="hidden">
    <input name="mid" value="<?php echo($this->db->get_data_by_id($_GET['id'])['data_Module']);?>" type="hidden">

    <?php
    //Get the data.
    $data = $this->db->get_data_by_id($_GET['id'])['data_Content'];
    $data = json_decode($data, true);

    //Get the data's module. Used to display the friendly name.
    $key = $this->db->get_module_by_id($this->db->get_data_by_id($_GET['id'])['data_Module'])['module_Key'];
    $key = json_decode($key, true);
    //var_dump($key);


    foreach($key as $index => $value){
         if($index != 0){?>
           <p><?php echo($value[1]);?>：<?php echo($data[$value[0]]);?></p>

    <?php } }?>

    <div class="uk-margin">
        <a href="/index.php/Module?id=<?php echo($this->db->get_data_by_id($_GET['id'])['data_Module']);?>" class="uk-button uk-button-default uk-align-right">取消</a>
        <button type="submit" class="uk-button uk-button-primary uk-align-right">删除数据</button>
    </div>
</form>

<?php include_once('wb-footer.php');?>