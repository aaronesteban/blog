<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<h1>Add Post</h1>
<?
echo $this->Form->create('Post', array('type' => 'file'));
echo $this->Form->input('title', array('placeholder'=>'Inserte aqui', 'label'=>'Título'));
echo $this->Form->input('body', array('rows'=>'3', 'label' => 'Texto'));
echo $this->Form->input('tema_id', array('options' => $temas, 'type'=>'select', 'empty' => ''));
echo $this->Form->create('Video', array('type' => 'file'));
echo $this->Form->input('name', array('rows'=>'1', 'placeholder'=>'Inserte aqui la url de youtube o vimeo.', 'label' =>'Video'));
?>

<div class="input_files"></div>
<a href="#" id="insertar_img">Insertar imagen</a>

<? echo $this->Form->end('Save Post'); ?>

<script type="text/javascript">
	var num_inputs = 0;
	var input_img = '<div class="input file"><label>Image</label><input type="file"></div>';

	$('#insertar_img').click(function(e){
		e.preventDefault();
		var input = $(input_img).children('input').prop('name', 'data[File]['+num_inputs+'][file]');
		num_inputs++;
		$('.input_files').append( input );
	});
</script>