<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users form">
<?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Registration') ?></legend>
        <?= $this->Form->control('username') ?>
        <?= $this->Form->control('password') ?>
   </fieldset>
   <fieldset>
     <?= $this->Form->button(__('Signup')); ?>
   </fieldset>

<?= $this->Form->end() ?>
</div>
