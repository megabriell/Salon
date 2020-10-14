<a href="./home/" class="logo">
	<span class="logo-mini">
		<img src="./misc/img/sistema/<?php echo $infoCompany['imgSegundaria'] ?>" alt="logo" title="<?php echo $infoCompany['Empresa']?>" width="45px">
	</span>
	<span class="logo-lg"> <img src="./misc/img/sistema/<?php echo $infoCompany['imgPrincipal']?>" alt="logo" title="<?php echo $infoCompany['Empresa']?>" width="180px">
	</span>
</a>

<!-- Encabezado Navbar -->
<nav class="navbar navbar-static-top" role="navigation">
	<!-- Botón de desplazamiento de la barra lateral-->
	<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
		<span class="sr-only">Toggle navigation</span>
	</a>

	<!-- Menú derecho de la barra de navegación -->
	<div class="navbar-custom-menu">
		<ul class="nav navbar-nav">

			<!-- Menú de la cuenta de usuario -->
			<li class="dropdown user user-menu">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><!-- Botón de cambio de menú -->
					<img src="./misc/img/usuario/<?php echo $infoUser['imgPerfil']?>" class="user-image" alt="User Image"><!-- La imagen del usuario en la barra de navegación -->
					<!-- Hidden-xs oculta el nombre de usuario en dispositivos pequeños para que solo aparezca la imagen. -->
					<span class="hidden-xs"> <?php echo $infoUser['Nombre'].' '.$infoUser['Apellido']?> </span>
				</a>

				<ul class="dropdown-menu">
					<li class="user-header bg-red" style="background: url('../misc/img/portada/<?php echo $infoUser['imgPortada']?>') center center; background-size: cover;"><!-- La imagen del usuario en el menú -->
						<img src="./misc/img/usuario/<?php echo $infoUser['imgPerfil']?>" class="img-circle" alt="User Image"/>
						<p><strong>
							<?php echo $infoUser['Nombre'].' '.$infoUser['Apellido']
							.'<br>'.rolSis($infoUser['sistema']).' '.$infoUser['CorreoA'];?><br>
							<small>
							Mi codigo de usuario: <?php echo $_session['idEmployee'];?>
							</small>
						</strong></p>
					</li>
					<!-- Menu de pie de pagina-->
					<li class="user-footer">
						<div class="pull-left">
							<a href="profile" class="btn bg-navy btn-default btn-flat menuItem">Perfil</a>
						</div>
						<div class="pull-right">
							<a href="./controllers/login_controller?logout" class="btn bg-navy btn-default btn-flat"> Cerrar Sesion </a>
						</div>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</nav>