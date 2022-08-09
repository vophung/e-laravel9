<!DOCTYPE html>
<html lang="en">
	<head>
        @include('admin.blocks.head')   
	</head>
	<body>
		<div id="app">
			<div id="sidebar" class="active">
				<div class="sidebar-wrapper active">
					<div class="sidebar-header position-relative">
                        @include('admin.blocks.sidebar.sidebar-header')
					</div>
					<div class="sidebar-menu">
                        @include('admin.blocks.sidebar.sidebar-menu')
					</div>
				</div>
			</div>
			<div id="main">
				<header class="mb-3">
					<a href="#" class="burger-btn d-block d-xl-none">
					<i class="bi bi-justify fs-3"></i>
					</a>
				</header>
				@yield('content')
			</div>
		</div>
		@include('admin.blocks.foot')
	</body>
</html>