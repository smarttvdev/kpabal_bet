

<?php
header ("Content-Type:text/css");
$bg_color = "#f0f"; // Change your Color Here

function checkhexcolor($bg_color) {
    return preg_match('/^#[a-f0-9]{6}$/i', $bg_color);
}

if( isset( $_GET[ 'bg_color' ] ) AND $_GET[ 'bg_color' ] != '' ) {
    $bg_color = "#".$_GET[ 'bg_color' ];
}

if( !$bg_color OR !checkhexcolor( $bg_color ) ) {
    $bg_color = "#336699";
}

?>



@import url('https://fonts.googleapis.com/css?family=Montserrat:400,400i,500,500i,600,600i,700,700i,800,800i');


.navbar-default {
background-color:<?php echo $bg_color;?>;
border-color: <?php echo $bg_color;?> ;
}

.panel{
}
.footer-support-list {
text-align: center;
/*border-bottom: 8px solid #131C24;*/
background-color: <?php echo $bg_color;?>;
}
.header-wrapper .navbar-default .navbar-collapse.collapse .navbar-nav li .mega-menu1{
background-color: <?php echo $bg_color;?>;
}

button.copy {
background-color: <?php echo $bg_color;?>;
}
button.copy:active:hover ,
button.copy:hover ,
button.copy:focus
{
background-color: <?php echo $bg_color;?>;
border-color: <?php echo $bg_color;?>;
}
.custom-panel-bg{
background-color: <?php echo $bg_color;?>;
}
