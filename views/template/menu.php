<aside class="main-sidebar ">
	<section class="sidebar">
		<div class="user-panel">
			<div class="pull-left image">
				<img src="./misc/img/usuario/<?php echo $infoUser['imgPerfil']?>" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info" style="width: 100%">
				<p>
					<?php echo $infoUser['Nombre'] ?>
				</p>
			</div>
		</div>
		<ul class="sidebar-menu">
			<li class="header">
				MENU DE NAVEGACION
			</li>
			<li class="treeview"> <!-- <li class="treeview active">-->
				<a href="home" id="home" class="menuItem">
					<i class="fa fa-home"></i>
					<span>Inicio</span>
				</a>
			</li>
			<?php
				/*
					SELECT * FROM pv_menu_sitio T0
					INNER JOIN pv_pagina T1 ON (T0.Id_Menu_Sitio = T1.Id_Menu_Sitio)
					LEFT JOIN pv_permiso T2 ON (T1.Id_Pagina = T2.Id_Pagina)
					WHERE T2.`Id_Usuario` = 8
				*/
				include_once './models/menu.php';
				$menu = new Menu();
				$arrayMenu = $menu->readMenu();
				$menu = $arrayMenu[0];//get data of cache
				$SubMenu = $arrayMenu[1];//get data of cache
				
				foreach ($menu as $key => $value) {
					echo '<li class="treeview">
							<a href="">
								<i class="fa '.$value['icon'].'"></i><span>'.$key.'</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">';

					unset($value["icon"]);//elimina elemento de arreglo
					foreach ($value as $subKey => $subVal) {
						if($SubMenu){
							$page = $SubMenu[$subKey]["Nombre"];
							echo '<li><a class="menuItem" href="'.$page.'"><i class="fa fa-circle-o"></i>'.$subVal.'</a></li>';
						}
					}
					echo '</ul></li>';
				}
			?>
		</ul>
	</section>
</aside>