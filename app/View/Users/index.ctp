<h1>Blog users</h1>
<a href="<?= Router::url(array('controller' => 'users', 'action' => 'add')); ?>">Añadir</a>
<table>
    <tr>
        <th><?php echo $this->Paginator->sort('id'); ?></th> -->
        <th><?php echo $this->Paginator->sort('name'); ?></th>
        <th><?php echo $this->Paginator->sort('email'); ?></th>
        <th><?php echo $this->Paginator->sort('username'); ?></th>
        <th class="actions"><?php echo __('Actions'); ?></th>
    </tr>

    <? foreach ($users as $user): ?>
    <tr>
        <td><? echo $user['User']['id']; ?></td>
        <td><? echo $user['User']['name']; ?></td>
        <td><? echo $user['User']['email']; ?></td>
        <td><? echo $user['User']['username']; ?></td>
        <td>
            <? echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id']));?>
            <? echo $this->Form->postLink(
                'Delete',
                array('action' => 'delete', $user['User']['id']),
                array('confirm' => 'Are you sure?')
            )?>
        </td>
    </tr>
    <? endforeach; ?>

</table>