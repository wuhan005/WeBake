<?php defined('ABSPATH') OR exit('No direct script access allowed');?>

<div class="uk-container uk-container-small">
    <h2>API 接口</h2>
    <span class="uk-text-meta">当前共有 <?php echo(count($this->db->get_all_api())); ?> 个 API 接口</span> 
    <a class="uk-button uk-button-primary uk-align-right" href="/wb-develop/index.php/AddAPI">添加</a>

    <?php if(!empty($this->db->get_all_api())){?>
        <table class="uk-table uk-table-divider">
            <thead>
                <tr>
                    <th>#</th>
                    <th>API介绍</th>
                    <th>请求方式</th>
                    <th>URL</th>
                    <th>模块来源</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
            <?php foreach($this->db->get_all_api() as $key => $value){?>
                <tr>
                    <td><?php echo($value['api_ID']); ?></td>
                    <td><?php echo($value['api_Name']); ?></td>
                    <td><?php echo($value['api_Method']); ?></td>
                    <td><?php echo('/Api/' . $value['api_URL']);?></td>
                    <td><?php echo($this->db->get_module_by_id($value['api_Module'])['module_Name']); ?></td>
                    <td><a href="/index.php/<?php echo('Api/' . $value['api_URL'] ); ?>" target="_blank">测试</a>
                    |
                      <a href="/wb-develop/index.php/EditAPI?version=<?php echo($value['api_Version']);?>&meta=<?php echo($value['api_Meta']);?>">修改</a>
                    | <a href="/wb-develop/index.php/DeleteAPI?id=<?php echo($value['api_ID']); ?>" class="uk-text-danger">删除</a></td>
                </tr>
            <?php }?>
            </tbody>
        </table>

        <?php }else{ ?>
            <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                <div>
                    <div class="uk-card uk-card-default uk-card-body">当前数据库内无任何 API，添加一个吧。</div>
                </div>
            </div>
        <?php } ?>
</div>