<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;
use App\Utility\Toolbox;

/**
 * Files Model
 *
 * @property \App\Model\Table\TarifsTable|\Cake\ORM\Association\BelongsTo $Tarifs
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\File get($primaryKey, $options = [])
 * @method \App\Model\Entity\File newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\File[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\File|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\File|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\File patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\File[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\File findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FilesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('files');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Tarifs', [
            'foreignKey' => 'tarif_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');


        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['tarif_id'], 'Tarifs'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }


    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
      // Si c'est un catalogue on met vide user_id
      if( $data['type'] == '1') {
        $data['user_id'] = '';
      // Si c'est une facture on met vide tarif_id
      } else if ( $data['type'] == '2') {
        $data['tarif_id'] = '';
      }

      // Renomer le non du fichier et du dossier lors de l'ajoute
      if(isset($data['filename'])) {
        $fileUpload = Toolbox::uploadFile(['file' => $data['filename'], 'validExtension' => [ 'zip']]);
        $data['filename'] = $fileUpload['filename'];  // Récupére le nom final du fichier
        $data['filedossier'] = $fileUpload['folder']; // Récupère le dossier de destiation
      }
    
    }
}
