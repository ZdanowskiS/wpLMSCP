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
class LMSDefault extends LMS implements LMSInterface
{  
    public function InitPlugin()  
    {
		if($this->SESSION->isLoged())
		{
			switch ($_GET['lm']){
				case 'nodes':
					if($_GET['id'])
					{
						$data['value']=sanitize_text_field($_POST['value']);
						$data['id']=intval($_GET['id']);
						$data['prevval']=sanitize_text_field($_POST['prevval']);
						$finances=$this->RESTLMS->setConfiguration($data);
					}
					add_shortcode('wp_lms', array($this,'lms_nodes'));
				break;
				case 'helpdesk':
					add_shortcode('wp_lms', array($this,'lms_helpdesk'));
				break;
                case 'addticket':
                    $data=array('subject' => sanitize_text_field($_POST['subject']),
                                 'body' => sanitize_text_field($_POST['body']));
					$finances=$this->RESTLMS->addTicket($data);
					add_shortcode('wp_lms', array($this,'lms_helpdesk'));
                break;
                case 'addmessage':
                    $data=array('id' => intval($_GET['id']),
                                 'subject' => sanitize_text_field($_POST['subject']),
                                 'body' => sanitize_text_field($_POST['body']));
					$finances=$this->RESTLMS->addMessage($data);
                    add_shortcode('wp_lms', array($this,'lms_ticket'));
                break;
                case 'ticket':
					add_shortcode('wp_lms', array($this,'lms_ticket'));
                break;
				case 'finances':
					add_shortcode('wp_lms', array($this,'lms_finances'));
				break;
				case 'documents':
					add_shortcode('wp_lms', array($this,'lms_documents'));
				break;
				case 'document':
					$document=$this->RESTLMS->getDocuments(intval($_GET['id']));

					if($document!='400 Bad Request')
					{
						header('Content-type: ' . 'application/octet-stream');
                        header('Content-Length: '.strlen($document));
    					header('Content-Disposition: ' . 'attachment; filename=document.pdf');
						echo $document;
						exit();
					}
                    add_shortcode('wp_lms', array($this,'lms_documents'));
				break;
				case 'stock':
					add_shortcode('wp_lms', array($this,'lms_stock'));
				break;
				case 'offers':
					add_shortcode('wp_lms', array($this,'lms_offers'));
				break;
                case 'orderoffert':
                    $data=array('offertid' => intval($_POST['offertid']),
                                    'nodeid' => intval($_POST['nodeid']),
                                    'elements' => $_POST['elements']);

                    $finances=$this->RESTLMS->addOrder($data);
					add_shortcode('wp_lms', array($this,'lms_offers'));
                break;
				case 'genieacs':
					add_shortcode('wp_lms', array($this,'lms_genieacs'));
				break;
				case 'executeaction':
                    if(get_option('lms_genieacs'))
                    {
					    $data['devid']=intval($_POST['devid']);
					    $data['actionid']=intval($_POST['actionid']);
					    $this->RESTLMS->executeAction($data);
                    }
					add_shortcode('wp_lms', array($this,'lms_nodes'));
				break;
				case 'invoice':
					$finances=$this->RESTLMS->getInvoice(intval($_GET['id']));

					if($finances)
					{
						header('Content-type: ' . 'application/octet-stream');
    					header('Content-Disposition: ' . 'attachment; filename=invoice.pdf');
						echo $finances;
						exit();
					}
				break;
				case 'logout':
					$this->SESSION->LogOut();
					add_shortcode('wp_lms', array($this,'lms_login'));
				break;
				default:
					if($this->SESSION->token!=401){
						add_shortcode('wp_lms', array($this,'lms_swipe'));
					}
					else
					{
						add_shortcode('wp_lms', array($this,'lms_login'));
					}

				break;
			}
		}
		elseif($_GET['lm']=='contactus'){
			$this->RESTLMS->ContactUs($_POST['contactus']);
		}
		else
		{
			add_shortcode('wp_lms', array($this,'lms_login'));
		}
		#add_shortcode('wp_lms_publicoffer', array($this,'lms_publicoffer'));
		#add_shortcode('wp_lms_contactus', array($this,'lms_contactus'));
    }

