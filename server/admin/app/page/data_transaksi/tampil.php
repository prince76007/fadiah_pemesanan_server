<body>

  <style>
    .label {
      padding: 5px;
      white-space:nowrap;
      border-radius: 5px;
    }
    .label.label-success {
      background-color: #5cb85c;
    }
    .label.label-info {
      background-color: #5bc0de;
    }
  </style>

  <form name="formcari" id="formcari" action="cetak.php" method="get">
    <fieldset>
      <table>
        <tbody>
          <!-- <tr>
            <td>Berdasarkan</td>
            <td>:</td>
            <td>
              <!-- <input value="" name="Berdasarkan" id="Berdasarkan" > -->
              <!-- <select class="form-control selectpicker" data-live-search="true" name="Berdasarkan" id="Berdasarkan"> -->
                <?php
                // $sql = "desc data_pemesanan";
                // $result = @mysql_query($sql);
                // while ($row = @mysql_fetch_array($result)) {
                //   echo "<option name='berdasarkan' value=$row[0]>$row[0]</option>";
                // }
                ?>
              <!-- </select> -->
            </td>
          </tr>
          <tr>
							<td  style="width:30%">Dari Tanggal :</b></td>	
							
							<td><input type="date" name="tanggal1"></td>
						</tr>
						
						<tr>
							<td  style="width:30%">Sampai Tanggal :</b></td>	
							
							<td><input type="date" name="tanggal2"></td>
						</tr>
<tr><td> </td></tr>
<tr><td> </td></tr>
<tr><td> </td></tr>
<tr><td> </td></tr>
          <tr>
            <td>
              <!--<input class="form-control" type="text" name="isi" value="" >--> 
              <!-- <input type="text" name="isi" value=""> -->
              <button  class='btn btn-success' formaction=""><i class='fa fa-search'></i>Cari</button>
            </td>
            <td align='right'>
            <?php btn_preview_laporan('Print Preview'); ?>
            <?php btn_cetak_laporan('Print'); ?>
								<?php btn_export_laporan('Export Excel'); ?>
                
            </td>
          </tr>
        </tbody>
      </table>
    </fieldset>
  </form>

  <div style="overflow-x:auto;">
    <table <?php tabel(100, '%', 1, 'left'); ?>>
      <tr>
        <th>Action</th>
        <th>No</th>
        <!--h <th>Id Pemesanan </th> h-->
        <th align="center" class="th_border cell">Tanggal </th>
        <th align="center" class="th_border cell">Total Bayar </th>
      </tr>

      <tbody>
        <?php
        $no = 0;
        $startRow = ($page - 1) * $dataPerPage;
        $no = $startRow;
        $sdate="";
          $filter="SELECT * FROM data_pemesanan where ";
        if (isset($_GET['tanggal1']) && !empty($_GET['tanggal1'])) {
          $sdate = $filter." tanggal >='".mysql_real_escape_string($_GET['tanggal1'])."'";
          // $isi = mysql_real_escape_string($_GET['isi']);
          $querytabel=$sdate." LIMIT $startRow , $dataPerPage";
          $querypagination = "SELECT COUNT(*) AS total FROM data_pemesanan where $querytabel";
        } if(isset($_GET['tanggal2']) && !empty($_GET['tanggal2'])){
          if(empty($sdate)){
            $sdate=$filter;
          }else{
            $sdate="$sdate AND ";
          }
          $edate = mysql_real_escape_string($_GET['tanggal2']);
          $querytabel="$sdate tanggal <= '$edate' LIMIT $startRow , $dataPerPage";
          $querypagination = "SELECT COUNT(*) AS total FROM data_pemesanan where $querytabel";
        }else if((!isset($_GET['tanggal1']) && !isset($_GET['tanggal2'])) ||
         (empty($_GET['tanggal1']) && empty($_GET['tanggal2']))) {
          $querytabel = "SELECT * FROM data_pemesanan LIMIT $startRow ,$dataPerPage";
          $querypagination = "SELECT COUNT(*) AS total FROM data_pemesanan";
        }
        $proses = mysql_query($querytabel);
        while ($data = mysql_fetch_array($proses)) {
        ?>
          <tr class="event2">

            <td class="th_border cell" align="center" width="200">
              <table border="0">
                <tr>
                  <!--<td>-->
                  <!--    <a href="<?php index(); ?>?input=detail&proses=<?= encrypt($data['id_pemesanan']); ?>">-->
                  <!--    <?php btn_detail('Detail Pemesanan'); ?>-->
                  <!--    </a>-->
                  <!--</td>-->
                  <td>
                    <a href="<?php index(); ?>?input=detail&proses=<?= encrypt($data['id_pemesanan']); ?>">
                      <?php btn_detail('Detail'); ?>
                    </a>
                  </td>
                  <!-- <td>
                    <a href="<?php index(); ?>?input=edit&proses=<?= encrypt($data['id_pemesanan']); ?>">
                      <?php btn_edit('Konfirmasi'); ?>
                    </a>
                  </td>
                  <td>
                    <a href="<?php index(); ?>?input=hapus&proses=<?= encrypt($data['id_pemesanan']); ?>">
                      <?php btn_hapus('batalkan'); ?>
                    </a>
                  </td> -->
                </tr>
              </table>
            </td>

            <td align="center" width="50"><?php $no = (($no + 1));
                                          echo $no; ?></td>
            <!--h <td align="center"><?php echo $data['id_pemesanan']; ?></td> h-->
            <td align="center"><?php echo format_indo($data['tanggal']); ?></td>
            <td align="center"><?php echo baca_database("", "nama", "select * from data_pelanggan where id_pelanggan='$data[id_pelanggan]'")  ?></td>
            <td align="center"><?php echo rupiah($data['total_bayar']); ?></td>

            <td align="center">
              <?php
              $no_meja = $data['alamat_pengiriman'];
              if ($no_meja == "100") {
                echo "<span class='label label-success'>Take Away</span>";
              } else {
                echo $no_meja . " <span class='label label-info'>Dine In</span>";
              }
              ?>
            </td>
            <td align="center">
              <?php $st = $data["status"];
              if ($st == "pengiriman") {
                $st = "Pemesanan";
              }
              echo $st;
              ?>
            </td>


          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <?php Pagination($page, $dataPerPage, $querypagination); ?>

</body>