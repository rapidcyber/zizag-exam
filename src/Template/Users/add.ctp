<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Manage User');
?>
<div class="users form">
<?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?= $this->Form->control('username') ?>
        <?= $this->Form->control('password') ?>
        <?= $this->Form->control('role', [
            'options' => ['admin' => 'Admin', 'non-admin' => 'Non-admin']
        ]) ?>
   </fieldset>
   <fieldset>
     <?= $this->Form->button(__('Save')); ?>
   </fieldset>

<?= $this->Form->end() ?>
</div>
