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
            <th>UID</th>
            <th>Thumbnail</th>
            <th>Post title</th>
            <th>Post date</th>
            <th>Slug</th>
            <th>Story</th>
        </tr>
        {posts}
        <tr>
            <td>
                <a href="/postmtce/edit/{uid}"><input type="button" value="Edit"></input></a>
                <a href="/postmtce/delete/{uid}"><input type="button" value="Delete"></input></a>
             <!--  <a class="btn btn-mini" href="/usermtce/delete/{id}"><i  class="icon-trash"></i></a></td> -->
            </td>
            <td>{uid}</td>
            <td>{thumb}</td>
            <td>{ptitle}</td>
            <td>{pdate}</td>
            <td>{slug}</td>
            <td>{story}</td>

        </tr>
        {/posts}
    </table>
</div>
<div>
    <a href="/postrmtce/add"><input type="button" value="Add a new post"></input></a>
    <!--  <a href="/usermtce/add">Add a new user</a> -->
</div>