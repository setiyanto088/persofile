<?php  
	
    $profileid = $this->session->userdata('GROUP_ID');     
	
	if(isset($profileid)&& !empty($profileid)){
	
	$menus = $this->general->gen_main_menu($profileid);	
?>

			<!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">

                    <ul class="sidebar-menu">
						 <li>
                            <a href="<?php echo base_url('dashboard');?>">
                                <em class="fa fa-th"></em> <span>Menu</span>
								
                            </a>
                        </li>
						
                        <?php 
                        for($i=0;$i<count($menus);$i++)
                        { 
                        ?>
                        <li class="treeview">
                            <a href="#">
                                <em class="fa fa-folder"></em>
                                <span><?php echo $menus[$i]['namamenu'];?></span>
                                <em class="fa fa-angle-left pull-right"></em>
                            </a>
                            <?php 
                            $sub_menu = $this->general->gen_sub_menu($menus[$i]['idmenu']); 
                            $jml = count($sub_menu);
                            
                            if($jml > 0)
                            { 
                            ?>
                            <ul class="treeview-menu">
                                <?php 
                                for($x=0;$x<count($sub_menu);$x++)
                                { 
                                ?>   
                                <li><a href="<?php echo base_url($sub_menu[$x]['menu']);?>"><em class="fa fa-angle-double-right"></em> <?php echo $sub_menu[$x]['namamenu']; ?></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                            <?php
                            }
                            ?>
                        </li>
                        <?php 
                        } 
                        ?>
                    </ul>
                </section>
                <!-- /.sidebar -->
				
<?php }else{ redirect('logout'); }?>
	

            </aside>