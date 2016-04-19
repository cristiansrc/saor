<!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div class="page-content">
                
                <?php 
                if($tipo == 'warning'){
                ?>
                <div class="note note-warning"><h3>Advertencia! <?php echo $titulo?></h3>
                    <p><?php echo $descripcion?></p>
                </div>
                <?php 
                }
                ?>
                
                <?php 
                if($tipo == 'success'){
                ?>
                <div class="note note-success"><h3>Exitoso! <?php echo $titulo?></h3>
                    <p><?php echo $descripcion?></p>
                </div>
                <?php 
                }
                ?>
                
                <?php 
                if($tipo == 'danger'){
                ?>
                <div class="note note-danger"><h3>Atencion! <?php echo $titulo?></h3>
                    <p><?php echo $descripcion?></p>
                </div>
                <?php 
                }
                ?>
                
                <?php 
                if($tipo == 'info'){
                ?>
                <div class="note note-info"><h3>Informacion! <?php echo $titulo?></h3>
                    <p><?php echo $descripcion?></p>
                </div>
                <?php 
                }
                ?>
                
            </div>
            