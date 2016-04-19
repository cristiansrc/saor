    <div class="clearfix"></div>
        <nav id="sidebar" role="navigation" class="navbar-default navbar-static-side">
            <div class="sidebar-collapse menu-scroll">
                <ul id="side-menu" class="nav">
                    <li class="user-panel">
                        <div class="thumb">
                            <a data-title="Foto de perfil" data-lightbox="pefil" href="<?php echo _IMAGE_URL?>600x/<?php echo $_SESSION['img']?>">
                                <img src="<?php echo _IMAGE_URL?>128x/<?php echo $_SESSION['img']?>" alt="" class="img-circle"/>
                            </a>
                        </div>
                        <div class="info"><p><?php echo ($_SESSION['primer_nombre'] . ' ' . $_SESSION['primer_apellido'])?></p>
                            <ul class="list-inline list-unstyled">
                                <!--li><a href="extra-profile.html" data-hover="tooltip" title="Profile"><i
                                        class="fa fa-user"></i></a></li>
                                <li><a href="email-inbox.html" data-hover="tooltip" title="Mail"><i
                                        class="fa fa-envelope"></i></a></li>
                                <li><a href="#" data-hover="tooltip" title="Setting" data-toggle="modal"
                                       data-target="#modal-config"><i class="fa fa-cog"></i></a></li-->
                                <li><a href="<?php echo _APPLICACION_URL?>login/exitSession.html" data-hover="tooltip" title="Salir de session"><i
                                        class="fa fa-sign-out"></i></a></li>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </li>
                    <?php 
                    foreach ($menus as $menu) {
                        $active = (strpos($menu->get('url_menu'), _CURRENT_CONTROLLER_CLASS) !== false)? 'class="active"' : '';
                    ?>
                    <li <?php echo $active?>><a href="<?php echo (_APPLICACION_URL . $menu->get('url_menu'))?>.html"><i class="<?php echo $menu->get('icon_menu')?> fa-fw">
                        <div class="icon-bg bg-orange"></div>
                    </i><span class="menu-title"><?php echo $menu->get('nombre_menu')?></span></a></li>
                    <?php 
                    }
                    ?>
                </ul>
            </div>
        </nav>  
    
    
      <!--END CHAT FORM--><!--BEGIN PAGE WRAPPER-->
        <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title"><?php echo $titulo?></div>
                    
                </div>
                <ol class="breadcrumb page-breadcrumb">
                    <?php 
                    foreach ($breadcrumb as $arr) {    
                        if($arr['url'] !== ''){
                    ?>
                    <li>
                        <a href="<?php echo (_APPLICACION_URL . $arr['url'])?>"><?php echo $arr['label']?></a>&nbsp;&nbsp;
                        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;
                    </li>
                    
                    <?php 
                        }else{
                        ?>
                        <li class="active"><?php echo $arr['label']?></li>
                        <?php
                        }
                    }
                    ?>
                </ol>
                <div class="btn btn-blue reportrange hide"><i class="fa fa-calendar"></i>&nbsp;<span></span>&nbsp;report&nbsp;<i
                        class="fa fa-angle-down"></i><input type="hidden" name="datestart"/><input type="hidden"
                                                                                                   name="endstart"/>
                </div>
                <div class="clearfix"></div>
            </div>