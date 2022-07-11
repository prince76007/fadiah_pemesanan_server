<?php
if (isset($_GET['input'])) {
    echo "<h3> Cetak Laporan ";
    tabelnomin();
    echo "</h3>";
    ?>
    <link rel="stylesheet" type="text/css" href="../../../data/cssjs/cetak/style_new.css">
    <link rel="stylesheet" type="text/css" href="../../../data/cssjs/cetak/style_new2.css">
    <?php
    action_cetak("data_pemesanan");
} else {

    function location() {
        return "cetak";
    }

    include '../../../include/all_include.php';
    proses_action_cetak("data_pemesanan");
    ?>
    <link rel="stylesheet" type="text/css" href="../../../data/cssjs/cetak/style_new.css">
    <link rel="stylesheet" type="text/css" href="../../../data/cssjs/cetak/style_new2.css">


    <!-- HEADER -->
    <table border="0" style="width: 100%">
        <?php
        if (isset($_GET['export'])) {
            
        } else {
            ?>
            <tr>
                <td class="auto-style1" rowspan="3" width="101">
                    <img alt="" height="100" src="<?php echo $logo_laporan1; ?>" width="100"></td>

                <td class="auto-style1">
            <center>
                <h2 class="auto-style1"><?php echo $judul; ?></h2>
            </center>
        </td>

        <td class="auto-style1" rowspan="3" width="101">
            <img alt="" height="100" src="<?php echo $logo_laporan2; ?>" width="100"></td>
        </tr>
    <?php } ?>

    <tr>
        <td class="auto-style2">
    <center>
        <strong>LAPORAN

            <?php
            $tabelnya = "data_pemesanan";
            $tabelnya = str_replace("_", " ", $tabelnya);
            $tabelnya = str_replace("data", "", $tabelnya);
            $tabelnya = strtoupper($tabelnya);
            echo $tabelnya;
            ?>

        </strong>
    </center>
    </td>
    </tr>

    <tr>
        <td class="auto-style2"><?php echo $alamat; ?></td>
    </tr>
    </table>
    <!-- HEADER -->

    <!-- BODY -->
    <table width="100%"  class="tblcms2">
        <tr>
            <th class="th_border cell">No</th>
           <!--h <th class="th_border cell">Id Pemesanan </th> h-->
                <th align="center" class="th_border cell"  >Tanggal </th>
                <th align="center" class="th_border cell"  >Total Bayar + PPN 10% </th>
        </tr>

        <tbody>
            <?php
            $no = 0;
            $sdate="";
          $filter="SELECT * FROM data_pemesanan where ";
        if (isset($_GET['tanggal1']) && !empty($_GET['tanggal1'])) {
          $sdate = $filter." tanggal >='".mysql_real_escape_string($_GET['tanggal1'])."'";
          // $isi = mysql_real_escape_string($_GET['isi']);
          $querytabel=$sdate." LIMIT 0 , 10";
          $querypagination = "SELECT COUNT(*) AS total FROM data_pemesanan where $querytabel";
        } if(isset($_GET['tanggal2']) && !empty($_GET['tanggal2'])){
          if(empty($sdate)){
            $sdate=$filter;
          }else{
            $sdate="$sdate AND ";
          }
          $edate = mysql_real_escape_string($_GET['tanggal2']);
          $querytabel="$sdate tanggal <= '$edate' LIMIT 0 , 10";
          $querypagination = "SELECT COUNT(*) AS total FROM data_pemesanan where $querytabel";
        }else if((!isset($_GET['tanggal1']) && !isset($_GET['tanggal2'])) ||
         (empty($_GET['tanggal1']) && empty($_GET['tanggal2']))) {
          $querytabel = "SELECT * FROM data_pemesanan LIMIT 0 , 10";
          $querypagination = "SELECT COUNT(*) AS total FROM data_pemesanan";
        }           
            $proses = mysql_query($querytabel);
            $nstrg="SELECT sum(total_bayar) as 'sum' ";
            $string_for_sum = $nstrg.explode("SELECT *",$querytabel)[1];
            $query_for_sum = mysql_query($string_for_sum);
            $sum=mysql_fetch_array($query_for_sum)[0];
            while ($data = mysql_fetch_array($proses)) {
                ?>
                <tr class="event2">
                    <td style="text-align: center;" width="50"><?php $no = $no + 1; echo $no; ?></td>
                    <!--h <td align="center"><?php echo $data['id_pemesanan']; ?></td> h-->
                        <td style="text-align: center;"><?php echo format_indo($data['tanggal']); ?></td>
                        <td style="text-align: center;"><?php echo rupiah($data['total_bayar'] + ($data['total_bayar']*10/100) ); ?></td>
                </tr>
    <?php } ?>
    <tr>
        <td colspan="2" align="center"></td><td></td>
    <tr>
    <tr>
        <td colspan="2" align="center">Total: </td>
        <td style="text-align: center;"><?php echo rupiah($sum + ($sum*10/100) );?></td>
    <tr>
        </tbody>
    </table>
    <!-- BODY -->

    <!-- FOOTER -->
    <p class="auto-style3"><?php echo $formatwaktu; ?>
    </p>
    <p class="auto-style3"><?php echo $ttd; ?></p>
    <p class="auto-style3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </p>
    <p class="auto-style3"><?php echo $siapa; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;</p>
    <p class="auto-style3"></p>

<?php } ?>
