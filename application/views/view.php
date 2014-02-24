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
 * 
 * Modified Chris Holisky Feb 9, 2014 
 * Repurposed code for web page project
 * ------------------------------------------------------------------------
 */
?>
<h1>Posts, Newest First</h1>
{posts}
<div class="row-fluid">
    <div class="span12">
        #{pid} <a href="/view/post/{pid}">{ptitle}</a> {updated}<br/>
        <p>{slug}</p>
    </div>
</div>
{/posts}
