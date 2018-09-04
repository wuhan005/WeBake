<?php
define( 'ABSPATH', dirname( dirname( __FILE__ ) ) . '/' );
$config_path = ABSPATH . 'wb-config.php';

function try_connect_database($database, $user, $password, $host){
    $db_conn = @mysqli_connect($host, $user, $password, $database);
        if(!$db_conn){
            //Connect fail.
            return false;
        }else{
            set_config_file($database, $user, $password, $host);
            return true;
        }
}

function set_config_file($database, $user, $password, $host){
    global $config_path;

    //Get the content of the wb-config.php file.
    $config_file = file($config_path);

    //Get each line of the file.
    foreach ( $config_file as $line_num => $line ) {
        if(!preg_match('/^define\(\s*\'([A-Z_]+)\',([ ]+)/', $line, $match)){
            continue;
        }
        $constant = $match[1];  //Option Name
        $padding  = $match[2];
        
        //Edit the value.
        switch($constant){
            case 'DB_HOST':
                $config_file[$line_num] = set_option_to_code($constant, $host);
            break;
            case 'DB_NAME':
                $config_file[$line_num] = set_option_to_code($constant, $database);
            break;
            case 'DB_USER':
                $config_file[$line_num] = set_option_to_code($constant, $user);
            break;
            case 'DB_PASSWORD':
                $config_file[$line_num] = set_option_to_code($constant, $password);
            break;
        }
    }

    //Edit the wb-config.php file.
    $handle = fopen($config_path, 'w');
    foreach ($config_file as $line) {
        fwrite($handle, $line);
    }
    fclose($handle);
    chmod($config_path, 0666);
}

function set_option_to_code($option, $value){
    return "define('$option', '$value');\r\n";
}

