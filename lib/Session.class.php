<?php
/*
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License Version 2 as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 *  USA.
 * 
 */

/*
 * @author Sylwester Zdanowski
 */
class Session{

	public $token;

    public $id;
    private $login;
    private $passwd;

    public function __construct(&$REST)
    {
		$this->REST = &$REST;
		$loginform = $_POST['userpanel'];
		session_start();
        if (isset($loginform['login'])) {
            $this->login = trim($loginform['login']);
            $this->passwd = trim($loginform['passwd']);
            $_SESSION['session_timestamp'] = time();

        } elseif($this->TimeOut(600)) {
            $this->login = isset($_SESSION['session_login']) ? $_SESSION['session_login'] : null;
            $this->passwd = isset($_SESSION['session_passwd']) ? $_SESSION['session_passwd'] : null;
            $this->id = isset($_SESSION['session_id']) ? $_SESSION['session_id'] : 0;

			$this->token = isset($_SESSION['token']) ? $_SESSION['token'] : 0;
			$this->REST->setID($this->login);
			$this->REST->setPIN($this->passwd);
			$this->REST->setToken($this->token);
        }

		if($this->token==0 && $this->login && $this->passwd)
		{
			$this->REST->setID($this->login);
			$this->REST->setPIN($this->passwd);
			$this->REST->setToken($this->token);

			$result=$this->REST->authenticate();

			$this->token=$result;

			$_SESSION['token']=$this->token;
		}
    }

    public function TimeOut($timeout = 6)#600
    {
        if ((time()-$_SESSION['session_timestamp']) > $timeout ) {
            $this->error = 'Idle time limit exceeded ('.$timeout.' sec.)';
            $this->token = 0;
            return false;
        } else {
            $_SESSION['session_timestamp'] = time();
            return true;
        }
    }

    public function LogOut()
    { 
        $this->token = 0;

        session_destroy();
        unset($_SESSION);
    }

	public function isLoged()
	{
		return $this->token;
	}
}

?>
