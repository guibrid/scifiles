<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\File[]|\Cake\Collection\CollectionInterface $files
  */
?>
<h3><?= __('Téléchargez vos fichiers') ?></h3>
<?php if( isset($is_admin) && $is_admin === 1 ) { ?>
<?= $this->element('filesaction') ?>
<?php } ?>

<div class="x_panel">
  <div class="x_title">
    <h2><i class="fa fa-bars"></i> Vos documents</h2>

    <div class="clearfix"></div>
  </div>
  <div class="x_content">


    <div class="" role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Catalogues et bons de commande</a>
        </li>
        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Factures</a>
        </li>
      </ul>
      <div id="myTabContent" class="tab-content">
        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

          <div class="files index x_content content">
              <table  class="table table-striped">
                  <thead>
                      <tr>
                          <th scope="col">Nom du fichier</th>
                          <?php if( isset($is_admin) && $is_admin === 1 ) { ?>
                          <th scope="col">Tarif</th>
                          <?php } ?>
                          <th scope="col">Mise en ligne le</th>
                          <th scope="col" class="actions"><?= __('Téléchargement') ?></th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($catalogues as $file): ?>
                      <tr>
                          <td><?= h($file->name) ?></td>
                          <?php if( isset($is_admin) && $is_admin === 1 ) { ?>
                          <td><?= $file->tarif->name ?></td>
                          <?php } ?>
                          <td><?= $file->modified->format('d-m-Y') ?></td>
                          <td class="actions">
                            <?= $this->Html->link(
                                   '<i class="fa fa-download fa-2x"></i>',
                                    [ 'action'=>'download', $file->id ],
                                    [ 'escape'              => false,  //use HTML en libellé
                                      'class'               => 'icon',
                                      'title'               => 'Téléchargez le fichier',
                                      'target'              => '_blank' ] ) ?>
                            <?php if( isset($is_admin) && $is_admin === 1 ) { ?>
                              <?= $this->Html->link(
                                     '<i class="fa fa-trash-o fa-2x"></i>',
                                      [ 'action'=>'delete', $file->id ],
                                      [ 'escape'              => false,  //use HTML en libellé
                                        'class'               => 'icon',
                                        'confirm'             => __('Are you sure you want to delete {0}?', $file->name),
                                        'title'               => 'Supprimer le fichier' ] ) ?>
                            <?php } ?>
                          </td>
                      </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
          </div>

        </div>
        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

          <div class="files index x_content content">
              <table  class="table table-striped">
                  <thead>
                      <tr>
                          <th scope="col">Nom du fichier</th>
                          <?php if( isset($is_admin) && $is_admin === 1 ) { ?>
                          <th>Client</th>
                          <?php } ?>
                          <th scope="col">Mise en ligne le</th>
                          <th scope="col" class="actions"><?= __('Téléchargement') ?></th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($factures as $file): ?>
                      <tr>
                          <td><?= h($file->name) ?></td>
                          <?php if( isset($is_admin) && $is_admin === 1 ) { ?>
                          <td><?= $file->user->username ?></td>
                          <?php } ?>
                          <td><?= $file->created->format('d-m-Y') ?></td>
                          <td class="actions">
                            <?= $this->Html->link(
                                   '<i class="fa fa-download fa-2x"></i>',
                                    [ 'action'=>'download', $file->id ],
                                    [ 'escape'              => false,  //use HTML en libellé
                                      'class'               => 'icon',
                                      'title'               => 'Téléchargez le fichier',
                                      'target'              => '_blank' ] ) ?>
                            <?php if( isset($is_admin) && $is_admin === 1 ) { ?>
                              <?= $this->Html->link(
                                     '<i class="fa fa-trash-o fa-2x"></i>',
                                      [ 'action'=>'delete', $file->id ],
                                      [ 'escape'              => false,  //use HTML en libellé
                                        'class'               => 'icon',
                                        'confirm'             => __('Are you sure you want to delete {0}?', $file->name),
                                        'title'               => 'Supprimer le fichier' ] ) ?>
                            <?php } ?>
                          </td>
                      </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
          </div>

        </div>

      </div>
    </div>

  </div>
</div>
