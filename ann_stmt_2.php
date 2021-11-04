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
                font-family: Arial, sans-serif;
                font-size: 14px;
                line-height: 1;
                color: #000;
                background-color: #fff;
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

        </style>
    </head>
    <body>

        <?php
        ob_start();
        session_start();

        if (!isset($_SESSION['suser'])) {
            echo('please login');
            header("location:../index.php");
        }
        $user = $_SESSION['suser'];
        require_once 'db.php';
        include 'function.php';
        $get_gl_no = new Database;
        $get_gl_no->prepare("select GL_NO from th_member_master where EMP_NO = $user");
        $gl_no = $get_gl_no->resultset();
        foreach ($gl_no as $gl_no) {
            $gl_no = $gl_no['GL_NO'];
        }
        if (isset($_POST['btnSubmit'])) {
            $trans_date = $_POST['trans_date'];
            $fin_year = $_POST['fin_year'];
            $close_year = date('Y', strtotime($trans_date));
            $start_year = $close_year - 1;
            $from_date = $start_year . '-04-01';
            $end_date = $close_year . '-03-31';
        }
        $get_state_query = "SELECT * FROM thrift.th_members_ob_cb_data where EMP_NO1 = $user and TRANS_DATE_1 = '$trans_date'";
        $get_state = new Database;
        $get_state->prepare($get_state_query);
        $statement = $get_state->resultset();
        foreach ($statement as $state) {
            ?>
            <table style="width: 650px; margin: auto; padding: 2px; border: none">
                <tr>
                    <td width = "7%"><img src = "img/th.png" width = "40" height = "60"/></td>
                    <td align = "center" colspan = "3">
                        <h3>Visakhapatnam Steel Plant Employees Co-op Thrift and Credit Society Ltd.</h3>
                        <span align = "center">(REGD.NO.B-1918)<br>
                            <b align = "center">Ukkunagaram - 530032</b></span>
                    </td>
                </tr>

                <tr>
                    <td colspan = "4">
                        <br>
                        <h5 align = "center"><span style=" background-color: silver">ANNUAL STATEMENT FOR THE YEAR : <?php echo $start_year . ' - ' . $close_year; ?></span></h5>
                    </td>
                </tr>
            </table>

            <table class="info" style="width: 650px; margin: auto; padding: 2px; border: none">
                <tr>
                    <td>NAME : <?php echo $state['EMP_NAME'] ?></td>
                    <td>EMP NO : <?php echo $state['EMP_NO1'] ?></td>
                    <td>GL.NO : <?php echo $gl_no ?></td>
                    <td>DEPT CODE : <?php echo $state['DEPTCODE'] ?></td>
                </tr>
                <tr>
                    <td colspan="2">DESIGN : <?php echo $state['DESIG'] ?></td>
                    <td colspan="2">DEPT : <?php echo $state['DEPT'] ?></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <?php echo $state['NOMIN_NAME1'] ?>
                    </td>
                </tr>
            </table>

            <table class="dep_info" style="width: 650px; margin: auto; padding: 2px; border: none">
                <tr>
                    <th colspan="6">
                        <h5 align="center">DEPOSITS</h5>
                    </th>
                </tr>
            </table>
            <table class=" table table-bordered table-condensed"  style="width: 650px; margin: auto; padding: 0px">
                <tr style=" border: 1px solid">
                    <td ></td>
                    <th >THRIFT DEPOSIT</th>
                    <th >VTD</th>
                    <th >SHARE CAPITAL</th>
                    <th >R.B.F</th>
                    <th >DIVIDEND</th>
                </tr>
                <tr>
                    <td class="lable">Opening Balance</td>
                    <td><?php echo round($state['TD_OB']) ?></td>
                    <td><?php echo round($state['VTD_OB']) ?></td>
                    <td><?php echo round($state['SC_OB']) ?></td>
                    <td><?php echo round($state['RB_OB']) ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="lable">Receipts</td>
                    <td><?php echo round($state['TD_R']) ?></td>
                    <td><?php echo round($state['VTD_R']) ?></td>
                    <td><?php echo round($state['SC_R']) ?></td>
                    <td><?php echo round($state['RB_R']) ?></td>
                    <td><?php echo round($state['SC_DIV']) ?></td>
                </tr>
                <tr>
                    <td class="lable">Withdrawals</td>
                    <td><?php echo round($state['TD_P']) ?></td>
                    <td><?php echo round($state['VTD_P']) ?></td>
                    <td><?php echo round($state['SC_P']) ?></td>
                    <td><?php echo round($state['RB_P']) ?></td>
                    <th></th>
                </tr>
                <tr>
                    <td class="lable">Interest</td>
                    <td><?php echo round($state['TD_INT']) ?></td>
                    <td><?php echo round($state['VTD_INT']) ?></td>
                    <td></td>
                    <td><?php echo round($state['RB_INT']) ?></td>
                    <th></th>
                </tr>
                <tr>
                    <td class="lable">Closing Balance</td>
                    <td><?php echo round($state['TD_CB']) ?></td>
                    <td><?php echo round($state['VTD_CB']) ?></td>
                    <td><?php echo round($state['SC_CB']) ?></td>
                    <td><?php echo round($state['RB_CB']) ?></td>
                    <th></th>
                </tr>
            </table>

            <table class="lloan_info" style="width: 650px; margin: auto; padding: 2px;border: none">
                <tr>
                    <th colspan="6">
                        <h5 align="center">Loans</h5>
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
                        if ($state['LO_DATE'] != '') {
                            echo date('d-m-Y', strtotime($state['LO_DATE']));
                        }
                        ?>
                    </td>
                    <td>Installments : <?php echo $state['LO_INST'] ?></td>
                    <td>Rate of Interest: <?php echo $state['LO_ROI'] ?></td>
                </tr>
                <tr>
                    <td class="lable">Opening Bal(PRL): <?php echo $state['LO_P_OB'] ?></td>
                    <td>New Loan:<?php echo $state['LO_P_NEW'] ?></td>
                    <td>Receipts:<?php echo $state['LO_P_RCPT'] ?></td>
                    <td>Closing Bal:<?php echo $state['LO_P_CB'] ?></td>
                </tr>
                <tr>
                    <td class="lable">Opening Bal(INT): <?php echo $state['LO_I_OB'] ?></td>
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
                        if ($state['EDLO_DATE'] != '') {
                            echo date('d-m-Y', strtotime($state['EDLO_DATE']));
                        }
                        ?>
                    </td>
                    <td>Installments: <?php echo $state['EDLO_INST'] ?></td>
                    <td>Rate of Interest: <?php echo $state['EDLO_ROI'] ?></td>
                </tr>
                <tr>
                    <td>Opening Bal(PRL): <?php echo $state['EDLO_P_OB'] ?></td>
                    <td>New Loan :<?php echo $state['EDLO_P_NEW'] ?></td>
                    <td>Receipts : <?php echo $state['EDLO_P_RCPT'] ?></td>
                    <td>Closing Bal : <?php echo $state['EDLO_P_CB'] ?></td>
                </tr>
                <tr>
                    <td class="lable">Opening Bal(INT):<?php echo $state['EDLO_I_OB'] ?></td>
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
            <table class=" table table-bordered table-condensed" style="width: 650px; margin: auto; padding: 2px; border: 1px solid">
                <tr>
                    <th colspan="2">
                        SURETY GIVEN DETAILS
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
            </table>
            <?php
        }
        ?>
        <table class="lloan_info" style="width: 650px; margin: auto; padding: 2px;border: none">
            <tr>
                <th colspan="6">
                    <h5 align="center">TRANSACTION DETAILS</h5>
                </th>
            </tr>
        </table>
        <table class="table table-bordered table-condensed" style="width: 650px; margin: auto; padding: 2px; border: 1px solid">
            <tr>
                <th style="width: 10%">Tran.Date</th>
                <th style="width: 15%" colspan="2">TD</th>
                <th style="width: 15%" colspan="2">VTD</th>
                <th style="width: 30%" colspan="3">LONG</th>
                <th style="width: 30%" colspan="3">EDL</th>
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
            $get_trans_dates = new Database;
            $get_trans_dates->prepare("select TRANS_DATE from th_thrift_deposit_trans where EMP_NO = $user and TRANS_DATE > '$from_date' and TRANS_DATE < '$end_date' "
                    . "union "
                    . "select TRANS_DATE from th_vtd_trans where EMP_NO = $user and TRANS_DATE > '$from_date' and TRANS_DATE < '$end_date' "
                    . "union "
                    . "select TRANS_DATE from th_edl_trans where EMP_NO = $user and TRANS_DATE > '$from_date' and TRANS_DATE < '$end_date' "
                    . "union "
                    . "select TRANS_DATE from th_loan_trans where EMP_NO = $user and TRANS_DATE > '$from_date' and TRANS_DATE < '$end_date' "
                    . "order by TRANS_DATE asc");
            $trans_dates = $get_trans_dates->resultset();
            foreach ($trans_dates as $date) {
                $tr_date = $date['TRANS_DATE'];
                ?>
                <tr>
                    <td><?php echo date('d-M-Y', strtotime($tr_date)) ?></td>
                    <td>
                        <?php
                        $get_td_recpt_data = new Database;
                        $get_td_recpt_data->prepare("select AMOUNT from th_thrift_deposit_trans where TRANS_DATE = '$tr_date' "
                                . "and TYPE_OF_TRANS = 'R' and EMP_NO = $user ");
                        $td_recpt_data = $get_td_recpt_data->resultset();
                        foreach ($td_recpt_data as $td_recpt_data) {
                            echo $td_recpt_data['AMOUNT'];
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $get_td_payment_data = new Database;
                        $get_td_payment_data->prepare("select AMOUNT from th_thrift_deposit_trans where TRANS_DATE = '$tr_date' "
                                . "and TYPE_OF_TRANS = 'P' and EMP_NO = $user ");
                        $td_payment_data = $get_td_payment_data->resultset();
                        foreach ($td_payment_data as $td_payment_data) {
                            echo $td_payment_data['AMOUNT'];
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $get_vtd_recpt_data = new Database;
                        $get_vtd_recpt_data->query("select AMOUNT from th_vtd_trans where TRANS_DATE = '$tr_date' "
                                . "and TYPE_OF_TRANS = 'R' and EMP_NO = $user ");
                        $vtd_recpt_count = $get_vtd_recpt_data->count();
                        if ($vtd_recpt_count > 0) {
                            $vtd_recpt_data = $get_vtd_recpt_data->resultset();
                            foreach ($vtd_recpt_data as $vtd_recpt_data) {
                                echo $vtd_recpt_data['AMOUNT'];
                            }
                        } else {
                            echo '0';
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $get_vtd_payment_data = new Database;
                        $get_vtd_payment_data->query("select AMOUNT from th_vtd_trans where TRANS_DATE = '$tr_date' "
                                . "and TYPE_OF_TRANS = 'P' and EMP_NO = $user ");
                        $vtd_payment_count = $get_vtd_payment_data->count();
                        if ($vtd_payment_count > 0) {
                            $vtd_payment_data = $get_vtd_payment_data->resultset();
                            foreach ($vtd_payment_data as $vtd_payment_data) {
                                echo $vtd_payment_data['AMOUNT'];
                            }
                        } else {
                            echo '0';
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $get_loan_emi_pri_data = new Database;
                        $get_loan_emi_pri_data->query("select AMOUNTP from th_loan_trans where TRANS_DATE = '$tr_date' and EMP_NO = $user");
                        $loan_emi_pri_data_count = $get_loan_emi_pri_data->count();
                        if($loan_emi_pri_data_count > 0){
                            $loan_emi_pri_data = $get_loan_emi_pri_data->resultset();
                            foreach ($loan_emi_pri_data as $loan_emi_pri_data){
                                echo $loan_emi_pri_data['AMOUNTP'];
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $get_loan_emi_int_data = new Database;
                        $get_loan_emi_int_data->query("select AMOUNTI from th_loan_trans where TRANS_DATE = '$tr_date' and EMP_NO = $user");
                        $loan_emi_int_data_count = $get_loan_emi_int_data->count();
                        if($loan_emi_int_data_count > 0){
                            $loan_emi_int_data = $get_loan_emi_int_data->resultset();
                            foreach ($loan_emi_int_data as $loan_emi_int_data){
                                echo $loan_emi_int_data['AMOUNTI'];
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $get_new_loan_data = new Database;
                        $get_new_loan_data->query("SELECT SACTIONED_AMOUNT FROM th_loan_master where SACTION_DATE = '$tr_date' and EMP_NO = $user");
                        $new_loan_count = $get_new_loan_data->count();
                        if($new_loan_count > 0){
                            $new_loan_data = $get_new_loan_data->resultset();
                            foreach ($new_loan_data as $new_loan_data){
                                echo $new_loan_data['SACTIONED_AMOUNT'];
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $get_loan_emi_pri_data = new Database;
                        $get_loan_emi_pri_data->query("select AMOUNTP from th_edl_trans where TRANS_DATE = '$tr_date' and EMP_NO = $user");
                        $loan_emi_pri_data_count = $get_loan_emi_pri_data->count();
                        if($loan_emi_pri_data_count > 0){
                            $loan_emi_pri_data = $get_loan_emi_pri_data->resultset();
                            foreach ($loan_emi_pri_data as $loan_emi_pri_data){
                                echo $loan_emi_pri_data['AMOUNTP'];
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $get_loan_emi_int_data = new Database;
                        $get_loan_emi_int_data->query("select AMOUNTI from th_edl_trans where TRANS_DATE = '$tr_date' and EMP_NO = $user");
                        $loan_emi_int_data_count = $get_loan_emi_int_data->count();
                        if($loan_emi_int_data_count > 0){
                            $loan_emi_int_data = $get_loan_emi_int_data->resultset();
                            foreach ($loan_emi_int_data as $loan_emi_int_data){
                                echo $loan_emi_int_data['AMOUNTI'];
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $get_new_loan_data = new Database;
                        $get_new_loan_data->query("SELECT SACTIONED_AMOUNT FROM th_ed_loan_master where SACTION_DATE = '$tr_date' and EMP_NO = $user");
                        $new_loan_count = $get_new_loan_data->count();
                        if($new_loan_count > 0){
                            $new_loan_data = $get_new_loan_data->resultset();
                            foreach ($new_loan_data as $new_loan_data){
                                echo $new_loan_data['SACTIONED_AMOUNT'];
                            }
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <div id="click">
            <span align="right" style="margin-left: 30%;
                  margin-right: 30%;"><a id="printing" onclick="hideme()"   href="javascript:window.print();">Print</a></span>
            <span align="left"><a href="#" id="printing" onclick="closewin();">close</a></span>
        </div>
    </body>
</html>