<?php
if (!defined('APPPATH'))
    exit('No direct script access allowed');
/**
 * view/welcome.php
 *
 * Home page for the Java-Geeks website
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

<h2>Greater Vancouver Pub Reviews</h2>
<p>This site will contain reviews of Greater Vancouver bars and pubs by people who enjoy going to them, rather than reviews by professionals who will never truly understand the experience.</p>
<!--
<div class="alone"></div>
-->
<!--
<div class="row-fluid">
-->
<div>
    {posts}
    <div class="span4">
        <a href="/view/post/{pid}"><img src="{img_src}" title="{caption}"/></a><br/>
        <h4>{ptitle}</h4>
        <p>{updated}</p>
        <p>{slug}</p>
        <p><a href="/view/post/{pid}">Read more...</a></p>
    </div>
    {/posts}
</div>