	function lms_login()
	{
			$html='
<div class="inner">
<div class="tab-content">';

$html.='<div id="apus_login_form" class="form-container"><form  method="post" action="'.get_permalink(get_the_ID()).'">
<div class="form-group">
<label for="username_or_email">ID</label><BR>
<input type="text" id="login" name="userpanel[login]" id="username_or_email">
</div>
<div class="form-group">
<label for="pin">PIN</label><BR>
					<input type="text" id="password" name="userpanel[passwd]" id="pin">
</div>
					
					<div class="form-group">
							<input type="submit" class="btn btn-sm btn-warning" name="submit" value="Log In"/>
						</div>

</form>
</div>
</div>
</div>';

		return $html;
	}

	public function lms_swipe()
	{
		$html=$this->lms_menu();
		$html.=$this->lms_offers(1);
		$html.=$this->lms_finances(1);
		$html.=$this->lms_nodes(1);
        if(get_option('lms_enablestock'))
		    $html.=$this->lms_stock(1);
		$html.=$this->lms_documents(1);
		$html.=$this->lms_helpdesk(1);

		return $html;
	}

	function lms_menu()
	{

        $html='<div class="kc-col-container" align="right">
<div class="kc-elm kc-css-377251 kc-title-wrap   dark" >
	'.'<a  href="'.get_permalink(get_the_ID()).'?lm=logout" class="btn btn-xs">Log Out</a>
</div>
</div><BR>';

        $html.='<div class="kc-elm kc-css-697874 kc_col-sm-3 kc_column kc_col-sm-3"><div class="kc-col-container">
<div class="kc-elm kc-css-377251 kc-title-wrap   dark">
	<div class="title-wrapper"><h6 >'.'<a href="'.get_permalink(get_the_ID()).'?lm=finances">Finances</a></h6></div>
</div>
</div></div>';

        $html.='<div class="kc-elm kc-css-697874 kc_col-sm-3 kc_column kc_col-sm-3"><div class="kc-col-container">
<div class="kc-elm kc-css-377251 kc-title-wrap   dark">
	<div class="title-wrapper"><h6 >'.'<a href="'.get_permalink(get_the_ID()).'?lm=nodes">Nodes</a></h6></div>
</div>
</div></div>';

        $html.='<div class="kc-elm kc-css-697874 kc_col-sm-3 kc_column kc_col-sm-3"><div class="kc-col-container">
<div class="kc-elm kc-css-377251 kc-title-wrap   dark">
	<div class="title-wrapper"><h6 >'.'<a href="'.get_permalink(get_the_ID()).'?lm=helpdesk">Helpdesk</a></h6></div>
</div>
</div></div>';

        $html.='<div class="kc-elm kc-css-697874 kc_col-sm-3 kc_column kc_col-sm-3"><div class="kc-col-container">
<div class="kc-elm kc-css-377251 kc-title-wrap   dark">
	<div class="title-wrapper"><h6 >'.'<a href="'.get_permalink(get_the_ID()).'?lm=documents">Documents</a></h6></div>
</div>
</div></div>';
		return $html;
	}

	function lms_contactus()
	{
		$html.='<FORM name="contactus" id="contactus" method="POST" action="?lm=contactus">';
		$html.='E-mail:<INPUT type="text" name="contactus[email]" value="" SIZE="16"><BR>';
		$html.='Telephone:<INPUT type="text" name="contactus[phone]" value="" SIZE="16"><BR>';

		$html.='Message:<BR><textarea name="contactus[message]" rows="10" cols="50"></textarea>';
		$html.='<A href="javascript:document.contactus.submit();" accesskey="S">Submit</A>';
		$html.='</FORM>';

		return $html;
	}

