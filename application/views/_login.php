<?php
/**
 *  This is a view fragment, to hold a login form.
 * It is meant to be at the top of the sudebar in our layout.
 */
?>
<div class="well">
    <form method="post" action="/login/submit">
        <label for="id">Userid, eh</label>
        <input type="text" name="id" id="id"></input>
        <label for="password">Password</label>
        <input type="password" name="password" id="password"></input>
        <div class="myfumble">
            <label for="comment">Comments</label>
            <input type="text" name="comment" id="comment"></input>
        </div>
        <button type="submit">Login</button>
    </form>
</div>
