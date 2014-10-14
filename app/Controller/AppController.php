<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $components = array(
		'DebugKit.Toolbar',
		'Session',
        'Auth' => array(
        	'loginAction' => array(
                'controller' => 'employers',
                'action' => 'login'
            ),
            'loginRedirect' => array(
                'controller' => 'schedules',
                'action' => 'index'
            ),
            'logoutRedirect' => array(
                'controller' => 'employers',
                'action' => 'login'
            ),
            'authenticate' => array(
                'Form' => array(
                	'fields' => array(
                		'username' => 'email',
                		'password' => 'password'
                	),
                	'userModel' => 'Employer',
                    'passwordHasher' => 'Blowfish'
                )
            )
        ),
		'SassCompiler.Sass' => array(
			'sourceFolder'      => 'webroot/sass',              // Where to look for .scss files, (From the APP directory)
        	'targetFolder'      => 'css',               		// Where to put the generated css (From the webroot directory)
        	'forceCompiling'    => true,                       // Always recompile
        	'autoRun'           => true,                       // Check if compilation is necessary, this ignores the CakePHP Debug setting
        )
	);

    public function beforeFilter()
    {
        if($this->Session->read('Auth.User.registration_complete') == 0)
        {
            $ignoreUrls = array(
                '/',
                '/employers/settings',
                '/employers/registration',
                '/employers/logout'
            );

            $goToSettings = true;

            for($i = 0; $i < count($ignoreUrls); $i++)
            {
                $url = explode('/', $this->here);
                $currentUrl;

                switch(count($url))
                {
                    case 1:
                        $currentUrl = '/';
                        break;
                    case 2:
                        $currentUrl = '/'.$url[1];
                        break;
                    case 3:
                        $currentUrl = '/'.$url[1].'/'.$url[2];
                        break;
                    default:
                        $currentUrl = '/'.$url[1].'/'.$url[2];
                        break;
                }

                if($currentUrl == $ignoreUrls[$i])
                {
                    $goToSettings = false;
                }
            }

            if($goToSettings)
            {
                $this->redirect(array('controller' => 'employers', 'action' => 'settings'));
            }
        }
    }
	
	public function hasAccess($requiredRoleId, $roleId)
	{
		if($requiredRoleId == $roleId)
		{
			return true;
		}

		return false;
	}

    public function getJobInfo($employerId)
    {
        $this->loadModel('EmployersJob');
        
        $currentJobId = 3;
        $jobInfo = null;
        $jobs = $this->EmployersJob->findAllByEmployerId($employerId);

        for($i = 0; $i < count($jobs); $i++)
        {
            if($jobs[$i]['Job']['id'] == $currentJobId)
            {
                $jobInfo = $jobs[$i];
            }   
        }

        return $jobInfo;
    }

    public function getEmployerId()
    {
        return $this->Session->read('Auth.User.id');
    }
}
