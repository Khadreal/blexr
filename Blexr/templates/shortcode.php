<?php
use Symphony\Blexr\Component;

$markets = [
	'h2h' => 'Head to head',
	'spreads' => 'Points spread, Handicap',
	'totals' => 'Total points/goals, Over/Under',
	'outrights' => 'Outrights, Futures',
];

$sports = ( new Component )->getSports();

?>

<div class="flex container__width flex-col">
	<form class="flex form-layer blexr__filter" method="GET">
		<div class="flex">
			<label for="sport"><?php _e( 'Sport', 'blexr-odd' ); ?></label>
			<select id="sport" class="form-control" name="sport">
				<?php if( is_array($sports ) ) : ?>
				<?php foreach ($sports as $sport): ?>
					<option value="<?php echo $sport['key']; ?>"><?php echo $sport['title']; ?></option>
				<?php endforeach ?>?>
				<?php else : ?>
				<?php endif; ?>
			</select>
		</div>
		<div class="flex">
			<label for="region"><?php _e( 'Region', 'blexr-odd' ); ?></label>
			<select name="region" id="region" class="form-control">
				<?php foreach( [ 'au' => 'Australia', 'eu' => 'Europe', 'uk' => 'United Kingdom', 'us' => 'United States' ] as $key => $region ) : ?>
				<option value="<?php echo $key; ?>"><?php echo $region ; ?></option>
				<?php endforeach;?>
			</select>
		</div>
		<div class="flex">
			<label for="market"><?php _e( 'Market', 'blexr-odd' );?></label>
			<select name="market" id="market" class="form-control">
				<?php foreach( $markets as $key => $market ) :?>
				<option value="<?php echo $key; ?>"><?php echo $market; ?></option>
				<?php endforeach ;?>
			</select>
		</div>

		<div>
			<input type="submit" class="submit" name="submit" value="<?php esc_attr_e( 'Filter', 'blexr-odd' ); ?>">
		</div>
	</form>
	<table class="table">
		<thead>
			<tr>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $data as $event ) : ?>
			<tr>
				<td>
					<div class="flex flex-col team">
                        <?php echo $event['home_team'] ?>
                        <small>VS</small>
                        <?php echo $event['away_team'] ?>
                        <small> <?php echo ( new Component )->formatDate( $event['commence_time'] ); ?></small>
                    </div>
				</td>
                <td>
                    <table class="table-striped">
                        <tr>
                        <?php foreach( $event['bookmakers'] as $bookmaker ) :?>
                            <td>
                                <span class="bookmaker"><?php echo $bookmaker['title']; ?></span>
                                <div class="prices">
                                <?php foreach( $bookmaker['markets'] as $market ):
                                    foreach( $market['outcomes'] as $outcome ):
                                    ?>
                                    <span><?php echo $outcome['price']; ?></span>
                                <?php endforeach; endforeach; ?>
                                </div>
                            </td>
                        <?php endforeach; ?>
                        </tr>
                    </table>
                </td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>