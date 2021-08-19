<?php
$res = @include '../../main.inc.php'; // For root directory
if (! $res)
	$res = @include '../../../main.inc.php'; // For "custom" directory
if (! $res)
	die("Include of main fails");
require_once '../class/lead.class.php';
require_once '../../../pdo/pdodb.php';

$lead = new Lead($db);
//  Heading 
$title = $langs->trans('LeadList');
llxHeader('', $title);
$year = GETPOST('year','int');
$socid = GETPOST('socid','int');
$userid = GETPOST('userid','int');
$group_by = GETPOST('group_by','alpha');
$status = GETPOST('status','alpha');
//rajiv
$condition = GETPOST('condition','alpha');



$param = array(
	'year' => $year,
	'socid' => $socid,
	'userid' => $userid,
	'group_by' => $group_by,
	'status' => $status,
	//rajiv
	'condition' => $condition
);



$list_lead = $lead->get_assigned_lead($param);

?>
<link href="<?php echo $dolibarr_main_url_root.'/custom/lead/css/style.css';?>" rel="stylesheet" type="text/css" />


<div class="liste_titre">
    
    <input type="text" id="myInput"  placeholder="Search Items..." title="Type in..">
    
    <span class="total_amount_prosp"></span>
    <span class="total_amount_margin"></span>
    
	<table  class="noborder" width="100%">
		<thead>
			<tr class="liste_titre">
				<th> S.NO </th>
				<th class="s_no">
					Ref.
					<!-- <a class="reposition" href="?sortfield=t.ref&amp;sortorder=desc&amp;begin=&amp;viewtype=all">Ref.</a> -->
				</th>
				<th class="lead_name">
					Lead Name
					<!-- <a class="reposition" href="?sortfield=t.lead_name&amp;sortorder=desc&amp;begin=&amp;viewtype=all">Lead Name</a> -->
				</th>
				<th class="assigned">
					Assigned
					<!-- <a class="reposition" href="?sortfield=t.lead_name&amp;sortorder=desc&amp;begin=&amp;viewtype=all">Lead Name</a> -->
				</th>
				<th class="description">
					Description
					<!-- <a class="reposition" href="?sortfield=t.description&amp;sortorder=desc&amp;begin=&amp;viewtype=all">Description</a> -->
				</th>
				
				<th class="opportunity_type">
					Opportunity Type
					<!-- <a class="reposition" href="?sortfield=t.fk_productid&amp;sortorder=desc&amp;begin=&amp;viewtype=all">Product</a> -->
				</th>
				
				<th class="budget">
					Budget
					<!-- <a class="reposition" href="?sortfield=t.rfp_received&amp;sortorder=desc&amp;begin=&amp;viewtype=all">RFP Received</a> -->
				</th>
				
				<th class="budget">
					Margin
					<!-- <a class="reposition" href="?sortfield=t.rfp_received&amp;sortorder=desc&amp;begin=&amp;viewtype=all">RFP Received</a> -->
				</th>

				<th class="deadline">
					Deadline
					<!-- <a class="reposition" href="?sortfield=t.rfp_received&amp;sortorder=desc&amp;begin=&amp;viewtype=all">RFP Received</a> -->
				</th>

				<th class="status">
					Status
					<!-- <a class="reposition" href="?sortfield=t.rfp_received&amp;sortorder=desc&amp;begin=&amp;viewtype=all">RFP Received</a> -->
				</th>
				
				<th class="remarks">
					Remarks
					<!-- <a class="reposition" href="?sortfield=t.rfp_received&amp;sortorder=desc&amp;begin=&amp;viewtype=all">RFP Received</a> -->
				</th>

				<!-- <th class="maxwidthsearch liste_titre" align="right"></th> -->
				<!-- Component multiSelectArrayWithCheckbox selectedfields -->
			</tr>
		   </thead>
		   
		   <tbody id="tbl_assigned_lead">
			<?php

			if( !empty($list_lead) ){

				$sno = 1;
				$total_amount_prosp = 0;
				$total_amount_margin =0;
			
			
				foreach ( $list_lead as $key => $value ) {

					$assignedInfo = PDODB::getEntryByData(MAIN_DB_PREFIX.'user',true,array('rowid' => $value->fk_user_resp));
					$assigned_to = $assignedInfo['firstname'].' '.$assignedInfo['lastname'];

					$opportunityInfo = PDODB::getEntryByData(MAIN_DB_PREFIX.'c_lead_type',true,array('rowid' => $value->fk_c_type));
					$opportunity = $opportunityInfo['label'];

					//print_r($value->rowid); die;

					$remarksInfo = PDODB::getEntryByData(MAIN_DB_PREFIX.'lead_remarks',true,array('fk_lead' => $value->rowid),'','DESC','rowid');
					
					//print_r($remarksInfo);
					//die;
					
					$remarks_date = isset($remarksInfo['create_date']) && $remarksInfo['create_date'] != NULL ? dol_print_date($remarksInfo['create_date'],'daytextshort') : NULL;
					$remarks = isset($remarksInfo['remarks']) ? '('.$remarks_date.' ) '. $remarksInfo['remarks'] : "NULL";

					$statusInfo = PDODB::getEntryByData(MAIN_DB_PREFIX.'c_lead_status',true,array('rowid' => $value->fk_c_status),'label','DESC','rowid');
					$status = $statusInfo['label'];

                    $total_amount_prosp += $value->amount_prosp;
                    
                    $total_amount_margin += $value->margin;

					//echo $remarks; die;

					//$product = $lead->get_product_by_id($value->fk_productid);

			?>

			<tr class="pair">
				<td> <?php echo $sno++; ?> </td>
				<td><a target="_blank" href="card.php?id=<?php echo $value->rowid; ?> "><?php echo $value->ref; ?></a></td>
				<td><?php echo $value->lead_name; ?></td>
				<td><?php echo $assigned_to; ?></td>
				<td>
					<div class="tooltip"><?php echo substr($value->description, 0,20); ?> <span class="tooltiptext"><?php echo $value->description; ?></span>
					</div>
				</td>
				
				<td>
					<?php echo $opportunity; ?>
				</td>

				<!--<td class="amount_prosp"><?php echo price($value->amount_prosp,'text'); ?></td>-->
				<td class="amount_prosp"><?php echo round($value->amount_prosp,2); ?></td>
                
                <!--<td class="amount_prosp"><?php echo price($value->margin,'text'); ?></td>-->
                <td class="margin"><?php echo round($value->margin,2); ?></td>
                
				<td><?php echo dol_print_date($value->date_closure,'daytextshort'); ?></td>
				
				<td><?php echo $status; ?></td>
				
				<td><?php echo $remarks; ?></td>

				<!-- <td align="center">
					<a href="card.php?id=448&amp;action=edit"><span class="fa fa-pencil marginleftonly valignmiddle" style=" color: #444;" alt="Edit" title="Edit"></span></a>
				</td> -->
			</tr>
			
			<?php } ?>
			<tr>
			    <td>Total Amount:</td>
			    <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
			    <td><?php echo price($total_amount_prosp,'text'); ?></td>
			    <td><?php echo price($total_amount_margin,'text'); ?></td>
			    <td></td>
			    <td></td>
			    <td></td>
			</tr>
			
			<?php } ?>
			
		</tbody>
	</table>
