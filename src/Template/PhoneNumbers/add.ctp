<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PhoneNumber $phoneNumber
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Phone Numbers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="phoneNumbers form large-9 medium-8 columns content">
    <?= $this->Form->create($phoneNumber) ?>
    <fieldset>
        <legend><?= __('Add Phone Number') ?></legend>
        <?php
            echo $this->Form->control('phone');
            if($this->request->session()->read('Auth.User.role') == 'admin'){
              echo $this->Form->control('user_id', ['options' => $users]);
            }
        ?>
        <?= $this->Form->button(__('Submit')) ?>
    </fieldset>

    <?= $this->Form->end() ?>
</div>
