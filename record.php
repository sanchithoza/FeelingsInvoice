<?php
include('leftbar.php');
$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM salesregister ORDER BY billdate";
$res = $conn->query($sql);
$conn->close();
?>
<div class="container">
  
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                <div class="row"><div class="col-lg-10">
                    <h4>Sales Record</h4></div><div class="col-lg-2"><a href="index.php" class="btn btn-info" role="button">Add</a></div></div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Bill Number</th>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Grand Total</th>
                                            <!-- <th>Remark</th>
                                            <th>Total Amount</th> -->
                                            <th></th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php 
                                        
                                        while($result=$res->fetch_object()){
                                            /*print_r($res);*/
                                            ?>  
                                            <tr class="odd gradeX">
                                              <td><?php echo $result->billNo; ?></td>
                                              <td><?php echo htmlentities( strtoupper($result->billdate));?></td>
                                              <td><?php echo htmlentities(strtoupper($result->customerName));?></td>
                                              <td><?php echo $result->grossTotal;?></td>
                                              <!-- <td><?php echo htmlentities(strtoupper($result->netTotal));?></td> -->
                                              <td>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#<?php echo "del".$result->id;?>">Delete</button>
<a href="invoice.php?bill=<?php echo htmlentities($result->billNo); ?>" class="btn btn-info" role="button" target="_blank">View</a>

                                                <div class="modal" tabindex="-1" role="dialog" id="<?php echo "del".$result->id;?>">
                                                  <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title">Do You Want To Delete ?</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                      </button>
                                                  </div>
                                                  <div class="modal-body">
                                                    <p><?php echo htmlentities(strtoupper($result->customerName));?> </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="database.php?del=<?php echo htmlentities($result->billNo); ?>" class="btn btn-info" role="button">Yes</a>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                            </tr>

                        <?php } ?>                
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
            <!--  <a target="_blank" href="clientListPDF.php" class="btn btn-info" role="button">Print Client List</a> -->
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
</div>
<!-- /.col-lg-12 -->
</div>
<!-- /.row -->



</div>

<!-- /#wrapper -->
<?php include('footer.php');?>