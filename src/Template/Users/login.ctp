<?php $this->assign('title','Login'); ?>
<div class="users form">
<?= $this->Flash->render() ?>
<?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Please enter your username and password') ?></legend>
        <?= $this->Form->control('username') ?>
        <?= $this->Form->control('password') ?>
    </fieldset>
    <fieldset>
      <?= $this->Form->button(__('Login')); ?>
    </fieldset>

<?= $this->Form->end() ?>
</div>
