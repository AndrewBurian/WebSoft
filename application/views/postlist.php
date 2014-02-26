<?php
/*
 * Post management - the list
 */
?>
<h2>Post Maintenance</h2>
<div>
    <table class="table">
        <tr>
            <th>Action</th>
            <th>ID</th>
            <th>Picture</th>
            <th>Post title</th>
            <th>Last Modified</th>
            <th>Slug</th>
            <th>Story</th>
        </tr>
        {posts}
        <tr>
            <td>
                <!--
                <a href="/postmtce/edit/{pid}"><input type="button" value="Edit"></input></a>
                <a href="/postmtce/delete/{pid}"><input type="button" value="Delete"></input></a>
                -->
                {post_edit}
                {post_delete}
            </td>
            <td>{pid}</td>
            <td>{picname}</td>
            <td>{ptitle}</td>
            <td>{updated}</td>
            <td>{slug}</td>
            <td>{story}</td>
        </tr>
        {/posts}
    </table>
</div>
<div>
    <!--
    <a href="/postmtce/add"><input type="button" value="Add a new post"></input></a>
    -->
    {post_add}{cancel}
</div>