<style type="text/css">

* {
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}


/* ---- grid ---- */

.grid {
	<?php if($id=='screen') { ?>
   	width: 800px;
   <?php } ?>
}

/* clearfix */
.grid:after {
  content: '';
  display: block;
  clear: both;
}

/* ---- grid-item ---- */

.grid-item {
    width: 340px;
    float: left;
    border-radius: 5px;
}

</style>



<div class="grid">
    <div class="grid-sizer"></div>
    <?php
    
    //GROUPS
    $rows = $db->query("SELECT ch_group,type FROM sensors");
	$result_ch_g = $rows->fetchAll();
	$unique=array();
	$unique=array();
	
	foreach($result_ch_g as $uniq) {
		if(!empty($uniq['ch_group'])&&!in_array($uniq['ch_group'], $unique)) {
			$unique[]=$uniq['ch_group'];
			$ch_g=$uniq['ch_group'];
			$uniquet[]=$uniq['type'];
			$ch_t=$uniq['type'];
			include('status/sensor_groups.php');
		}
	}
	
	//END GROUPS
	
    include('status/justgage_status.php');
    include('status/minmax_status.php');
    include('status/gpio_status.php');
    include('status/counters_status.php');
    include('status/meteo_status.php');
    foreach (range(1, 10) as $v) {
		$ow=$v;
		include('status/ownwidget.php');
    }
    include('status/ipcam_status.php');
    include('status/ups_status.php');
    ?>
</div>

<script type="text/javascript">
    setInterval( function() {

    <?php
		foreach ($unique as $key => $ch_g) { 
	?>
		$('.sg<?php echo $ch_g?>').load("status/sensor_groups.php?ch_g=<?php echo $ch_g?>");
	<?php
		}
	?>
    $('.co').load("status/counters_status.php");
    $('.gs').load("status/gpio_status.php");
    $('.ms').load("status/meteo_status.php");
    $('.ow2').load("status/ownwidget2.php");
    $('.ow3').load("status/ownwidget3.php");
    $('.mm').load("status/minmax_status.php");
    $('.ups').load("status/ups_status.php");
    $('#justgage_refresh').load("status/justgage_refresh.php");
}, 6000);

$(document).ready( function() {

  $('.grid').masonry({
    itemSelector: '.grid-item',
    columnWidth: 350
  });
  
});
</script>
<script src="html/masonry/masonry.pkgd.min.js"></script>
<div id="justgage_refresh"></div>

