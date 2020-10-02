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
				$menu = json_decode( $_COOKIE["_data2P"] ,true);
				$mParent = array_values(array_unique(array_column($menu, 'Descripcion')));
				$icons = array_values(array_unique(array_column($menu, 'Icono')));
				foreach ($mParent as $key => $val0) {
					echo '<li class="treeview">
						<a href="">
							<i class="fa '.$icons[$key].'"></i><span>'.$val0.'</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">';
					foreach ($menu as $val1) {
						if ($val0 == $val1['Descripcion']) {
							echo '<li>
								<a class="menuItem" href="'.$val1['Nombre'].'">
									<i class="fa fa-circle-o"></i>'.$val1['Descripcion2'].'
								</a>
							</li>';
						}
					}
					echo "
					</ul>
					</li>";
				}
			?>
		</ul>
	</section>
</aside>