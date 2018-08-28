<div class="uk-container uk-container-small">
    <h2>项目设置</h2>
    <p class="uk-text-meta">这里是对当前项目的基本设置。</p>

    <form class="uk-form-horizontal uk-margin-large">

        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-text">项目名称</label>
            <div class="uk-form-controls">
                <input class="uk-input" id="form-horizontal-text" type="text" placeholder="我的项目" value="<?php echo($this->db->get_single_option('project_name'));?>">
            </div>
        </div>

        <div class="uk-margin">
            <div class="uk-form-controls">
                <button class="uk-button uk-button-primary">提交</button>
            </div>
        </div>

    </form>

</div>