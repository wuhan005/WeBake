<?php
    $nowPage = 'dashboard';
    include_once('header.php');

    //Load the database.
    require_once('../wb-includes/Database.class.php');
    $db = new Database();
?>

<div class="uk-container uk-container-small">
    <h2>仪表盘</h2>

</div>


<?php
    include_once('footer.php');
?>