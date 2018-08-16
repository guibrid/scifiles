    <?= $this->Html->css('custom') ?>
<div>
    <div class="login_wrapper">
        <div class="animate form login_form">
<div class="logo"><?= $this->Html->image('logo.png') ?></div>
            <section class="login_content">

                <h3>Espace client</h3>

                <?= $this->Form->create() ?>
                    <div>
                        <?= $this->Form->control('username',['class'=>'form-control','placeholder'=>'Identifiant','label'=>false,'required'=>true]) ?>
                    </div>
                    <div>
                        <?= $this->Form->control('password',['class'=>'form-control','placeholder'=>'Mot de passe','label'=>false,'required'=>true]) ?>
                    </div>
                    <div>
                        <?= $this->Form->button(__('Connexion'),['class'=>'btn btn-primary btn-block btn-flat']); ?>

                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <div class="clearfix"></div>
                        <br />

                        <div>
                            <p>© SC International</p>
                        </div>
                    </div>
                <?= $this->Form->end() ?>
            </section>
        </div>
    </div>
</div>
