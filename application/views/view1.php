<?php
if (!defined('APPPATH'))
    exit('No direct script access allowed');
/**
 * view/view1.php
 *
 * Present a single post
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
<h1>{ptitle}</h1>
<div class="row-fluid">
    <div class="span12">
        <div class="right">
            #{pid} <a href="/view/post/{pid}">{ptitle}</a> {updated}<br/>
            <div>
                <a href="{img_src}"><img src="{img_src}" title="{caption}"/></a><br/>
            </div>
        </div>
        <h4>{slug}</h4>
        {tags}
        <br/><br/>
        <img src="{author_img}" height="50" width="50"/>
        Posted by: <strong>{author_name}</strong>
        <br/><br/>
        <p>{story}</p> 
        <br/><br/>
        {comments}
    </div>
</div>
