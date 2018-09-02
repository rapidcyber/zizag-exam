<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PhoneNumber $phoneNumber
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Phone Number'), ['action' => 'edit', $phoneNumber->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Phone Number'), ['action' => 'delete', $phoneNumber->id], ['confirm' => __('Are you sure you want to delete # {0}?', $phoneNumber->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Phone Numbers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Phone Number'), ['action' => 'add']) ?> </li>
      <?php if($this->request->session()->read('Auth.User.role') == 'admin'):?>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
      <?php endif;?>
    </ul>
</nav>
<div class="phoneNumbers view large-9 medium-8 columns content">
    <h3><?= h($phoneNumber->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Phone') ?></th>
            <td><?= h($phoneNumber->phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $phoneNumber->has('user') ? $this->Html->link($phoneNumber->user->id, ['controller' => 'Users', 'action' => 'view', $phoneNumber->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($phoneNumber->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($phoneNumber->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($phoneNumber->modified) ?></td>
        </tr>
    </table>
</div>
