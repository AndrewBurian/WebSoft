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
<h1>Greater Vancouver Pub Reviews</h1>
<p>This site will contain reviews of Greater Vancouver bars and pubs by people who enjoy going to them, rather than reviews by professionals who will never get the real social experience.</p>
<div class="alone"></div>
<div class="row-fluid">
    {posts}
    <div class="span4">
        <a href="/view/post/{uid}"><img src="/assets/images/thumbs/{thumb}"/></a><br/>
        <h4>{ptitle}</h4>
        <p>{pdate} {tags}</p>
        <p>{slug}</p>
        <p><a href="/view/post/{uid}">Read more...</a></p>
    </div>
    {/posts}
</div>
