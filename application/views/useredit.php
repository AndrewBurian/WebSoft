<?php
if (!defined('APPPATH'))
    exit('No direct script access allowed');
/**
 * views/useredit.php
 *
 * Manage member settings
 *
 * ------------------------------------------------------------------------
 */
if (isset($errors) && count($errors) > 0) {
    ?>
    <div class="alert alert-error">
        <p><strong></strong></p>
        <?php
        foreach ($errors as $booboo)
            echo '<p>' . $booboo . '</p>';
        ?>
    </div>
<?php }
?>
<form enctype="multipart/form-data" action="/usermtce/submit/{id}" method="post">
    {field_errors}
    {field_name}
    {field_password}
    {field_password_new}
    {field_role}
    {field_email}
    {field_status}
    {field_pic}
    <br/><br/>
    {field_submit_btn}
</form>

