<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * File Entity
 *
 * @property int $id
 * @property string $name
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $filename
 * @property string $filedossier
 * @property int $tarif_id
 * @property int $user_id
 * @property int $type
 *
 * @property \App\Model\Entity\Tarif $tarif
 * @property \App\Model\Entity\User $user
 */
class File extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'created' => true,
        'modified' => true,
        'filename' => true,
        'filedossier' => true,
        'tarif_id' => true,
        'user_id' => true,
        'type' => true,
        'tarif' => true,
        'user' => true
    ];
}
