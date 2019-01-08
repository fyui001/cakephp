<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public function beforeFilter() {
      parent::beforeFilter();
      $this->Auth->allow('home', 'View');
      $this->response->disableCache();
    }
    public $autoLayout = false;
    public $components = array(
      'Flash',
      'Auth' => array(
        'loginAction'    => "/users/login/",
        'loginRedirect'  => array('controller' => 'users', 'action' => 'afterlogin'),
        'logoutRedirect' => "/users/login/",
        'authenticate'   => array(
          'Form' => array(
            'fields'    => array('username' => 'mailaddress', 'password' => 'password'),
            'userModel' => 'User',
            'passwordHasher' => 'Blowfish'
          )
        )
      )
    );

   public function isAuthorized($user) {
   // Admin can access every action
   if (isset($user['role']) && $user['role'] === 'admin') {
     return true;
   }
   //デフォルトは拒否
   return falseb;
 }


   public function genRandStr($length, $charSet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'){
         $retStr = '';
         $randMax =  strlen($charSet) - 1;
         for ($i = 0; $i < $length; ++$i) {
           $retStr .= $charSet[rand(0, $randMax)];
         }
         return $retStr;
     }




}