</div>
<?php
	llxFooter();
	$db->close();
?>
<script>

    // Code To Search Element in the Table
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
        
        var value = $(this).val().toLowerCase();
        
        var search_keys = value.split(" ");
        
        //console.log(search_keys);
        
        
        // Code For Count Total Amount Prosp
        total_amount_prosp = parseFloat(0).toFixed(2);
        total_amount_margin = parseFloat(0).toFixed(2);
        
        $("#tbl_assigned_lead tr").filter(function() {
            
            if( $(this).text().toLowerCase().indexOf(value) > -1 ){
                
                let amount_prosp = parseFloat( $(this).find(".amount_prosp").html() ).toFixed(2);  
                 let margin = parseFloat( $(this).find(".margin").html() ).toFixed(2);  
                
                //console.log(amount_prosp);
                total_amount_prosp = + total_amount_prosp + +amount_prosp;
                total_amount_margin = + total_amount_margin + +margin;
              
                
            }
            
            //search_keys.foreach()
            $(this).toggle( $(this).text().toLowerCase().indexOf(value) > -1   )
            
        });
        

          if(! isNaN(total_amount_prosp) ){
            $('.total_amount_prosp').show();
         //   $('.total_amount_margin').show();
            $('.total_amount_prosp').html("Total Amount : "+parseFloat(total_amount_prosp).toFixed(2) + "  "+"Total Margin : "+parseFloat(total_amount_margin).toFixed(2));
          //  $('.total_amount_margin').html("Total Margin : "+parseFloat(total_amount_margin).toFixed(2));
        }
        else
             $('.total_amount_prosp').hide();
             $('.total_amount_margin').hide();
        });
       
    });
</script>


