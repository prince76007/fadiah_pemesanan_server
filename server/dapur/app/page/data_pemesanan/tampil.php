
<body>


    <form name="formcari" id="formcari" action="" method="get">
        <fieldset> 
            <table>
                <tbody>
                    <tr>
                        <td>Berdasarkan</td>	
                        <td>:</td>	
                        <td>
                            <!-- <input value="" name="Berdasarkan" id="Berdasarkan" > --> 
                            <select class="form-control selectpicker" data-live-search="true" name="Berdasarkan" id="Berdasarkan">
                                <?php
                                $sql = "desc data_pemesanan";
                                $result = @mysql_query($sql);
                                while ($row = @mysql_fetch_array($result)) {
                                    echo "<option name='berdasarkan' value=$row[0]>$row[0]</option>";
                                }
                                ?>
                            </select>							
                        </td>
                    </tr>

                    <tr>
                        <td>Pencarian</td>	
                        <td>:</td>	
                        <td>							
                                <!--<input class="form-control" type="text" name="isi" value="" >--> <input  type="text" name="isi" value="" >
                            <?php btn_cari('Cari'); ?>
                        </td>
                    </tr>
                </tbody>
            </table>									
        </fieldset>
    </form>

    <div style="overflow-x:auto;">
        <table <?php tabel(100, '%', 1, 'left'); ?> >
            <tr>								  
                <th>Action</th>
               
              
                <th align="center" class="th_border cell"  >Nomor Meja </th>
             
            </tr>

            <tbody>
                <?php
                $no = 0;
                $startRow = ($page - 1) * $dataPerPage;
                $no = $startRow;

                if (isset($_GET['Berdasarkan']) && !empty($_GET['Berdasarkan']) && isset($_GET['isi']) && !empty($_GET['isi'])) {
                    $berdasarkan = mysql_real_escape_string($_GET['Berdasarkan']);
                    $isi = mysql_real_escape_string($_GET['isi']);
                    $querytabel = "SELECT * FROM data_pemesanan where $berdasarkan like '%$isi%'  LIMIT $startRow ,$dataPerPage";
                    $querypagination = "SELECT COUNT(*) AS total FROM data_pemesanan where $berdasarkan like '%$isi%'";
                } else {
                    $querytabel = "SELECT * FROM data_pemesanan  LIMIT $startRow ,$dataPerPage";
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
                                    <!--    <?php btn_detail('Detail'); ?>-->
                                    <!--    </a>-->
                                    <!--</td>-->
                                    <td>
                                        <a href="<?php index(); ?>?input=edit&proses=<?= encrypt($data['id_pemesanan']); ?>">
                                        <?php btn_edit('Konfirmasi'); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php index(); ?>?input=hapus&proses=<?= encrypt($data['id_pemesanan']); ?>">
                                        <?php btn_hapus('batalkan'); ?>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                
                        <td align="center"><?php echo $data['alamat_pengiriman']; ?></td>
                        <td align="center"> <table <?php tabel(100, '%', 1, 'left'); ?> >
            <tr>								  
                
            
                <th align="center" class="th_border cell"  >Nama </th>
                <th align="center" class="th_border cell"  >Jumlah </th>
               

            </tr>

            <tbody>
                <?php
           
                $querytabel = "SELECT * FROM data_detail_pemesanan  ";
                    
                $proses = mysql_query($querytabel);
                while ($data = mysql_fetch_array($proses)) {
                    ?>
                    <tr class="event2">	
                        <td align="center"><?php  $id_menu_makanan = $data['id_menu_makanan']; echo baca_database("","nama","select * from data_menu_makanan where id_menu_makanan='$id_menu_makanan'")  ?></td>
                        <td align="center"><?php echo $data['jumlah']; ?></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
</td>

                    
                    </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

   
</body>
