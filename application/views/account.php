<?php
if (!defined('APPPATH'))
    exit('No direct script access allowed');
/**
 * view/accountMan.php
 *
 * Account Management page for the Greater Vancouver Pub Reviews website
 *
 * @package		Greater Vancouver Pub Reviews
 * @author		Chris Holisky
 * @copyright           Copyright (c) 2014, Chris Holisky
 * @since		Version 1.0.0
 * 
 *  
 * 
 * ------------------------------------------------------------------------
 */
?>

<div class="column main">
    <h2>Your Account</h2>
    <table style="width: 50%">
        <tr>
            <td><img src="{user_image}" style="height: 200px; width: 200px;"/></td>
            <td style="vertical-align: top">{user_info}</td>
        </tr>
    </table>
    <br/><br/>
    <h4>My Posts:</h4>
    {user_posts}
</div>

<div class="column sidebar">
    <h3>Options</h3>
    <ul>
        {user_options}
    </ul>
</div>
