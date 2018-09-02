<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public $paginate = [];

      public function beforeFilter(Event $event)
      {
          parent::beforeFilter($event);
          // Allow users to register and logout.
          // You should not add the "login" action to allow list. Doing so would
          // cause problems with normal functioning of AuthComponent.
          $this->Auth->allow(['register', 'logout']);
      }

      public function login()
      {
        if($this->Auth->user()) {
         return $this->redirect(['action' => 'index']);
        }

          if ($this->request->is('post')) {
              $user = $this->Auth->identify();
              if ($user) {
                  $this->Auth->setUser($user);
                  return $this->redirect($this->Auth->redirectUrl());
              }
              $this->Flash->error(__('Invalid username or password, try again'));
          }
      }

      public function logout()
      {
          return $this->redirect($this->Auth->logout());
      }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
      $users = [];
      $phoneNumbers = [];
      $client = [];
      $logged = $this->Auth->user();
      if($logged){

        if($this->Auth->user('role') == 'admin'){
          $this->paginate = [
            'limit' => 10
          ];
          $users = $this->paginate($this->Users);
        } else {
          $client = $this->Users->get($this->Auth->user('id'),[
            'contain' => []
          ]);
        }
      }

      $this->set(compact('users', 'phoneNumbers','client', 'logged'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {


        $user = $this->Users->get($id, [
            'contain' => ['PhoneNumbers']
        ]);

        $this->paginate = [
          'limit' => 10,
          'conditions' => [
            'user_id' => $user->id
          ]
        ];
        //debug($user['phone_numbers']);die();
        $phoneNumbers = $this->paginate('PhoneNumbers');

        $this->set(compact('user', 'phoneNumbers'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

      $user = $this->Users->newEntity();
      if ($this->request->is('post')) {
          // Prior to 3.4.0 $this->request->data() was used.
          $user = $this->Users->patchEntity($user, $this->request->getData());
          if ($this->Users->save($user)) {
              $this->Flash->success(__('The user has been saved.'));
              return $this->redirect(['action' => 'index']);
          }
          $this->Flash->error(__('Unable to add the user.'));
      }
      $this->set('user', $user);
    }

    /*
     * Register method
     */
    public function register(){
      $user = $this->Users->newEntity();
      if ($this->request->is('post')) {
          // Prior to 3.4.0 $this->request->data() was used.
          $user = $this->Users->patchEntity($user, $this->request->getData());
          debug($user);die();
          $user['role'] = 'non-admin';
          if ($this->Users->save($user)) {
              $this->Flash->success(__('The user has been saved.'));
              return $this->redirect(['action' => 'add']);
          }
          $this->Flash->error(__('Unable to add the user.'));
      }
      $this->set('user', $user);
    }
    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // $role = $this->Auth->user('role');
        // debug($this->Auth->user('id') == $id);die();
        // if($this->Auth->user('id') == $id || $role == 'admin'){
          $user = $this->Users->get($id, [
              'contain' => []
          ]);
          if ($this->request->is(['patch', 'post', 'put'])) {
              $user = $this->Users->patchEntity($user, $this->request->getData());
              if ($this->Users->save($user)) {
                  $this->Flash->success(__('The user has been saved.'));

                  return $this->redirect(['action' => 'index']);
              }
              $this->Flash->error(__('The user could not be saved. Please, try again.'));
          }
          $this->set(compact('user'));
        // }

    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user){

      if ($this->request->getParam('action') === 'index') {
          return true;
      }

      if (in_array($this->request->getParam('action'), ['edit', 'delete', 'view'])) {
          // Prior to 3.4.0 $this->request->params('pass.0')
          $userId = (int)$this->request->getParam('pass.0');
          if ($userId == $user['id']) {
            return true;
          }
      }

      return parent::isAuthorized($user);
    }

}
