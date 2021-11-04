<?php
ob_start();
include 'header.php';
?>

<div class="about-area area-padding">
    <div class="container">
        <div class="row">

            <div class="col-md-8">
                <div class="col-md-12">
                    <h3 align="center"><span class="blinking_text">Welcome To Thrift Society</span></h3>
                    <div align="center">
                        <strong style="color : green">make a missed call from your registered Mobile with society to the following numbers</strong>
                        <br>
                        <span class="missed_call">Surety Enquiry : 02240375734</span>
                        <br>
                        <span class="missed_call">Deposits Enquiry : 02240375735</span>

                    </div>
                    <br>
                </div>

                <div>

                    <span class=" side_heading">Co-operative Principles</span>
                    <br>
                    <style>
                        ol li{
                            /*text-align: justify;*/
                            margin-top: 10px;
                            display: block;
                        }
                    </style>
                    <ol style=" list-style-type: decimal; margin-top: 10px;">

                        <li><span style="color: rgb(0, 128, 0);"><u><strong>Voluntary, Open Ownership:</strong></u></span>&nbsp; Open to all without gender, social, racial, political, or religious discrimination. You may shop, you may join, and you may leave the co-op at any time.</li>
                        <li><span style="color: rgb(0, 128, 0);"><u><strong>Democratic Owner Control:</strong></u></span>&nbsp; One Owner, one vote. Your voice will be heard. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                        <li><span style="color: rgb(0, 128, 0);"><u><strong>Owner Economic Participation:</strong></u></span>&nbsp; Owners contribute equitably to, and democratically control, the capital of the cooperative. The economic benefits of a cooperative operation are returned to the Owners, reinvested in the co-op, or used to provide Owner services. You control the capital.</li>
                        <li><span style="color: rgb(0, 128, 0);"><u><strong>Autonomy And Independence:</strong></u></span>&nbsp; Cooperatives are autonomous, self-help organizations controlled by their Owners. Together, you are autonomous.</li>
                        <li><span style="color: rgb(0, 128, 0);"><u><strong>Education, Training And Information:</strong></u></span>&nbsp; Cooperatives provide education and training for Owners so they can contribute effectively to the development of their cooperatives. They inform the general public about the nature and benefits of cooperation. You can develop yourself into the consumer you want to be.</li>
                        <li><span style="color: rgb(0, 128, 0);"><u><strong>Cooperation Among Cooperatives:</strong></u></span>&nbsp; Cooperatives serve their Owners most effectively and strengthen the cooperative movement by working together through local, regional, national and international structures. You are more successful when you cooperate with others who know how to cooperate.</li>
                        <li><span style="color: rgb(0, 128, 0);"><u><strong>Concern For The Community:</strong></u></span>&nbsp; While focusing on Owner needs, cooperatives work for the sustainable development of their communities through policies accepted by their Owners. You can do something for the community even as you keep succeeding.</li>

                    </ol>

                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="row">
                    <?php
                    if (isset($_GET['login'])) {
                        if ($_GET['login'] == 'faild') {
                            ?>
                            <div class="alert alert-danger">
                                Invalid Captcha. Try Again Later.
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <?php include 'sidebar.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>