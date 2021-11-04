<?php
ob_start();
session_start();
include 'header.php';
?>

<style>
    input:not([type="email"]){
        text-transform: uppercase;
    }
    .table-condensed>tbody>tr>td, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>td, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>thead>tr>th
    {
        padding: 0;
    }
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
        padding: 0;
        border-top: none;
    }
    .sno{
        padding: 0px;
    }
    .wrap{
        margin-top: 60px;
    }
    .headding{
        display: none;
    }
    ol li{
        font-size: 12px;
    }
    @media print{
        .report{
            font-size: x-small;
        }
        .headding{
            display: block;
        }
        /*        .article{
                    padding: 0;
                }*/
        .area-padding {
            padding: 0;
        }
    }

</style>

<div class="about-area area-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12" id="info_div">
                <form method="post" action="data_scripts.php" autocomplete="off">
                    <div class="col-md-6">
                        <span class="side_heading">Present Address</span>
                        <input type="hidden" value="<?php echo $user ?>" name="user">
                        <div class="form-group">
                            <input class="form-control" name="d_no" id="d_no" required placeholder="D.No / Q.No">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="street" id="street" required placeholder="Street">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="area" id="area" required placeholder="Area" onblur="enable_copy();">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="city" id="city" required placeholder="CIty" >
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="district" id="district" required placeholder="District" value="Visakhapatnam">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="state" id="state" required placeholder="State" value="Andhra Pradesh">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="pin" id="pin" required placeholder="Pin">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <span class="side_heading">Permanent Address</span>
                        <span id="copy">
                            <input  type="checkbox" id="same_address" name="same_address" onchange="return copy_address();"> <small>Click this if this is same as Present Address</small>
                        </span>
                        <div class="form-group">
                            <input class="form-control" name="p_d_no" id="p_d_no" required placeholder="D.No / Q.No">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="p_street" id="p_street" required placeholder="Street">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="p_area" id="p_area" required placeholder="Area">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="p_city" id="p_city" required placeholder="CIty">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="p_district" id="p_district" required placeholder="District">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="p_state" id="p_state" required placeholder="State">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="p_pin" id="p_pin" required placeholder="Pin">
                        </div>
                    </div>
                    <div class="col-md-4 col-md-offset-4">
                        <button class="form-control btn btn-success" name="update_addr">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    include 'footer.php';
    ?>
