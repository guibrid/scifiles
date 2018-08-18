<?php
namespace App\Shell;
use Cake\Console\Shell;

class DeleteinvoiceShell extends Shell
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Files');
    }

    public function main()
    {
      // Rechercher toutes les factures qui ont été télécharger,
      // et supprimer le fichier sans la base et physiquement
      $files = $this->Files->find()
                           ->where(['downloaded >' => 0, 'type' => 2]);

       foreach ($files as $file) {
         unlink(WWW_ROOT . 'files/catalogues/'.$file->filedossier.'/'.$file->filename);//Supprimer le fichier
         rmdir(WWW_ROOT . 'files/catalogues/'.$file->filedossier.'/'); //Supprimer le dossier
         $this->Files->delete($file);
       }


    }
}
