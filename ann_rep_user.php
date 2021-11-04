<html>
    <head>
        <link rel="STYLESHEET" type="text/css" href="codebase/dhtmlx.css">
        <link href="lib/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <script src="codebase/dhtmlx.js"></script>
        <script type="text/javascript">
            function hideme() {
                document.getElementById('printing').style.visibility = 'hidden';
            }

            function hideme_div() {
                document.getElementById('click').style.visibility = 'hidden';
            }
            function closewin() {
                window.close();
            }
        </script>
        <style>
		body {
    font-family: "Arial, sans-serif;";
    font-size: 14px;
    line-height: 1;
    color: #000;
}
            table{
                border: 1px solid;
            }
            table tr td{
                font-size: 9px;
                padding: 0px;

            } 
            table tr th{
                font-size: 9px;
                padding: 0px;
				font-weight: bold;
            } 
            .dep_info tr td{
                text-align: right;

            }
            .dep_info tr th{

                text-align: center;

            }
            .dep_info tr .lable{
                text-align: left;
            }
            .table-striped > tbody > tr:nth-of-type(odd) {
                background-color: #f9f9f9;
            }
			.table-condensed > thead > tr > th, .table-condensed > tbody > tr > th, .table-condensed > tfoot > tr > th, .table-condensed > thead > tr > td, .table-condensed > tbody > tr > td, .table-condensed > tfoot > tr > td {
			padding: 1px;
			}

			.dep_table{
				width: 650px; 
				margin: auto;
				padding: 0px;
			}
			.dep_td{
				width: 16.6%;
				text-align: center;
			}
			.dep_data_td{
			text-align: right;
			}
			.trans_td{
			width: 9.09%;
			text-align: right;
			}

        </style>
    </head>
    <body>

        <?php
        ob_start();
        $user = $_GET['emp'];
        require_once 'db.php';
		include 'function.php';
        if (isset($_POST['btnSubmit'])) {
            $trans_date = $_POST['trans_date'];
            $fin_year = $_POST['fin_year'];
            $close_year = date('Y', strtotime($trans_date));
            $start_year = $close_year - 1;
            $from_date = $start_year . '-04-01';
            $end_date = $close_year . '-03-31';
        }
        $get_state_query = "SELECT * FROM th_members_ob_cb_data where EMP_NO1 = $user and TRANS_DATE_1 = '$trans_date'";
        $get_state = new Database;
        $get_state->prepare($get_state_query);
        $statement = $get_state->resultset();
        foreach ($statement as $state) {
			//echo '<pre>';
			//print_r($state);
			//echo '</pre>';
            ?>
			<table style="width: 650px; margin: auto; border: none">
            <tr >
                <td width="7%"><img src="img/th.png" width="60" height="60"/></td>
                <td  align="center" colspan="3"><h4>Visakhapatnam Steel Plant Employees Co-op Thrift and Credit Society Ltd.</h4>
				<p><span align="center">(REGD.NO.B-1918)</span><br>
                        <span><b align="center">Ukkunagaram , VISAKHAPATNAM - 530032</b></span>						
						</p>
                </td>
            </tr>
			<tr>
			<td colspan="2" align="right">
			 Date : <?php echo date('d-M-Y'); ?> 
			</td>
			</tr>
        </table>
            <table style="width: 650px; margin: auto; border: none">
                <tr>
                    <td colspan = "4">                        
                        <h5 align = "center"><span style=" background-color: silver">ANNUAL STATEMENT FOR THE FINANCIAL YEAR : <?php echo $start_year . ' - ' . $close_year; ?></span></h5>
                    </td>
                </tr>
            </table>

            <table class="info" style="width: 650px; margin: auto; padding: 2px; border: none">
                <tr>
                    <td style = "font-size: small">NAME : <?php echo $state['EMP_NAME'] ?></td>
                    <td style = "font-size: small">EMP NO : <?php echo $state['EMP_NO1'] ?></td>
                    <td style = "font-size: small">GL.NO : <?php echo $state['GNO'] ?></td>
                    <td style = "font-size: small">DEPT CODE : <?php echo $state['DEPTCODE'] ?></td>
                </tr>
                <tr>
                    <td colspan="2" style = "font-size: small">DESIGN : <?php echo $state['DESIG'] ?></td>
                    <td colspan="2" style = "font-size: small">DEPT : <?php echo $state['DEPT'] ?></td>
                </tr>
                <tr>
                    <td colspan="4" style = "font-size: small">
                        <?php echo $state['NOMIN_NAME1'] ?>
                    </td>
                </tr>
            </table>

            <table class="dep_info" style="width: 650px; margin: auto; padding: 2px; border: none">
                <tr>
                    <th colspan="6">
                        <h6 align="center">DEPOSITS</h6>
                    </th>
                </tr>
            </table>
            <table class=" table table-bordered table-condensed dep_table"  style="">
                <tr>
                    <td class="dep_td"></td>
                    <th class="dep_td">THRIFT DEPOSIT</th>
                    <th class="dep_td">VTD</th>
                    <th class="dep_td">SHARE CAPITAL</th>
                    <th class="dep_td">R.B.F</th>
                    <th class="dep_td">DIVIDEND</th>
                </tr>
                <tr>
                    <td class="lable">Opening Balance</td>
                    <td class="dep_data_td"><?php echo round($state['TD_OB']) ?></td>
                    <td class="dep_data_td"><?php echo round($state['VTD_OB']) ?></td>
                    <td class="dep_data_td"><?php echo round($state['SC_OB']) ?></td>
                    <td class="dep_data_td"><?php echo round($state['RB_OB']) ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="lable">Receipts</td>
                    <td class="dep_data_td"><?php echo round($state['TD_R']) ?></td>
                    <td class="dep_data_td"><?php echo round($state['VTD_R']) ?></td>
                    <td class="dep_data_td"><?php echo round($state['SC_R']) ?></td>
                    <td class="dep_data_td"><?php echo round($state['RB_R']) ?></td>
                    <td class="dep_data_td"><?php echo round($state['SC_DIV']) ?></td>
                </tr>
                <tr>
                    <td class="lable">Withdrawals</td>
                    <td class="dep_data_td"><?php echo round($state['TD_P']) ?></td>
                    <td class="dep_data_td"><?php echo round($state['VTD_P']) ?></td>
                    <td class="dep_data_td"><?php echo round($state['SC_P']) ?></td>
                    <td class="dep_data_td"><?php echo round($state['RB_P']) ?></td>
                    <th></th>
                </tr>
                <tr>
                    <td class="lable">Interest</td>
                    <td class="dep_data_td"><?php echo round($state['TD_INT']) ?></td>
                    <td class="dep_data_td"><?php echo round($state['VTD_INT']) ?></td>
                    <td></td>
                    <td class="dep_data_td"><?php echo round($state['RB_INT']) ?></td>
                    <th></th>
                </tr>
                <tr>
                    <td class="lable">Closing Balance</td>
                    <td class="dep_data_td"><?php echo round($state['TD_CB']) ?></td>
                    <td class="dep_data_td"><?php echo round($state['VTD_CB']) ?></td>
                    <td class="dep_data_td"><?php echo round($state['SC_CB']) ?></td>
                    <td class="dep_data_td"><?php echo round($state['RB_CB']) ?></td>
                    <th></th>
                </tr>
            </table>

            <table class="lloan_info" style="width: 650px; margin: auto; padding: 2px;border: none">
                <tr>
                    <th colspan="6">
                        <h6 align="center">LOANS</h6>
                    </th>
                </tr>
            </table>
            <table class=" table table-bordered table-condensed" style="width: 650px; margin: auto;">
                <tr>
                    <th colspan="6" align="left">
                        Long Term Loan
                    </th>
                </tr>
                <tr>
                    <td>Loan Amount : <?php echo $state['LO_AMOUNT'] ?></td>
                    <td>Loan Date : <?php 
					if($state['LO_DATE'] != ''){
					echo date('d-m-Y', strtotime($state['LO_DATE']));
					}
					?>
					</td>
                    <td>Installments : <?php echo $state['LO_INST'] ?></td>
                    <td>Rate of Interest: <?php echo $state['LO_ROI'] ?></td>
                </tr>
                <tr>
                    <td class="lable">Opening Bal (PRL): <?php echo $state['LO_P_OB'] ?></td>
                    <td>New Loan:<?php echo $state['LO_P_NEW'] ?></td>
                    <td>Receipts:<?php echo $state['LO_P_RCPT'] ?></td>
                    <td>Closing Bal:<?php echo $state['LO_P_CB'] ?></td>
                </tr>
                <tr>
                    <td class="lable">Opening Bal (INT): <?php echo $state['LO_I_OB'] ?></td>
                    <td></td>
                    <td>Int.Receipt : <?php echo $state['LO_I_RCPT'] ?></td>
                    <td>Int.Bal : <?php echo $state['LO_I_CB'] ?></td>
                </tr>
                <tr>
                    <td colspan="6" class="lable">Surety 1:<?php echo $state['LO_S1'] ?></td>

                </tr>
                <tr>
                    <td colspan="6" class="lable">Surety 2:<?php echo $state['LO_S2'] ?></td>

                </tr>
                <tr>
                    <td colspan="6" class="lable">Surety 3: <?php echo $state['LO_S3'] ?></td>

                </tr>
            </table>

            <table class=" table table-bordered table-condensed" class="sloan_info" style="width: 650px; margin: auto; ">

                <tr>
                    <th colspan="6" align="left">
                        Medium Term Loan
                    </th>
                </tr>
                <tr>
                    <td>Loan Amount: <?php echo $state['EDLO_AMOUNT'] ?></td>
					<td>Loan Date : <?php 
					if($state['EDLO_DATE']!= ''){
					echo date('d-m-Y', strtotime($state['EDLO_DATE'])); 
					}
					?>
					</td>
                    
                    <td>Installments: <?php echo $state['EDLO_INST'] ?></td>
                    <td>Rate of Interest: <?php echo $state['EDLO_ROI'] ?></td>
                </tr>
                <tr>
                    <td>Opening Bal (PRL): <?php echo $state['EDLO_P_OB'] ?></td>
                    <td>New Loan :<?php echo $state['EDLO_P_NEW'] ?></td>
                    <td>Receipts : <?php echo $state['EDLO_P_RCPT'] ?></td>
                    <td>Closing Bal : <?php echo $state['EDLO_P_CB'] ?></td>
                </tr>
                <tr>
                    <td class="lable">Opening Bal (INT):<?php echo $state['EDLO_I_OB'] ?></td>
                    <td></td>
                    <td>Int.Receipt:<?php echo $state['EDLO_I_RCPT'] ?></td>
                    <td>Int.Bal:<?php echo $state['EDLO_I_CB'] ?></td>
                </tr>
                <tr>
                    <td colspan="6" class="lable">Surety 1:<?php echo $state['EDLO_S1'] ?></td>

                </tr>
                <tr>
                    <td colspan="6" class="lable">Surety 2 : <?php echo $state['EDLO_S2'] ?></td>

                </tr>
            </table>
            <!-- <table class=" table table-bordered table-condensed" style="width: 650px; margin: auto; padding: 2px; border: 1px solid">
                <tr>
                    <th colspan="2">
                        Surety GIVEN DETAILS
                    </th>
                </tr>
                <tr>
                    <td colspan="1"><?php echo $state['SUR1'] ?>,<br>
                        <?php echo $state['SUR2'] ?>,<br>
                        <?php echo $state['SUR3'] ?>
                    </td>
                    <td colspan="1"><?php echo $state['SUR4'] ?>,<br>
                        <?php echo $state['SUR5'] ?>,                    
                    </td>

                </tr>
            </table> -->
            <?php
        }
        ?>
        <table class="lloan_info" style="width: 650px; margin: auto; padding: 2px;border: none">
            <tr>
                <th colspan="6">
                    <h6 align="center">TRANSACTION DETAILS</h6>
                </th>
            </tr>
        </table>
        <table class="table table-bordered table-condensed" style="width: 650px; margin: auto; padding: 2px; border: 1px solid">
            <tr>
                <th style="width: 10%">Tran.Date</th>
                <th style="width: 15%; text-align:center" colspan="2">TD</th>
                <th style="width: 15%; text-align:center" colspan="2">VTD</th>
                <th style="width: 30%; text-align:center" colspan="3">MAIN LOAN</th>
                <th style="width: 30%; text-align:center" colspan="3">MEDIUM TERM LOAN</th>
            </tr>
            <tr>
                <th></th>
                <th>Rcpt.</th>
                <th>withdraw.</th>
                <th>Rcpt.</th>
                <th>withdraw.</th>
                <th>PRL.</th>
                <th>INT.</th>
                <th>New Loan</th>
                <th>PRL.</th>
                <th>INT.</th>
                <th>New Loan</th>
            </tr>

            <?php
            $get_trans_query = "SELECT * FROM th_members_trans_data where EMP_NO = $user and TRANS_DATE > '$from_date' and TRANS_DATE < '$end_date' order by TRANS_DATE ASC";
            $get_trans = new Database;
            $get_trans->prepare($get_trans_query);
            $trans = $get_trans->resultset();
            foreach ($trans as $trans) {
                ?>
                <tr>
                    <td><?php echo date('d/m/y', strtotime($trans['TRANS_DATE'])) ?></td>

                    <td class="trans_td"><?php echo $trans['TD_RCPT'] != NULL ? round($trans['TD_RCPT']) : '' ?> </td>
                    <td class="trans_td"><?php echo $trans['TD_PYMT'] != NULL ? round($trans['TD_PYMT']) : '' ?></td>

                    <td class="trans_td"><?php echo $trans['VTD_RCPT'] != NULL ? round($trans['VTD_RCPT']) : '' ?> </td>
                    <td class="trans_td"><?php echo $trans['VTD_PYMT'] != NULL ? round($trans['VTD_PYMT']) : '' ?></td>

                    <td class="trans_td"><?php echo $trans['LO_PRL_REC'] != NULL ? round($trans['LO_PRL_REC']) : '' ?> </td>
                    <td class="trans_td"><?php echo $trans['LO_INT_REC'] != NULL ? round($trans['LO_INT_REC']) : '' ?></td>
                    <td class="trans_td"><?php echo $trans['NEW_LOAN_PYMT'] != NULL ? round($trans['NEW_LOAN_PYMT']) : '' ?></td>

                    <td class="trans_td"><?php echo $trans['ELO_PRL_REC'] != NULL ? round($trans['ELO_PRL_REC']) : '' ?></td>
                    <td class="trans_td"><?php echo $trans['ELO_INT_REC'] != NULL ? round($trans['ELO_INT_REC']) : '' ?></td> 
                    <td class="trans_td"><?php echo $trans['NEW_EDL_PYMT'] != NULL ? round($trans['NEW_EDL_PYMT']) : '' ?></td>
                </tr>
                <?php
            }
            ?>
        </table>

        <div id="click" class="hidden-print">
            <span align="right" style="margin-left: 30%;
                  margin-right: 30%;"><a id="printing" onclick="hideme()"   href="javascript:window.print();">Print</a></span>
            <span align="left"><a href="#" id="printing" onclick="closewin();">close</a></span>
        </div>


    </body>
</html>