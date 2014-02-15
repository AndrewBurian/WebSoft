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
        #{uid} <a href="/view/post/{uid}">{ptitle}</a> {pdate} {tags}<br/>
        <div class="right">
            {media}
            <a href="/assets/images/other/{filename}"><img src="/assets/images/other/{thumbnail}" title="{caption}"/></a>
            {/media}
        </div>
        <h4>{slug}</h4>
        <p>{story}</p>
    </div>
</div>
