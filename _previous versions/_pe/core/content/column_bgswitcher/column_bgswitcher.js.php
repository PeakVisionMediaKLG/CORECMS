<?php 
$mypath = substr($ContentData['path'][0], 0, strrpos( $ContentData['path'][0], '/') );
$mypath = substr($mypath, 1);

$myimages = glob($mypath.'/*.{jpg,png,gif}', GLOB_BRACE);
$myimagesjoined = "";
foreach($myimages as $file) {
    $myimagesjoined .= "'".$file."', "; 
}

$myimagesjoined = substr($myimagesjoined, 0, -2);
?>

<script>
$(".core-bgswitcher-<?php echo $ContentBasics['cUID']; ?>").bgswitcher({
    images: [<?php echo $myimagesjoined; ?>],
    loop: <?php echo $ContentData['customselect'][1]; ?>,
    effect: "<?php echo $ContentData['customselect'][0]; ?>",
    shuffle: <?php echo $ContentData['customselect'][2]; ?>,
    interval: <?php echo $ContentData['custominput'][0]; ?>,
    duration: <?php echo $ContentData['custominput'][1]; ?>
});

/*,easing: "<?php echo $ContentData['custominput'][2]; ?>"*/
</script>