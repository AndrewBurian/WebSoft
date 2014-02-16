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

 
<form action="/postmtce/submit/{uid}" method="post">
    <button type="submit">Submit</button>     
    <a href="/postmtce"><input type="button" value="Cancel"></input></a>
    <br/><br/>
    <label for="uid">Thumbnail</label>
    <input type="text" name="thumb" id="thumb" value="{thumb}" />
    <label for="name">Post title</label>
    <input type="text" name="ptitle" id="ptitle" value="{ptitle}" />
    <label for="name">Post date</label>
    <input type="text" name="pdate" id="pdate" value="{pdate}" /><br/><br/>
    <label for="name">Slug</label>
    <input type="text" name="slug" id="slug" value="{slug}" />
    <label for="name">Story</label>
    <input type="text" name="story" id="story" value="{story}" />
</form>

