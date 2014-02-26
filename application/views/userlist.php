<?php
/*
 * User management - the list
 */
?>
<h2>User Maintenance</h2>
<div>
    <table class="table">
        <tr>
            <th>Action</th>
            <th>Userid</th>
            <th>Role</th>
            <th>Name</th>
            <th>Status</th>
        </tr>
        {users}
        <tr>
            <td>
                {user_edit}
                {user_delete}
                <!--
                <a href="/usermtce/edit/{id}"><input type="button" value="Edit"></input></a>
                <a href="/usermtce/delete/{id}"><input type="button" value="Delete"></input></a>
                -->
             <!--  <a class="btn btn-mini" href="/usermtce/delete/{id}"><i  class="icon-trash"></i></a></td> -->
            </td>
            <td>{id}</td>
            <td>{role}</td>
            <td>{name}</td>
            <td>{status}</td>
        </tr>
        {/users}
    </table>
</div>
<div>
    {user_add}{cancel}
    <!--
    <a href="/usermtce/add"><input type="button" value="Add a new user"></input></a>
    -->
    <!--  <a href="/usermtce/add">Add a new user</a> -->
</div>