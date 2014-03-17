<?php
/*
 * Post management - the list
 */
?>
<h2>Post Maintenance</h2>
<span style="color:green">{message}</span>
<span style="color:red">{err_message}</span>
<div>
    <table class="table">
        <tr>
            <th>Action</th>
            <th>ID</th>
            <th>Picture</th>
            <th>Post title</th>
            <th>Last Modified</th>
            <th>Tags</th>
            <th>Slug</th>
            <th>Story</th>
        </tr>
        {posts}
    </table>
</div>
<div>
    {post_add}{cancel}
</div>