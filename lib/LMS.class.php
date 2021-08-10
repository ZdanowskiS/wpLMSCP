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
abstract class LMS
{
	protected $RESTLMS;
	protected $SESSION;

	protected $data_format;

    public function __construct(&$SESSION,&$RESTLMS)
    {
        $this->RESTLMS = &$RESTLMS;
        $this->SESSION = &$SESSION;

        $this->data_format=get_option('lms_data_format');

        if(!$this->data_format)
            $this->data_format="Y/m/d";
    }
}

?>
