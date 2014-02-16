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
 * ------------------------------------------------------------------------
 */
?>
<h1>{ptitle}</h1>
<div class="row-fluid">
    <div class="span12">
        #{uid} <a href="/view/post/{uid}">{ptitle}</a> {pdate} {ptags} {buttons}<br/>
        <div class="right">
            {media}
            <a href="/data/images/{filename}"><img src="/data/thumbs/{thumbnail}" title="{caption}"/></a>
            {/media}
        </div>
        <h4>{slug}</h4>
        <p>{story}</p>
    </div>
</div>
