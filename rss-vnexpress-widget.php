<?php 
	//echo'<pre>';var_dump($feedfile);
	foreach($feedfile->items as $key=>$item) {
		if ($key < $limit) {
		$title = $item['title'];
		$link = $item['link'];
		$desc = $item['description'];
		$pub_date = $item['pubdate'];
?>
<div class="vne-item">
	<h4><a href="<?php echo $item['link'];?>"><?php echo $title?></a></h4>
	<p class="vne-desc"><?php echo $desc?></p>
	<p class="vne-pubdate"><?php echo $pub_date?></p>
	<div style="clear:both;"></div>
</div>
<?php 
		}
	}
?>
