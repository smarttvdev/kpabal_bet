

<?php
header ("Content-Type:text/css");
$color = "#f0f"; // Change your Color Here

function checkhexcolor($color) {
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if( isset( $_GET[ 'color' ] ) AND $_GET[ 'color' ] != '' ) {
    $color = "#".$_GET[ 'color' ];
}

if( !$color OR !checkhexcolor( $color ) ) {
    $color = "#336699";
}

?>



@import url('https://fonts.googleapis.com/css?family=Montserrat:400,400i,500,500i,600,600i,700,700i,800,800i');



#back-to-top{
display: block;
background:<?php echo $color;?>;
width: 32px;
height: 32px;
right: 50px;
bottom: 50px;
position: fixed;
text-align: center;
font-size: 20px;
line-height: 32px;
font-weight: bold;
}
.widget_title1 h4 {
background-color: <?php echo $color?>;
border-radius: 40px;
}

/*
.footer-support-list {
    text-align: center;
    background-color:<?php echo $color?>;
    padding: 10px 0px;
}
*/


.bs-callout-warning {
    border:none;
    position:  relative;
    z-index: 0;
}
.bs-callout-warning:focus{
outline:none;
}
.bs-callout-warning:after {
    position:  absolute;
    top: 0;
    left:  0;
    width: 6px;
    height:  100%;
    background-color:  <?php echo $color?>;;
    content: '';
    border-top-left-radius:  4px;
    border-bottom-left-radius:  4px;
    transition:.5s ease-in;
    z-index:-1;
}
.bs-callout-warning:hover:after{
    width:100%;
    border-top-right-radius:  4px;
    border-bottom-right-radius:  4px;
}

.main-menu ul  li a::before {
background: <?php echo $color;?>;
}


#header-menu>.active>a, .main-menu-active>.active>a:focus, .main-menu-active>.active>a:hover{
color: <?php echo $color;?>;
}
.main-menu ul li .mega-menu .mega-list>a.menu-active, .main-menu ul li .mega-menu .mega-list1>a.menu-active:focus, .main-menu ul li .mega-menu .mega-list1>a.menu-active:hover{
color: <?php echo $color;?>;
}
.mega-menu .mega-list .mega-menu-item .mega-menu-content h5 a.menu-active, .mega-menu .mega-list .mega-menu-item .mega-menu-content h5 a.menu-active:hover{
color: <?php echo $color;?>;
}
.main-menu ul li a:hover{
color: <?php echo $color;?>;
}
.bet-q{
color: #fff;
}

.main-menu ul li   .mega-menu .mega-banner .mega-menu-banner{
background: <?php echo $color;?>;
}

.betOption {
background-color:<?php echo $color;?>;
border-bottom: 1px solid <?php echo $color;?>;
}

.panel-default> .panel-heading {
border-color: <?php echo $color;?>;
background-color: <?php echo $color;?>;
}

.card__header {
border-bottom: 2px solid <?php echo $color;?>;
background-color: #344153;
}

.login-admin .login-form input[type="submit"] {
margin-top: 13px;
color: #fff;
background-color: <?php echo $color;?>;
}
a:hover, a:focus, a:active {
color:  <?php echo $color;?>;
}


.contact-form button {
background: <?php echo $color;?>;
border: 2px solid <?php echo $color;?>;
}

.contact-form h2 {
color: <?php echo $color;?>;
}

.contact-form input[type="text"], .contact-form input[type="email"], .contact-form input[type="password"], .contact-form select, .contact-form select option, .contact-form textarea
{
border: 1px solid <?php echo $color;?>;
}

.section-header h3> span{
color: <?php echo $color;?>;
}

.section-header p:before {
content: "";
position: absolute;
top: 50%;
right: 36%;
background-color: <?php echo $color;?>;
width: 120px;
height: 3px;
-ms-transform: translate(0%, -50%);
-webkit-transform: translate(0%, -50%);
transform: translate(0%, -50%);
}


.section-header p:after {
content: "";
position: absolute;
top: 50%;
left: 36%;
background-color:<?php echo $color;?>;
width: 120px;
height: 3px;
-ms-transform: translate(0%, -50%);
-webkit-transform: translate(0%, -50%);
transform: translate(0%, -50%);
}


.accordion .panel-heading a, .faq-categories ul li a:hover, .faq-categories ul li.active a {
background-color: <?php echo $color;?>;
color: #000;
font-weight: bold;
}

.accordion .panel-heading h4 a.collapsed {
background-color: <?php echo $color;?>;
}

.panel-group .panel {
border: 1px solid <?php echo $color;?>;
}

.panel-group .panel:last-child {
border-bottom: 1px solid <?php echo $color;?>;
}

.support-bar-top .contact-admin .support-bar-social-links a i:hover {
color: <?php echo $color;?>;
}

.footer-bottom .footer-menu ul li a:hover {
color: <?php echo $color;?>;
}

.login-admin .login-form input[type="email"], .login-admin .login-form input[type="password"], .login-admin .login-form input[type="text"] {
border: 1px solid  <?php echo $color;?>;
}


.pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
z-index: 3;
color: #fff;
cursor: default;
background-color: <?php echo $color;?>;
border-color: <?php echo $color;?>;
}
.view-more,
.view-more:hover,
.view-more:focus
{
background-color: <?php echo $color;?>;
border-color: <?php echo $color;?>;
}
.pagination>li>a:focus, .pagination>li>a:hover, .pagination>li>span:focus, .pagination>li>span:hover {
z-index: 2;
color: <?php echo $color;?>;
background-color: #eee;
border-color: #ddd;
}

.header-wrapper .navbar-default .navbar-collapse.collapse .navbar-nav li a::before
{
background:  <?php echo $color;?>;
}


.contact-info .contact-content .contact-list ul li .contact-thumb i
{
color: #100f0f;
}
.contact-form h2:after {
background-color: #344153;
}


.footer-support-list ul li:hover .footer-thumb i {
background-color: <?php echo $color;?>;
}

.right a,
.left a{
color: <?php echo $color;?>;
}

.footer-bottom {
border-top: 1px solid <?php echo $color;?>;
}


.live-matches-sidebar ul li {
list-style: none;
background: #005A41;
padding: 12px 10px;
font-size: 12px;
border-left: 5px solid <?php echo $color;?>;
font-weight: 600;
margin-bottom: 5px;
margin-left: 5px;
}

.live-matches-sidebar ul li a {
text-decoration: none;
color: #fff;
}

.bs-callout{
background-color: #131C24;
}


input[type=button].btn-block, input[type=reset].btn-block, input[type=submit].btn-block
{
background-color: <?php echo $color;?>;

}

input[type="text"], input[type="email"], input[type="url"], input[type="password"], input[type="search"], input[type="tel"], input[type="number"], textarea
{
border: 1px solid <?php echo $color;?>;
}

.select {
border: 1px solid <?php echo $color;?>;
}

.videoWrapper {
position: relative;
padding-bottom: 56.25%; /* 16:9 */
padding-top: 25px;
height: 0;
}
.videoWrapper iframe {
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
}

.footer-support-list ul li .footer-thumb i {
font-size: 55px;
}

.bg-white{
background-color: #fff !important;
}


.inplay_title {
	 background: <?php echo $color;?>;
	 border-radius: 4px;
}


.login-admin .login-form input[type="submit"]:hover {
	background-color: #1A2734;
    border: 1px solid <?php echo $color;?>;
}


.portlet.box.blue {
	border: 1px solid <?php echo $color;?>;
}

.portlet.blue, .portlet.box.blue > .portlet-title, .portlet > .portlet-body.blue {
	background-color: <?php echo $color;?>;
}

.portlet.box > .portlet-body {
	padding: 15px;
}

.panel-primary > .panel-heading {
	color: #fff;
	background-color: <?php echo $color;?>;
	border-color: <?php echo $color;?>;
}
.panel-primary {
	border-color: <?php echo $color;?>;
}


.panel-footer {
	padding: 10px 15px;
	border-bottom-right-radius: 3px;
	border-bottom-left-radius: 3px;
}

.btn-primary {
	color: #fff;
	background-color: <?php echo $color;?>;
	border-color: <?php echo $color;?>;
	}
	
	
.btn-primary:hover {
	color: #fff;
	background-color: #1A2734;
	border-color: <?php echo $color;?>;
}


.thumbnail {
	display: block;
	padding: 4px;
	margin-bottom: 20px;
	line-height: 1.42857143;
	border: 1px solid #ddd;
	border-radius: 4px;
	-webkit-transition: border .2s ease-in-out;
	-o-transition: border .2s ease-in-out;
	transition: border .2s ease-in-out;
}


<!--.table-striped > tbody > tr:nth-of-type(2n+1) {-->
<!--background-color: #1A2734;-->
<!--}-->

.table-hover > tbody > tr:hover {
}

.table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
border: 1px solid #131C24;
}
.table-bordered {
border: 1px solid #131C24;
}


.table > thead > tr > th{
text-align : center;
text-transform:uppercase;
color: <?php echo $color;?>;
font-weight: bold;
}


.greenbg{
color: #2ecc71;
}

.redbg{
color: #e74c3c;
}

.input-group-addon {
color: #f1f1f1;
text-align: center;
background-color: <?php echo $color;?>;
border: 1px solid  <?php echo $color;?>;
}

.modal .modal-header {
border-bottom: 1px solid  <?php echo $color;?>;
}

.modal-footer {

border-top: 1px solid <?php echo $color;?>;
}

h1, h2, h3, h4, h5, h6 {
color: <?php echo $color;?>;
}

.list-group-item {
position: relative;
display: block;
padding: 10px 15px;
margin-bottom: -1px;
border: 1px solid <?php echo $color;?>;
}

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control
{
color: #1A2734;
}

.form-control{
border: 1px solid <?php echo $color;?>;
}

.form-control:focus{
border: 1px solid #f1f1f1;
}


.well{
background-color:<?php echo $color;?>;
border: 1px solid <?php echo $color;?>;

}

hr{
border-top: 1px solid <?php echo $color;?>;
}


.showadd {
margin: 0 0 20px 0;
}


.sk-circle .sk-child:before {
  background-color: <?php echo $color;?>;
}


.contact-form button:hover {
	border: 1px solid <?php echo $color;?>;
}