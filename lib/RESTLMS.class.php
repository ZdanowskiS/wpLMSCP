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
class RESTLMS extends REST implements RESTInterface
{

	public function getDocuments($id)
	{
		$uri='wordpress/documents/'.$id;

		$result=$this->get($uri);

        if($id)
            return $result;
        else
		    return json_decode($result,true);
	}

	public function setConfiguration($data)
	{
		$uri='wordpress/configuration';

	    $result=$this->put($uri, $data);

		return $result;
	}

	public function getFinances()
	{
		$uri='wordpress/finances';

		$result=$this->get($uri);

		$result=json_decode($result,true);

		return $result;
	}

	public function getHelpdesk()
	{
		$uri='wordpress/helpdesk';

		$result=$this->get($uri);

		$result=json_decode($result,true);

		return $result;
	}

	public function getInvoice($id)
	{
		$uri='wordpress/invoice/'.$id;

		$result=$this->get($uri);

		return $result;
	}

	public function getNodes()
	{
		$uri='wordpress/nodes';

		$result=$this->get($uri);

		$result=json_decode($result,true);

		return $result;
	}

    public function getOffers($id)
    {
		$uri='wordpress/offers/'.$id;

		$result=$this->get($uri);

        $result=json_decode($result,true);

		return $result;
    }

    public function addOrder($data)
    {
		$uri='wordpress/addorder';
    
		$result=$this->post($uri, $data);

		return $result;
    }

	public function getTicket($id)
	{
		$uri='wordpress/ticket/'.$id;

		$result=$this->get($uri);

		$result=json_decode($result,true);

		return $result;
	}

	public function executeAction($data)
	{
		$uri='wordpress/executeaction';
	
		$result=$this->post($uri, $data);

		return $result;
	}

	public function ContactUs($data)
	{
		$uri='wordpresspublic/contactus/';

		$result=$this->post($uri,$data);

		return $result;
	}

    public function addTicket($data)
    {
		$uri='wordpress/addticket';
    
		$result=$this->post($uri, $data);

		return $result;
    }

    public function addMessage($data)
    {
		$uri='wordpress/addmessage';
    
		$result=$this->post($uri, $data);

		return $result;
    }


    public function getStock()
    {
		$uri='wordpress/stock/'.$id;

		$result=$this->get($uri);

        $result=json_decode($result,true);

		return $result;
    }
}

?>
