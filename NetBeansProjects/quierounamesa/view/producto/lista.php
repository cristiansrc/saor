

<!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div class="page-content">
                <div class="row">
                    <!--div class="col-lg-12">
                        <div class="note note-success"><h4 class="box-heading">Datatables</h4>

                            <p>Main features from datatables: paging, search, sorter, filter</p>

                           <p>Export tool work on Flash Environment, check other <a href="table-export.html"
                                                                                     target="_blank">Table Export</a>
                            </p>

                            <p>To use "Edit" feature, please check it <a href="table-editable.html" target="_blank">Editable</a>
                            </p></div>
                    </div-->
                    <div class="col-lg-12">
                        <div class="portlet box">
                            <div class="portlet-header">
                                <div class="caption"><a href="<?php echo (_APPLICACION_URL . $urlNew)?>" class="btn btn-info btn-outlined" type="button"><?php echo $labelNew?></a></div>
                            </div>
                            <div class="portlet-body">
                                   <?php echo $table->codeTable()?>
                            </div>
                        </div>
                    </div>
                </div>
               <?php $table->modalForm()?>
               <?php $table->functionJs()?>
               <?php $table->funtionDeleteJs()?>
               
            </div>

            
            