	public function lms_documents($part=null)
	{
		$data=$this->RESTLMS->getDocuments();

		if($part!=1)
			$html=$this->lms_menu();

		$html.='<div class="kc-css-468465 kc-title-wrap dark">
					<div class="title-wrapper"><h3 class="kc_title">Documents</h3>
				</div></div>';
		$html.='<figure class="wp-block-table is-style-stripes">
				<table><thead><tr><th>date</th><th>title</th><th>print</th></TR></thead>
				<tbody>';

		if($data['documents'])foreach($data['documents'] as $document)
		{
            $html.='<TR><TD>'.date($this->data_format,$document['cdate']).'</TD><TD>'.$document['title']
.'</TD><TD><a href="'.get_permalink(get_the_ID()).'?lm=document&id='.$document['docid'].'" target="_blank">Print</a></TD></TR>';
        }
		$html.='</tbody></table></figure>';

		return $html;
    }

	public function lms_finances($part=null)
	{
		$finances=$this->RESTLMS->getFinances();

		$assignments=$finances['assignments'];
		$userinfo=$finances['userinfo'];

		if($part!=1)
			$html=$this->lms_menu();

		$html.='<div class="kc-css-468465 kc-title-wrap dark">
					<div class="title-wrapper"><h3 class="kc_title">Finances</h3>
				</div></div>';
        if($finances['balance']<0){
		    $html.='<figure><strong>Balance:</strong><B style="color:#FF0000;">'
                .sprintf($finances['langdefs'],$finances['balance'],$finances['currency']).'</B></figure>';
        }
        else{
		    $html.='<figure><strong>Balance:</strong>'.sprintf($finances['langdefs'],$finances['balance'],$finances['currency']).'</figure>';
        }

		$html.='<figure class="wp-block-table is-style-stripes">
				<table><thead><tr><th>Name</th><th>From</th><th>To</th><th>Value:</th><th>Discount:</th><th>To Pay:</th></tr></thead>
				<tbody>';

		if($assignments)foreach($assignments as $assignment)
		{
			$html.='<tr><td>'.$assignment['name'].'</td><td>'
			.($assignment['datefrom'] ? date($this->data_format,$assignment['datefrom']) : '-').'</td><td>'

			.($assignment['dateto'] ? date($this->data_format,$assignment['dateto']) : '-').'</td><td>'.sprintf("%2s", sprintf($finances['langdefs'],$assignment['real_value'],$assignment['currency'])).'</td><td>'.sprintf("%2s", sprintf($finances['langdefs'],$assignment['vdiscount'])).'</td><td>'.sprintf("%2s", sprintf($finances['langdefs'],$assignment['discounted_value'])).'</td></tr>';
		}
		$html.='</tbody></table></figure>';


		$html.='<figure class="wp-block-table is-style-stripes">
				<table><thead><tr><th>Date</th><th>Comment</th><th>Value:</th><th>Print:</th></tr></thead>
				<tbody>';


		if($finances['balancelist']['list'])foreach($finances['balancelist']['list'] as $item)
		{
			$html.='<TR><TD>'.date($this->data_format,$item['time']).'</TD><TD>'.$item['comment'].'</TD>';
			$html.='<TD nowrap>'.$item['value'].'</TD>';

			$lm='';
			if($item['doctype']==1)
				$lm='invoice';

			if($lm)
				$html.='<td><a href="'.get_permalink(get_the_ID()).'?lm='.$lm.'&id='.$item['docid'].'" target="_blank">Print</a></td></TR>';
			else
				$html.='<td></td></TR>';
		}
		$html.='</tbody></table></figure>';
		return $html;
	}

	function lms_stock($part=null)
	{
        global $STOCKSTATUS;
		$data=$this->RESTLMS->getStock();
        unset($data['stock']['ammount']);
        unset($data['stock']['sum']);
        unset($data['stock']['sumsell']);

		if($part!=1)
			$html=$this->lms_menu();

		$html.='<div class="kc-css-468465 kc-title-wrap dark">
					<div class="title-wrapper"><h3 class="kc_title">Stock</h3>
				</div></div>';

		$html.='<figure class="wp-block-table is-style-stripes">
				<table><thead><tr><th>Name</th><th>Ownership</th><th>Value:</th></tr></thead>
				<tbody>';

		if($data['stock'])foreach($data['stock'] as $item)
		{
            $html.='<TR><TD>'.$item['pname'].'</TD><TD>'.$STOCKSTATUS[$item['status']].'</TD><TD>'.$item['valuesell'].'</TD></TR>';
        }

        $html.="</tbody></table></figure>";
		return $html;
    }

