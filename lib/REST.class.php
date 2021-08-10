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
abstract class REST
{

	protected $id;
	protected $pin;
	protected $token;

	protected $url;
	protected $verifyhost;
	protected $verifyper;

	public function __construct()
	{
		$this->url=get_option('lms_url');
		$this->verifyhost=(get_option('lms_verifyhost') ? 1 : 0);
		$this->verifypeer=(get_option('lms_verifypeer') ? TRUE : FALSE);
	}

	public function get($uri)
	{
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $this->url.$uri);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, 1);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, [
        	'Content-Type: application/json',
        	"AUTHORIZATION: ".$this->token
		]);

		curl_setopt($ch, CURLOPT_POST, 0);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $this->verifyhost);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verifypeer);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    	$response = curl_exec($ch);	

		return $response;
	}

	public function post($uri, $data)
	{
		$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $this->url.$uri);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, 1);
		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $this->verifyhost);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verifypeer);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, [
        	'Content-Type: application/json',
        	"AUTHORIZATION: ".$this->token
		]);

		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			$response = curl_exec($ch);

		return $response;
	}

	public function put($uri, $data)
	{
		$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $this->url.$uri);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $this->verifyhost);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verifypeer);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    	curl_setopt($ch, CURLOPT_HTTPHEADER, [
        	'Content-Type: application/json',
        	"AUTHORIZATION: ".$this->token
		]);

		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			$response = curl_exec($ch);

		return $response;
	}

	public function authenticate()
	{
		$uri='wordpress/authenticate';

		$data['id'] = base64_encode($this->id);
		$data['pin']=base64_encode($this->pin);
	
        $result=$this->post($uri, $data);
        $this->token=$result;
		return $result;
	}

	public function setID($id)
	{
		$this->id=$id;
		return;
	}

	public function setPIN($pin)
	{
		$this->pin=$pin;
		return;
	}

	public function setToken($token)
	{
		$this->token=$token;
		return;
	}

	public function getToken()
	{
		return $this->token;
	}

	public function logOut()
	{
		return;
	}
}
?>
