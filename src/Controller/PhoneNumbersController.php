<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PhoneNumbers Controller
 *
 * @property \App\Model\Table\PhoneNumbersTable $PhoneNumbers
 *
 * @method \App\Model\Entity\PhoneNumber[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PhoneNumbersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

      $this->paginate = [
          'limit' => 10,
          'contain' => ['Users']
      ];

      if($this->Auth->user('role') != 'admin'){
        $this->paginate = [
            'limit' => 10,
            'contain' => ['Users'],
            'conditions' => [
              'user_id' => $this->Auth->user('id')
            ]
        ];
      }


        $phoneNumbers = $this->paginate($this->PhoneNumbers);

        $this->set(compact('phoneNumbers'));
    }

    /**
     * View method
     *
     * @param string|null $id Phone Number id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $phoneNumber = $this->PhoneNumbers->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('phoneNumber', $phoneNumber);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $phoneNumber = $this->PhoneNumbers->newEntity();
        if ($this->request->is('post')) {
            $phoneNumber = $this->PhoneNumbers->patchEntity($phoneNumber, $this->request->getData());
            if($this->Auth->user('role') != 'admin'){
              $phoneNumber->user_id = $this->Auth->user('id');
            }
            if ($this->PhoneNumbers->save($phoneNumber)) {
                $this->Flash->success(__('The phone number has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The phone number could not be saved. Please, try again.'));
        }
        $users = $this->PhoneNumbers->Users->find('list', ['limit' => 200]);
        $this->set(compact('phoneNumber', 'users'));
    }

    public function admin_add($userId = null){
      $phoneNumber = $this->PhoneNumbers->newEntity();
    }
    /**
     * Edit method
     *
     * @param string|null $id Phone Number id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $phoneNumber = $this->PhoneNumbers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $phoneNumber = $this->PhoneNumbers->patchEntity($phoneNumber, $this->request->getData());
            if ($this->PhoneNumbers->save($phoneNumber)) {
                $this->Flash->success(__('The phone number has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The phone number could not be saved. Please, try again.'));
        }
        $users = $this->PhoneNumbers->Users->find('list', ['limit' => 200]);
        $this->set(compact('phoneNumber', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Phone Number id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $phoneNumber = $this->PhoneNumbers->get($id);
        if ($this->PhoneNumbers->delete($phoneNumber)) {
            $this->Flash->success(__('The phone number has been deleted.'));
        } else {
            $this->Flash->error(__('The phone number could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user)
    {
        // All registered users can add articles
        // Prior to 3.4.0 $this->request->param('action') was used.
        if ($this->request->getParam('action') === 'add') {
            return true;
        }

        if ($this->request->getParam('action') === 'index') {
            return true;
        }

        // The owner of an article can edit and delete it
        // Prior to 3.4.0 $this->request->param('action') was used.
        if (in_array($this->request->getParam('action'), ['edit', 'delete','view'])) {
            // Prior to 3.4.0 $this->request->params('pass.0')
            $phoneNumberId = (int)$this->request->getParam('pass.0');
            if ($this->PhoneNumbers->isOwnedBy($phoneNumberId, $user['id'])) {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }

}
