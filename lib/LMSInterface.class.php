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
interface LMSInterface
{
    public function InitPlugin();


    public function lms_login();

    public function lms_swipe();

    public function lms_menu();

    public function lms_contactus();

    public function lms_documents($part);

    public function lms_finances($part);

    public function lms_helpdesk($part);

    public function lms_nodes($part);

    public function lms_offers($part);

    public function lms_stock($part);

    public function lms_ticket($part);

}

?>
