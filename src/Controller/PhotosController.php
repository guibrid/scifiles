<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Photos Controller
 *
 * @property \App\Model\Table\PhotosTable $Photos
 *
 * @method \App\Model\Entity\Photo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PhotosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */

    public function display($id = null)
    {
        $photo = $this->Photos->get($id);
        $this->response->file( ROOT . DS . 'assets/product_pictures' . DS . $photo->url);

        return $this->response;

    }

    public function index()
    {
        $this->paginate = [
            'contain' => ['Products']
        ];
        $photos = $this->Photos->find()->limit(1)->contain('Products');

        //$toto = $this->display(2);
        
        $this->set(compact('photos'));
    }

    /**
     * View method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $photo = $this->Photos->get($id, [
            'contain' => ['Products']
        ]);

        $this->set('photo', $photo);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $photo = $this->Photos->newEntity();
        if ($this->request->is('post')) {
            $photo = $this->Photos->patchEntity($photo, $this->request->getData());
            if ($this->Photos->save($photo)) {
                $this->Flash->success(__('The photo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The photo could not be saved. Please, try again.'));
        }
        $products = $this->Photos->Products->find('list', ['limit' => 200]);
        $this->set(compact('photo', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $photo = $this->Photos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $photo = $this->Photos->patchEntity($photo, $this->request->getData());
            if ($this->Photos->save($photo)) {
                $this->Flash->success(__('The photo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The photo could not be saved. Please, try again.'));
        }
        $products = $this->Photos->Products->find('list', ['limit' => 200]);
        $this->set(compact('photo', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $photo = $this->Photos->get($id);
        if ($this->Photos->delete($photo)) {
            $this->Flash->success(__('The photo has been deleted.'));
        } else {
            $this->Flash->error(__('The photo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * find method
     * List all the 'new' product and search in google image api images
     * donwload and save the google image selected as picture product
     */
    public function find()
    {
        if ($this->request->is(['post'])) {
            
            $datas = $this->request->getData();

            // Download image
            // Rename and resize image
            // upload on siteground serveur
            // Save image data in photos table
            $query = $this->Photos->query();
            foreach ($datas['product'] as $key => $value) {
                //Formatage des données pour l'insert/update
                if(isset($value['url']) || !empty($value['customLink'])) {
                    if(isset($value['url'])) { 
                        $url = $value['url'];
                    } else {
                        $url = $value['customLink'];
                    }
                    $photoData = ['url' => $url,
                                  'product_id' => $value['id'], 
                                  'type' => 0, 
                                  'active'=> 2];
                } else {
                    $photoData = ['url' => '-',
                                  'product_id' => $value['id'], 
                                  'type' => 0, 
                                  'active'=> -1];
                }

                //Check si une photo existe
                $nbrPhotos = $this->Photos->find()->where(['product_id' => $value['id']])->count();
                //debug($nbrPhotos);
                if($nbrPhotos === 0){ // Si aucun enregistrement n'hesite pour cette photo/produit on insert
                    $query->insert(['url', 'product_id', 'type', 'active'])
                          ->values($photoData);
                } else {
                    $query->update()
                          ->set($photoData)
                          ->where(['product_id' => $value['id']]); 
                }

            }

            $query->execute();
            
         
        }
        // List all 'NEW' Product with no photo existing
        $products = TableRegistry::get('Products');
        $productQuery = $products->find('all')
                                    //->where(['new' => 1, 'Products.active' <> 2, 'Photos.product_id IS'=> null])
                                    //         'OR' => [['Photos.product_id IS'=> null], ['Photos.url' => '-']]])
                                    //->where(['Photos.product_id IS'=> null, 'Products.active' => 1, 'new' => 1, ])
                                    //->where(['Photos.product_id IS'=> null, 'Products.active' => 1 ])
                                    ->leftJoinWith('Photos')
                                    ->limit(1);
                                    //->contain(['Photos', 'Brands', 'Origins', 'Categories', 'Subcategories']);
        
        $this->set(compact('productQuery'));

    }
}
