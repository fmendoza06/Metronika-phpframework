					<!--Menu-->
					<!--================================-->
					<div id="mainnav-menu-wrap">
						<div class="nano">
							<div class="nano-content">
								<ul id="mainnav-menu" class="list-group">
						
									<!--Category name-->
									<li class="list-header">Menu de Navegacion</li>
						
									<!--Menu list item-->
									<li>
										<a href="index.html">
											<i class="fa fa-dashboard"></i>
											<span class="menu-title">
												<strong>Inicio</strong>
												<span class="label label-success pull-right">Top</span>
											</span>
										</a>
									</li>
						
		                            {menu_item name='serCmdShowListTest'
                                               id='serCmdShowListTest'
											   label = 'Test'
                                    }
		                            {menu_item name='serCmdShowListWp_commentmeta'
                                               id='serCmdShowListWp_commentmeta'
											   label = 'Wp_commentmeta'
                                    }
									{menu_item name='serCmdShowListWp_comments'
                                               id='serCmdShowListWp_comments'
											   label = 'Wp_comments'
                                    }
		                            {menu_item name='serCmdShowListWp_layerslider'
                                               id='serCmdShowListWp_layerslider'
											   label = 'Wp_layerslider'
                                    }

		                            {menu_item name='serCmdShowListWp_links'
                                               id='serCmdShowListWp_links'
											   label = 'Wp_links'
                                    }									

								</ul>


								<!--Widget-->
								<!--================================-->
								<div class="mainnav-widget">

									<!-- Show the button on collapsed navigation -->
									<div class="show-small">
										<a href="#" data-toggle="menu-widget" data-target="#demo-wg-server">
											<i class="fa fa-desktop"></i>
										</a>
									</div>

									<!-- Hide the content on collapsed navigation -->
									<div id="demo-wg-server" class="hide-small mainnav-widget-content">
										<ul class="list-group">
											<li class="list-header pad-no pad-ver">Server Status</li>
											<li class="mar-btm">
												<span class="label label-primary pull-right">15%</span>
												<p>CPU Usage</p>
												<div class="progress progress-sm">
													<div class="progress-bar progress-bar-primary" style="width: 15%;">
														<span class="sr-only">15%</span>
													</div>
												</div>
											</li>
											<li class="mar-btm">
												<span class="label label-purple pull-right">75%</span>
												<p>Bandwidth</p>
												<div class="progress progress-sm">
													<div class="progress-bar progress-bar-purple" style="width: 75%;">
														<span class="sr-only">75%</span>
													</div>
												</div>
											</li>
											<li class="pad-ver"><a href="#" class="btn btn-success btn-bock">View Details</a></li>
										</ul>
									</div>
								</div>
								<!--================================-->
								<!--End widget-->

							</div>
						</div>
					</div>
					<!--================================-->
					<!--End menu-->