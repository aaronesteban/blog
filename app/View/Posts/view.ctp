<label>Tema: <? echo $post['Tema']['name']; ?></label>
<br></br>
<h1><?php echo $post['Post']['title']?></h1>

<p><small>Created: <?php echo $post['Post']['created']?></small></p>

<p><?php echo $post['Post']['body']?></p>

<? foreach ($post['Image'] as $img): ?>
	<br></br>
	<?= $this->Html->image("/files/".$img['name'], array('width' => '300')); ?>
	<br></br>
<? endforeach; ?>

<? foreach ($post['Video'] as $video): ?>
	<?if ($video['clase'] === 'youtube'): ?>
	    <iframe width="300" height="200" src="https://www.youtube.com/embed/<?= $video['name'];?>" frameborder="0" allowfullscreen></iframe>
	<?elseif ($video['clase'] === 'vimeo'): ?>
	    <iframe width="300" height='200' src="//player.vimeo.com/video/<?=$video['name']; ?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>    
	<?endif;?>    
<? endforeach; ?>


	