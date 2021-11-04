<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:index.php");
}
include 'header.php';

function disp() {
    if (isset($_POST['btnadd'])) {
        $amount = trim($_POST['txtnum1']);
        $rate = trim($_POST['txtnum2']);
        $term = trim($_POST['txtnum3']);
        $rate_month = ($rate / 100) / 12;
        $int = ($amount * $rate_month);
        global $emi;
        $emi = $amount * (($rate_month * (pow(1 + $rate_month, $term))) / (pow(1 + $rate_month, $term) - 1));

//        echo '' . ceil($emi / 10) * 10 .'<br>';
//        echo $int.'<br>';
        number_format($emi) . '<br> <br> <br>';
        ?>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <table class="table table-bordered">
                    <thead>
                    <th>Months</th>
                    <th>EMI</th>
                    <th>Interest </th>
                    <th>Principle</th>
                    <th>Loan Amount</th>

                    </thead>
                    <tr>
                        <td>
                            0
                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                        <td>
                            <?php echo number_format($amount); ?>
                        </td>
                    </tr>


                    <?php
                    for ($i = 1; $i <= $term; $i++) {
                        $int = ($amount * $rate_month);
                        $principle = $emi - $int;
                        $amount = $amount - $principle;

//                echo $i .'  | '.number_format($emi).'  | '.number_format($amount). ' |  '. number_format($int). '  | ' .number_format($principle).   '<br>';
                        ?>
                        <tr>
                            <td>
                                <?php echo $i; ?>
                            </td>
                            <td>
                                <?php echo number_format($emi); ?>
                            </td>

                            <td>
                                <?php echo number_format($int); ?>
                            </td>
                            <td>
                                <?php echo number_format($principle); ?>
                            </td>
                            <td>
                                <?php echo number_format($amount); ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
        <?php
    }
}
?>
<style>
    #customers {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 50%;
    }

    #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr:nth-child(even){background-color: #f2f2f2;}

    #customers tr:hover {background-color: #ddd;}

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }
</style>



<form action="" method="post" >
    <table class="table table-bordered" align="center" cellpadding="2" cellspacing="4">

        <tr>
            <td>Principle</td><td><input type="text" name="txtnum1" class="form-control" required="" placeholder="Enter Princple Amount"></td>
        </tr>

        <tr>
            <td>Interest</td><td><input type="text" name="txtnum2" class="form-control" required="" placeholder="Enter Rate of Intrest"></td>
        </tr>

        <tr>
        <tr>
            <td>No of Installments</td><td><input  type="text" name="txtnum3" class="form-control" required="" placeholder="Enter no.of Installmets in Months"></td>
        </tr>

        <tr>
            <td colspan="2" align="center" >
                <input type="submit" value="submit" class=" btn btn-success form-control" name="btnadd"></td>
        </tr>

    </table>   
</form>
<hr>
<div>
    <?php disp(); ?>
</div>
<?php include 'footer.php'; ?>