	public function lms_helpdesk($part=null)
	{
		if($part!=1){
			$html=$this->lms_menu();
		}

		$html.='<div class="kc-css-468465 kc-title-wrap dark">
					<div class="title-wrapper"><h3 class="kc_title">Helpdesk</h3>
				</div></div>';
		if($part!=1){
				$html.='
<div title-wrapper> <h3 class="kc_title"> New Ticket</h></div>

<form  method="post" action="'.get_permalink(get_the_ID()).'?lm=addticket">
<div>
Subject: <input type="text" style="width: 100%;" name="subject" value="">
</div>
<div width="100%">
Message:
<textarea style="width: 100%;" name="body" ></textarea>
</div>
<div align="right">
<input type="submit" class="btn btn-xs" name="submit" value="Send"/>
</div>
</form>
';
        }
		$helpdesk=$this->RESTLMS->getHelpdesk();

		$html.='<figure class="wp-block-table is-style-stripes">
				<table><thead><tr><th>Date</th><th>Title</th><th>Status</th></tr></thead>
				<tbody>';

		if($helpdesk['helpdesk'])foreach($helpdesk['helpdesk'] as $key => $ticket)
		{
			$html.='<TR><TD>'.date($this->data_format,$ticket['createtime']).'</TD><TD>'.'<a href="'.get_permalink(get_the_ID()).'?lm=ticket&id='.$ticket['id'].'">'.$ticket['subject'].'</TD>';
			$html.='<TD nowrap>'.$ticket['state'].'</TD><TR>';
		}
		$html.='</tbody></table></figure>';
		return $html;
	}

	function lms_nodes($part=null)
	{
		$data=$this->RESTLMS->getNodes();

		if($part!=1)
			$html=$this->lms_menu();
		
		$html.='<div class=" kc-css-468465 kc-title-wrap dark">
					<div class="title-wrapper">
						<h3 class="kc_title">Nodes</h3>
					</div>
				</div>';
		$html.='<figure class="wp-block-table is-style-stripes">
				<table><thead><tr><th>Nodes</th></TR></thead>
				<tbody>';

		if($data['nodes'])foreach($data['nodes'] as $node)
		{
			$html.='<TR><TD>ID:'.$node['id'].'<BR>'
					.'MAC:'.$node['mac'].' IP:'.$node['ip'].'<BR>'
					.'Location: '.$node['location'].'<BR>';

            if(get_option('lms_enablegenieacs'))
            {
			    if($node['configuration'])foreach($node['configuration'] as $configuration)
			    {
				    $html.='<form  method="post" action="'.get_permalink(get_the_ID()).'?lm=nodes&id='.$configuration['id'].'"><label for="prevval">'
.$configuration['configname'].'</label> <input type="hidden" name="prevval" value="'.$configuration['value'].'">
<input type="text" name="value" value="'.$configuration['value'].'"><input type="submit" class="btn btn-xs" name="submit" value="Save"/><BR></form>';
			    }

			    if($node['actions'])foreach($node['actions'] as $action)
			    {
			        $html.='<form  method="post" action="'.get_permalink(get_the_ID()).'?lm=executeaction&id='.$action['devid'].'">
<input type="hidden" name="devid" value="'.$action['devid'].'">
<input type="hidden" name="actionid" value="'.$action['actionid'].'">'.$action['name']
.'<input type="submit" class="btn btn-xs" name="submit" value="Execute"/><BR></form>';
			    }
			}
$html.='</TD></TR>';
		}
		$html.='</tbody></table></figure>';

		return $html;
	}

