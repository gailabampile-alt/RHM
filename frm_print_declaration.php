

<h3><i class="fa fa-angle-right"></i> Impressions</h3>
<br>
<!-- BASIC FORM ELELEMNTS -->
<div class="row mt">
    <div class="col-lg-4">
        
        <div class="white-panel pn">
            <div class="white-header">
                <h5>Déclaration SYNDICALE</h5>
            </div>
                <!-- Button trigger modal -->
                <button class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalSYNDIC">
                    <img src="img/Print_96px.png" class="img-circle" width="80">
                </button>
              <!-- Modal -->
              <div class="modal fade " id="myModalSYNDIC" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">DECLARATION SYNDICAL</h4>
                    </div>
                    <div class="modal-body">
                        <form class="" method="POST" action="traitement_print_pret.php" enctype="multipart/form-data">
                            <row class="mb-5">
                                <div class="col-lg-10 col-md-10 col-xl-10">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Devise</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" data-placeholder="Selectionnez une devise" name="devise" required>
                                                <option value=""> Choix Devise </option>
                                                <option value="CDF"> CDF </option>
                                                <option value="USD"> USD </option>
                                                <option value="CDF&USD"> CDF & USD </option>
                                            </select>         
                                        </div>
                                    </div>
                                </div>
                            </row>
                        </form>
                    </div>
                    <br>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
                </div>
              </div>

            <!--div class="row">
                <div class="col-md-6">
                    <p class="small mt">MEMBER SINCE</p>
                    <p>2012</p>
                </div>
                <div class="col-md-6">
                    <p class="small mt">TOTAL SPEND</p>
                    <p>$ 47,60</p>
                </div>
            </div-->
        </div>
    </div>
    <div class="col-lg-4">
        
        <div class="white-panel pn">
            <div class="white-header">
                <h5>Déclaration CNSS</h5>
            </div>
                <!-- Button trigger modal -->
                <button class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalCNSS">
                    <img src="img/Print_96px.png" class="img-circle" width="80">
                </button>
              <!-- Modal -->
              <div class="modal fade" id="myModalCNSS" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">DECLARATION CNSS</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>

    <div class="col-lg-4">
        
        <div class="white-panel pn">
            <div class="white-header">
                <h5>Déclaration CNSS</h5>
            </div>
                <!-- Button trigger modal -->
                <button class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalCNSS">
                    <img src="img/Print_96px.png" class="img-circle" width="80">
                </button>
              <!-- Modal -->
              <div class="modal fade" id="myModalCNSS" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <form>

                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
                </div>
              </div>

            <!--div class="row">
                <div class="col-md-6">
                    <p class="small mt">MEMBER SINCE</p>
                    <p>2012</p>
                </div>
                <div class="col-md-6">
                    <p class="small mt">TOTAL SPEND</p>
                    <p>$ 47,60</p>
                </div>
            </div-->
        </div>
    </div>
</div>


          
 