function init_database($projectName, $devName, $devPassword, $userName, $userPassword){
    global $config_path;
    require_once($config_path);
    $db_conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    //wb_account
    mysqli_multi_query($db_conn,
        'CREATE TABLE `wb_account` (
            `account_ID` int(11) NOT NULL,
            `account_Name` text NOT NULL,
            `account_Password` text NOT NULL,
            `account_Type` text NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        CREATE TABLE `wb_api` (
            `api_ID` int(11) NOT NULL,
            `api_Name` text NOT NULL,
            `api_Meta` mediumtext NOT NULL,
            `api_Type` text NOT NULL,
            `api_Setting` mediumtext NOT NULL,
            `api_Method` text NOT NULL,
            `api_Version` text NOT NULL,
            `api_Module` int(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        ALTER TABLE `wb_api`
        ADD PRIMARY KEY (`api_ID`);

        ALTER TABLE `wb_api`
        MODIFY `api_ID` int(11) NOT NULL AUTO_INCREMENT;
        
        CREATE TABLE `wb_data` (
            `data_ID` int(255) NOT NULL,
            `data_Content` mediumtext NOT NULL,
            `data_Module` int(255) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

          ALTER TABLE `wb_data`
          ADD PRIMARY KEY (`data_ID`);

          ALTER TABLE `wb_data`
          MODIFY `data_ID` int(255) NOT NULL AUTO_INCREMENT;

        CREATE TABLE `wb_module` (
            `module_ID` int(255) NOT NULL,
            `module_Name` text NOT NULL,
            `module_FriendlyName` text NOT NULL,
            `module_Key` mediumtext NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

          ALTER TABLE `wb_module`
          ADD PRIMARY KEY (`module_ID`);

          ALTER TABLE `wb_module`
          MODIFY `module_ID` int(255) NOT NULL AUTO_INCREMENT;
         
        CREATE TABLE `wb_options` (
            `options_ID` int(255) NOT NULL,
            `options_Name` text NOT NULL,
            `options_Value` mediumtext NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
          
          ALTER TABLE `wb_options`
          ADD PRIMARY KEY (`options_ID`);

          ALTER TABLE `wb_options`
          MODIFY `options_ID` int(255) NOT NULL AUTO_INCREMENT;
          '
        .

    "INSERT INTO `wb_options` (`options_ID`, `options_Name`, `options_Value`) VALUES
    (1, 'project_name', '$projectName'),
    (2, 'copyright', '使用 WeBake 强力驱动！');"

    .

    "INSERT INTO `wb_account` (`account_ID`, `account_Name`, `account_Password`, `account_Type`) VALUES
    (1, '$devName', '$devPassword', 'developer'),
    (2, '$userName', '$userPassword', 'admin');"
    );
}
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/static/css/uikit.min.css" />
    <script src="/static/js/uikit.min.js"></script>
    <script src="/static/js/uikit-icons.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>

	<title>WeBake - 安装</title>
</head>
<div class="uk-background-cover uk-background-muted uk-panel" uk-height-viewport="offset-bottom: 0"></div>

<div class="uk-card uk-card-default uk-width-1-2@m uk-position-top-center uk-margin-large-top">
    <div class="uk-card-header">
        <div class="uk-grid-small uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
                <img class="uk-border-circle" width="40" height="40" src="">
            </div>
            <div class="uk-width-expand">
                <h3 class="uk-card-title uk-margin-remove-bottom">欢迎使用 WeBake！</h3>
                <p class="uk-text-meta uk-margin-remove-top">一个不需要写代码，简单易用的微信小程序后端程序。</p>
            </div>
        </div>
    </div>

<?php
if(isset($_GET['step'])){
    switch($_GET['step']){
        case 1:
            welcome_page();
        break;
    
        case 2:
            database_config_page();
        break;
    
        case 3:
            confirm_database_config_page();
        break;

        case 4:
            user_data_page();
        break;

        case 5:
            done_page();
        break;
    }

}else{
    welcome_page();
}?>

</div>

<?php
//First page, welcome user and introduce WeBake. 
function welcome_page(){
    ?>

    <div class="uk-card-body">
        <p>在开始安装之前，我们需要您数据库的一些信息。请准备好如下信息：</p>
        <ul class="uk-list">
            <li>1.数据库名</li>
            <li>2.数据库用户名</li>
            <li>3.数据库密码</li>
            <li>4.数据库主机</li>
        </ul>
        <p>如果对这些信息尚不清楚，您可以联系您的主机服务提供商。准备好了的话...</p>
    </div>
    <div class="uk-card-footer">
        <p class="uk-button uk-button-text">1 / 5</p>
        <a href="/wb-develop/install.php?step=2"class="uk-button uk-button-primary uk-align-right">开始吧！</a>
    </div>
<?php } ?>

<?php
//Second page, get the database data.
function database_config_page(){
    ?>
    <form action="/wb-develop/install.php?step=3" method="POST"  class="uk-form-horizontal">
        <div class="uk-card-body">
            <p>请输入您的数据库信息，如果您不确定，请联系您的主机服务提供商。</p>
            
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">数据库名</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="database" type="text" placeholder="将 WeBake 安装到哪个数据库？">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">用户名</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="user" type="text" placeholder="您的 MySQL 用户名">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">密码</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="password" type="text" placeholder="...以及密码">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">数据库主机</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="host" type="text" value="localhost" placeholder="如果填写 localhost 无法正常使用，请联系您的主机服务提供商">
                    </div>
                </div>
        </div>

        <div class="uk-card-footer">
            <p class="uk-button uk-button-text">2 / 5</p>
            <button type="submit" class="uk-button uk-button-primary uk-align-right">提交</button>
        </div>
    </form>
<?php } ?>

<?php
//Third page, confirm the database information.
function confirm_database_config_page(){
?>

    <?php
        if(isset($_POST['database'], $_POST['user'], $_POST['password'], $_POST['host'])){
            if(try_connect_database($_POST['database'], $_POST['user'], $_POST['password'], $_POST['host'])){
                //Connect successfully.
                $connectSuccess = true;
            }else{
                //Connect fail.
                $connectSuccess = false;
            }
        }else{
        //The parm is missing.
        $connectSuccess = false;
        }
    ?>

    <?php
    if($connectSuccess){?>
        <div class="uk-card-body">
            <p>真棒！您已经完成 WeBake 安装中最重要的一步。</p>
        </div>
        <div class="uk-card-footer">
            <p class="uk-button uk-button-text">3 / 5</p>
            <a href="/wb-develop/install.php?step=4" class="uk-button uk-button-primary uk-align-right">继续</a>
        </div>
    <?php }else{?>
        <div class="uk-card-body">
            <div class="uk-alert-danger" uk-alert>
                <h3>抱歉，无法连接您的数据库。</h3>
                <p>您填写的数据库配置可能不正确，WeBake 无法连接上您的数据库。请联系您的主机服务提供商。</p>
            </div>
        </div>
        <div class="uk-card-footer">
            <p class="uk-button uk-button-text">3 / 5</p>
            <button onclick="javascript:history.back(-1);" class="uk-button uk-button-default uk-align-right">返回</button>
        </div>
    <?php }?>

<?php }?>

<?php
//Fourth page, get the user data.
function user_data_page(){
?>
    <form action="/wb-develop/install.php?step=5" method="POST"  class="uk-form-horizontal">
        <div class="uk-card-body">
            <p>您需要填写一些基本信息。无需担心填错，这些信息以后可以再次修改。</p>

                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">项目名</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="project_name" type="text" value="我的项目" placeholder="我的项目">
                    </div>
                </div>
            
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">开发者账号</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="dev_name" type="text">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">开发者密码</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="dev_password" type="text">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">客户账号</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="user_name" type="text">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">客户密码</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="user_password" type="text">
                    </div>
                </div>
        </div>

        <div class="uk-card-footer">
            <p class="uk-button uk-button-text">4 / 5</p>
            <button type="submit" class="uk-button uk-button-primary uk-align-right">提交</button>
        </div>
    </form>

<?php }?>

<?php 
//Fifth page. Init the database and edit the data.
function done_page(){?>

<?php
    if(isset($_POST['project_name'], $_POST['dev_name'], $_POST['dev_password'], $_POST['user_name'], $_POST['user_password'])){
        init_database($_POST['project_name'], $_POST['dev_name'], $_POST['dev_password'], $_POST['user_name'], $_POST['user_password']);
    }
    ?>
    <div class="uk-card-body">
    WeBake 安装完成！谢谢！
    </div>
    <div class="uk-card-footer">
        <p class="uk-button uk-button-text">5 / 5</p>
        <a href="/index.php" class="uk-button uk-button-primary uk-align-right">开始使用</a>
    </div>
<?php }?>
