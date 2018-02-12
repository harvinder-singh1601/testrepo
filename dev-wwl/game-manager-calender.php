<?php
include 'dbConfig.php';
$page_title = "Game-Calender";
$page_description = "Game Calender Page";
include("header.php");
?>
			<!--==Other Tab Pages==-->
			<div class="otherPages">
				<!--Tab Aside Nav-->
			<?php include "sidebar.php"?>

				<!--Game Calender Section-->
				<div id="game-calender-area">

					<div class="gameCalender">
						<div class="calender-month">
							<h2 class="month-name">September</h2>
							<ul class="cDateRow">
								<li data-toggle="tab" href="#cd1">
									<p>1</p>
								</li>
								<li data-toggle="tab" href="#cd2">
									<p>2</p>
								</li>
								<li data-toggle="tab" href="#cd3">
									<p>3</p>
								</li>
								<li>
									<p>4</p>
								</li>
								<li>
									<p>5</p>
								</li>
								<li>
									<p>6</p>
								</li>
								<li>
									<p>7</p>
								</li>
								<li>
									<p>8</p>
								</li>
								<li class="cpublishg">
									<p>9</p>
								</li>
								<li>
									<p>10</p>
								</li>
								<li class="cpublishg">
									<p>11</p>
								</li>
								<li>
									<p>12</p>
								</li>
								<li>
									<p>13</p>
								</li>
								<li class="cpublishg">
									<p>14</p>
								</li>
								<li>
									<p>15</p>
								</li>
								<li>
									<p>16</p>
								</li>
								<li>
									<p>17</p>
								</li>
								<li class="cpublishg caccountc">
									<p>18</p>
								</li>
								<li class="cpublishg">
									<p>19</p>
								</li>
								<li>
									<p>20</p>
								</li>
								<li class="caccountc">
									<p>21</p>
								</li>
								<li>
									<p>22</p>
								</li>
								<li>
									<p>23</p>
								</li>
								<li>
									<p>24</p>
								</li>
								<li>
									<p>25</p>
								</li>
								<li>
									<p>26</p>
								</li>
								<li class="cpublishg">
									<p>27</p>
								</li>
								<li>
									<p>28</p>
								</li>
								<li>
									<p>29</p>
								</li>
								<li>
									<p>30</p>
								</li>
								<li>
									<p>31</p>
								</li>
								<li class="ddisable">
									<p>1</p>
								</li>
								<li class="ddisable">
									<p>2</p>
								</li>
								<li class="ddisable">
									<p>3</p>
								</li>
								<li class="ddisable">
									<p>4</p>
								</li>
							</ul>

						</div>
						<div class="cPublishInfo">
							<div class="tab-content">
								<div id="cd1" class="tab-pane fade in active">
									<div class="eachDateInfo">
										<h2>Sept. <span class="clickedDate">1st</span></h2>
										<p>Game x releases<br> at 2:00 am</p>
										<p>100 Credits Transfered to Bank Account 1</p>
									</div>
								</div>
								<div id="cd2" class="tab-pane fade">
									<div class="eachDateInfo">
										<h2>Sept. <span class="clickedDate">2nd</span></h2>
										<p>Game x releases<br> at 2:00 am</p>
										<p>100 Credits Transfered to Bank Account 1</p>
									</div>
								</div>
								<div id="cd3" class="tab-pane fade">
									<div class="eachDateInfo">
										<h2>Sept. <span class="clickedDate">3rd</span></h2>
										<p>Game x releases<br> at 2:00 am</p>
										<p>100 Credits Transfered to Bank Account 1</p>
									</div>
								</div>
							</div>
							<ul class="cIndicate">
								<li>Game Published</li>
								<li>Account Change</li>
							</ul>
						</div>

					</div>

				</div>
				<!--tab Indicator-->

			<!--== Footer Area==-->
			</div>

		</div>


			<?php include("footer.php"); ?>
