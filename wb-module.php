<?php include_once('wb-header.php');?>

<h2><?php echo($this->db->get_module_by_id($_GET['id'])['module_FriendlyName']);?></h2>

<span class="uk-text-meta">当前共有 <?php echo(count($this->db->get_module_data($_GET['id']))); ?> 条数据</span> 
    <a class="uk-button uk-button-primary uk-align-right" href="/index.php/AddData?id=<?php echo($_GET['id']);?>">添加</a>

    <?php if(!empty($this->db->get_module_data($_GET['id']))){?>
        <table class="uk-table uk-table-divider">
            <thead>
                <tr>
                    <th>#</th>
                    <?php 
                    $moduleKey = $this->db->get_module_by_id($_GET['id'])['module_Key'];
                    $moduleKey = json_decode($moduleKey, true);
                    $keyName = array();  //Used by the data table.
                    foreach($moduleKey as $key => $value){
                        //Remove the first id.
                        if($key != 0){
                            $keyName[] = $key;
                    ?>
                        <th><?php echo($value[1]);?></th>
                            
                    <?php } }?>
                    <th></th>
                </tr>
            </thead>

            <tbody>
            <?php foreach($this->db->get_module_data($_GET['id']) as $key => $value){
                $data = $value['data_Content'];
                $data = json_decode($data, true);
            ?>
                <tr>
                    <td><?php echo($key + 1);?></td>

                    <?php foreach($data as $dataKey => $dataValue){?>
                        <td><?php
                            //Judge the data is array or not.
                            if(is_array($dataValue)){
                                foreach($dataValue as $key){
                                    echo($key . ' ');
                                }
                            }else{
                                echo($dataValue); 
                            }
                        ?>
                        </td>
                    <?php }?>

                    <td><a class="uk-text-muted" href="/index.php/EditData?id=<?php echo($value['data_ID']);?>">修改</a> | <a class="uk-text-danger" href="/index.php/DeleteData?id=<?php echo($value['data_ID']);?>">删除</a></td>
                </tr>
            <?php }?>
            </tbody>
        </table>

        <?php }else{ ?>
            <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                <div>
                    <div class="uk-card uk-card-default uk-card-body">当前数据库内无任何数据，添加一条吧。</div>
                </div>
            </div>
        <?php } ?>

<?php include_once('wb-footer.php');?>