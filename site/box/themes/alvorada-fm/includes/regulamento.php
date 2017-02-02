<?php $styles = 'style=letter-spacing:0.5px;line-height:18px;padding-right:30px;padding-left:30px;padding-bottom:15px;padding-top:15px;font-family:Arial;font-size:13px;'; ?>

<a  href="javascript:
var myWindow = window.open('', 'Regulamento', 'width=500px,height=500px');
myWindow.document.write('<div <?php echo $styles; ?> ><p><?php echo get_field( 'regulamento' ) ?></p></div>');">Leia o regulamento</a>