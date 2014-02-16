<?php
if (!defined('APPPATH'))
    exit('No direct script access allowed');
/**
 * view/view.php
 *
 * Present a list of posts
 *
 * @package		Java-Geeks
 * @author		JLP
 * @copyright           Copyright (c) 2013, J.L. Parry
 * @since		Version 2.0.0
 * ------------------------------------------------------------------------
 */
?>
<h1>Posts, Newest First</h1>
{posts}
<div class="row-fluid">
    <div class="span12">
        #{uid} <a href="/view/post/{uid}">{ptitle}</a> {pdate} {ptags} {buttons}<br/>
        <p>{slug}</p>
    </div>
</div>
{/posts}
