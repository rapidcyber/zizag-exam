<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PhoneNumber $phoneNumber
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $phoneNumber->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $phoneNumber->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Phone Numbers'), ['action' => 'index']) ?></li>
      <?php if($this->request->session()->read('Auth.User.role') == 'admin'):?>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
      <?php endif;?>
    </ul>
</nav>
<div class="phoneNumbers form large-9 medium-8 columns content">
    <?= $this->Form->create($phoneNumber) ?>
    <fieldset>
        <legend><?= __('Edit Phone Number') ?></legend>
        <?php
            echo $this->Form->control('phone');
            echo $this->Form->control('user_id', ['options' => $users]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
