<?php
if (!defined('APPPATH'))
    exit('No direct script access allowed');

/**
 * view/template.php
 *
 * Pass in $pagetitle (which will in turn be passed along)
 * and $pagebody, the name of the content view.
 *
 * ------------------------------------------------------------------------
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>{title}</title>
        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8"/>
        <link href="/assets/images/icons/favicon.ico" rel="icon" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="/assets/css/reset.css"/>
        <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css" media="screen"/>
        {caboose_styles}
        <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap-responsive.min.css"/>
        <link rel="stylesheet" type="text/css" href="/assets/css/jasny-bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="/assets/css/main.css"/>

    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <h1><a href="#">Greater Vancouver Pub Reviews</a></h1>
                <strong>Casual reviews of our favorite watering holes</strong>
                <div class="mynav">
                    <ul id="main-nav">
                        {menubar}
                    </ul>
                    <form action="#" method="post">
                        <fieldset>
                            <input type="text" value="Type your search term here..." class="input-text" />
                        </fieldset>
                    </form>
                    <div id="social-media">
                        {login}
                    </div>

                    <h2>{pageTitle}<span>{pageDescrip}</span></h2>

                </div>				
                <!-- //#header -->

            </div>
            <div class="alone"></div>
            <div>
                <div id="content">
                    <div id="content-inner" class="clearfix">
                        {content}
                    </div>
                    <!-- //#content-inner -->
                    <!--
                    <div id="sidebar" class="span3">
                        {sidebar}
                    </div>
                    -->
                </div>
            </div>
            <!-- <div id="footer" class="span12">  -->
            <div id="footer">
                <div id="footer-inner">

                    <ul>
                        {menubar}
                    </ul>

                    <!--<p><strong>Design: <a href="http://www.google.com/">Baranda</a></strong> <span>|</span> <strong>Code: <a href="http://www.google.com" title="PSD to (X)HTML, PSD to CMS service">Slicejack</a></strong></p> -->
                    <p><strong>Session ID: {session_id}</strong></p>
                </div>
                <!--  Copyright &copy; 2014,  <a href="mailto:someone@somewhere.com">Me</a>. -->
            </div>
        </div>
        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/bootstrap-datepicker.js"></script>
        <script src="/assets/js/jasny-bootstrap.min.js"></script>
        {caboose_scripts}
        {caboose_trailings}
    </body>
</html>
