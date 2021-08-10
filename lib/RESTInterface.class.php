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
interface RESTInterface
{
    public function get($id);

    public function post($uri, $data);

    public function put($uri, $data);

    public function setID($id);

    public function setPIN($pin);

    public function setToken($token);

    public function getToken();

    public function logOut();

    public function authenticate();

    public function getDocuments($id);

    public function setConfiguration($data);

    public function getFinances();

    public function getHelpdesk();

    public function getInvoice($id);

    public function getNodes();

    public function getOffers($id);

    public function addOrder($data);

    public function getTicket($id);

    public function getStock();

    public function executeAction($data);

    public function ContactUs($data);

    public function addTicket($data);

    public function addMessage($data);

}
?>
