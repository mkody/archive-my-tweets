<!-- index -->

			<div class="col-md-8">
				<div id="tweets" class="rounded">
					<?php echo ($header) ? '<div class="page-header"><h1>'.$header.'</h1></div>': ''; ?>

					<?php if ($tweets !== false): ?>
					<div class="list-group">
					<?php
						foreach ($tweets as $row):
							$t = new \AMWhalen\ArchiveMyTweets\Tweet();
							$t->load($row);
							$classes = array('tweet');
							if ($t->in_reply_to_status_id != 0) $classes[] = 'reply';
							if (substr($t->get_linked_tweet(), 0, 2) == 'RT') $classes[] = 'list-group-item-success';
							if ($t->favorited) $classes[] = 'list-group-item-warning';
							if ($t->truncated != 0) $classes[] = 'truncated';
							$class = implode(' ', $classes);
					?>
						<div class="list-group-item justify-content-between <?php echo $class; ?>">
							<p class="w-100 mb-1">
								<!-- <?= $t->user_id ?> -->
								<?php echo $t->get_linked_tweet(); ?>
								<br>
								<span class="float-right text-muted small">
									<?php echo ($t->in_reply_to_status_id != 0) ? '<a href="https://twitter.com/'.$t->in_reply_to_screen_name.'/status/'.$t->in_reply_to_status_id.'">in reply to '.$t->in_reply_to_screen_name.'</a>, ' : ''; ?>
									<a href="<?php echo ((isset($single_tweet) && $single_tweet) ? 'https://twitter.com/'.$config['twitter']['username'].'/status/' : $config['system']['baseUrl']).$t->id; ?>/" rel="bookmark"><?php echo $t->get_date(); ?></a>
									via <?php echo $t->source; ?>
								</span>
							</p>
						</div>
						<?php endforeach; ?>
					</div>
					<?php if (isset($pagination)) { ?>
						<div id="pagination"><?php echo $pagination; ?></div>
					<?php } ?>
					<?php else: ?>
						<p class="no-tweets lead">No tweets found!</p>
					<?php endif; ?>
				</div><!-- /tweets -->
			</div><!-- /span8 -->

			<div class="col-md-4">
				<div id="archive" class="widget sidebar sidebar-module sidebar-module-inset">
					<h3>Tweets<div class="float-right text-muted"><?php echo $totalTweets; ?></div></h3>
					<ul class="list-unstyled">
						<li class="<?php echo (isset($favorite_tweets) && $favorite_tweets) ? 'here' : ''; ?>">
							<a href="<?php echo $config['system']['baseUrl']; ?>favorites">
								<span class="month">Favorites</span>
								<span class="total float-right text-muted"><?php echo $totalFavoriteTweets; ?></span>
								<span class="bar"></span>
							</a>
						</li>
						<?php
						// months
						if ($twitterMonths !== false) {
							$class = '';
							foreach ($twitterMonths as $row) {
								$class = (isset($monthly_archive) && $monthly_archive && $archive_year==$row['y'] && $archive_month==$row['m']) ? 'here': '';
								$time = strtotime($row['y'].'-'.$row['m'].'-01');
								$date = date('F Y', $time);
								$url = $config['system']['baseUrl'].'archive/'.date('Y', $time).'/'.date('m', $time).'/';
								$bg_percent = round($row['total'] / $maxTweets * 100);
						?>
						<li class="<?= $class ?>">
							<a href="<?= $url ?>">
								<span class="month"><?= $date ?></span>
								<span class="total float-right text-muted"><?= $row['total'] ?></span>
								<span class="bar" style="width: <?= $bg_percent ?>%;"></span>
							</a>
						</li>
						<?php
							}
						} else {
							echo '<li>No monthly data.</li>';
						}
						?>
					</ul>
				</div><!-- /archive -->

				<div id="sources" class="widget sidebar sidebar-module sidebar-module-inset">
					<h3>Clients <small>(>256 Tweets)</small><div class="float-right text-muted"><?php echo $totalClients; ?></div></h3>
					<ul class="list-unstyled">
					<?php
						// sources
						if ($twitterClients !== false) {
							$class = '';
							foreach ($twitterClients as $row) {
								if ($row['total'] >= 256) {
									$client_name = strip_tags($row['source']);
									$class = (isset($per_client_archive) && $per_client_archive && $client==$client_name) ? 'here': '';
									$url = $config['system']['baseUrl'].'client/'.$client_name.'/';
									$bg_percent = round($row['total'] / $maxClients * 100);
					?>
						<li class="<?= $class ?>">
							<a href="<?= $url ?>">
								<span class="month"><?= $client_name ?></span>
								<span class="total float-right text-muted"><?= $row['c'] ?></span>
								<span class="bar" style="width: <?= $bg_percent ?>%;"></span>
							</a>
						</li>
					<?php
								}
							}
					?>
						<li style="text-align: center">
							<span class="month">...</span>
							<span class="total"></span>
							<span class="bar" style="width: 0%;"></span>
						</li>
					<?php
						} else {
							echo '<li>No clients.</li>';
						}
						?>
					</ul>
				</div><!-- /sources -->

			</div><!-- /.span4 -->

<!-- /index -->
