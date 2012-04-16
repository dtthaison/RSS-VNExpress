<p>
	<label>Title: <input  name="title" type="text" value="<?php echo $title; ?>" /></label>
	<input type="hidden" id="wall_submit" name="submit" value="1" />
</p>
<p>
	<label>Rss Feed: </label>
	<select name="cate">
		<?php foreach($rss as $key => $item) { ?>
		<option value="<?php echo $key?>" 
		<?php  if ($key == $cate ) echo 'selected="selected"'; ?>><?php echo $item['title']?></option>
		<?php }?>
	</select>
</p>
<p>
	<label>Limit: <input  name="limit" type="text" value="<?php if(empty($limit)) echo "50"; else echo $limit; ?>" /></label>
</p>