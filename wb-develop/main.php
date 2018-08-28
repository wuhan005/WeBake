<div class="uk-container uk-container-small">
    <h2>仪表盘</h2>

    <div class="uk-card uk-card-default uk-card-body uk-width-1-2@m">
    <h3 class="uk-card-title">当前状态</h3>
        <p>
        <?php 
            if($this->db->get_db_status()){
                echo('数据库连接正常');
            }else{
                echo('无法连接至数据库，请检查配置。');
            }
        ?>
        </p>
    </div>
</div>