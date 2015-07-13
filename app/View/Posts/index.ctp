<a href="<?= Router::url(array('controller' => 'posts', 'action' => 'add')); ?>">Añadir</a>

<table>
    <tr>
        <!-- <th>Id</th> -->
        <th><?php echo $this->Paginator->sort('title', 'Titulo'); ?></th>
        <th><?php echo $this->Paginator->sort('tema_id'); ?></th>
        <th>Images</th>
        <th>Videos</th>
        <th><?php echo $this->Paginator->sort('created', 'Creado'); ?></th>
        <th class="actions"><?php echo __('Actions'); ?></th>
    </tr>

    <? foreach ($posts as $post): ?>
    <tr>
        <td>
            <? echo $this->Html->link($post['Post']['title'],
			array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])); ?>
        </td>
        <td><? echo $post['Tema']['name']; ?></td>
        <td>
            <? foreach ($post['Image'] as $img): ?>
                <?= $this->Html->image("/files/".$img['name'], array('width' => '20')); ?>
            <? endforeach; ?>
        </td>
        <td>
            <? foreach ($post['Video'] as $video): ?>
                <?= $this->Html->image("/img/".'play.png', array('width' => '20')); ?>
            <? endforeach; ?>
        </td>
        <td><? echo $post['Post']['created']; ?></td>
        <td>
            <? echo $this->Html->link('Edit', array('action' => 'edit', $post['Post']['id']));?>
            &nbsp;&nbsp;&nbsp;
            <? echo $this->Form->postLink(
                'Delete',
                array('action' => 'delete', $post['Post']['id']),
                array('confirm' => 'Are you sure?')
            )?>
        </td>
    </tr>
    <? endforeach; ?>
</table>
<?echo $this->Paginator->numbers(array('first' => 2, 'last' => 2));?>

<div>
    <?foreach ($temas as $tema_id => $tema):?>
        <? echo $this->Html->link($tema,
            array('controller' => 'posts', 'action' => 'index', 'tema'=>$tema_id)); ?>
    <?endforeach;?>
</div>
<div>
    <?foreach ($fechas as $fecha_id => $fecha): ?>
        <a href="<?= Router::url(array('controller' => 'posts', 'action' => 'index', 'fecha'=>$fecha_id)); ?>"><?=$fecha?></a>
    <?endforeach;?>
</div>