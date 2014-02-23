<?php
if (!defined('APPPATH'))
    exit('No direct script access allowed');
/**
 * views/postedit.php
 *
 * Manage a posting's contents
 *
 * @author		JLP
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


<form action="/postmtce/submit/{id}" method="post">
    {field_pic}<br/>
    {field_title}<br/>
    {field_date}<br/>
    {field_slug}<br/>
    {field_story}<br/>
    {field_submit_btn}
</form>