    public function lms_offers($part=null)
    {
		if($part!=1)
			$html=$this->lms_menu();

        $offerts=$this->RESTLMS->getOffers(intval($_GET['id']));

		$html.='<div class=" kc-css-468465 kc-title-wrap dark">
					<div class="title-wrapper">
						<h3 class="kc_title">OFFERS</h3>
					</div>
				</div>';
        if(!$_GET['id'])
        {
		    $html.='<figure class="wp-block-table is-style-stripes">
				<table><thead><tr></TR></thead>
				<tbody>';

		    if($offerts['offerts'])foreach($offerts['offerts'] as $offer)
		    {
			    $html.='<TR><TD><a href="'.get_permalink(get_the_ID()).'?lm=offerts&amp;id='.$offer['id'].'">'.$offer['name']
.'<BR>'.$offer['header'].'</TD><TD> '.$offer['status'].'</TD></a><BR>';
           # $html.=$offer['header'].'</TD></TR>';
		    }
		    $html.='</tbody></table></figure>';
        }
        else{
            $html.='<form name="order" method="post" action="'.get_permalink(get_the_ID()).'?lm=orderoffert&id='.$_GET['id'].'">';
            $html.='<input type="hidden" name="offertid" value='.$offerts['offerts']['id'].'>';
		    $html.='<figure class="wp-block-table is-style-stripes">
				<table><thead><tr><th colspan="3">'.$offerts['offerts']['name'].'</th></TR></thead>';
            $html.='<tr><td colspan="3">'.$offerts['offerts']['description'].'</td></TR>';
            $html.='<thead><tr><th>Name:</th><th>Value:</th><th>Select:</th></TR></thead>
				<tbody>';
		    if($offerts['offerts']['elements'])foreach($offerts['offerts']['elements'] as $element)
		    {
                $checked=($element['type']==WP_ELEMENTTYPE_REQUIRED ? 'CHECKED onclick="return false;"' : '');

                $html.='<TR><TD>'.$element['tariffname'].'</TD><TD>'.$element['value']
.'</TD><TD><input type="checkbox" name="elements['.$element['elementid'].']" value="1" '.$checked.'></TD></TR>';
            }
            $html.='<TR><TD colspan="4" align="right">';
            if($offerts['offerts']['nodes'])foreach($offerts['offerts']['nodes'] as $k => $node)
            {
                if(!$node['status'])
                    $enable=1;
                else
                    unset($offerts['offerts']['nodes'][$k]);
            }

            if($enable){
                $html.='<SELECT name="nodeid">';
                foreach($offerts['offerts']['nodes'] as $node)
                {
                        $html.='<OPTION value="'.$node['id'].'">'.$node['name'].'</OPTION>';
                }
                $html.='</select>';

                $html.='<input type="submit" class="btn btn-xs" name="submit" value="Order"/>';
            }
            $html.='</TD></TR>';
		    $html.='</tbody></table></figure>';
		    $html.='</form>';
        }

		return $html;
    }

    public function lms_ticket($part=null)
    {
		if($part!=1)
			$html=$this->lms_menu();

        $ticket=$this->RESTLMS->getTicket(initval($_GET['id']));
        if($ticket)
        {
            $html.='<div class="title-wrapper"><h3 class="kc_title">Ticket: '.$ticket['subject'].'</h3>
				</div>';

				$html.='
<form  method="post" action="'.get_permalink(get_the_ID()).'?lm=addmessage&id='.$_GET['id'].'">
<div width="100%">
Subject: <input type="text" style="width: 100%;" name="subject" value="">
Message:
<textarea style="width: 100%;" name="body" ></textarea>
</div>
<div align="right">
<input type="submit" class="btn btn-xs" name="submit" value="Send"/>
</div>
</form>
';
		    $html.='<figure class="wp-block-table is-style-stripes">
				<table>
				<tbody>';
            if($ticket['messages'])foreach($ticket['messages'] as $k => $message)
            {
                $html.='<TR><TD>'.date($this->data_format,$message['createtime']).' '.$message['subject'].'<BR>'
                        .($message['customername'] ? $message['customername'] : $message['username'])."<BR>"
                        .$message['body'].'</TD></TR>';
            }
		    $html.='</tbody></table></figure>';
        }
		return $html;
    }

}

?>
