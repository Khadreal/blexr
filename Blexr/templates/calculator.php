<?php
$formats = [
	'american',
	'decimal',
	'fractal'
];
?>
<div class="flex calc__odds flex-col">
	<h4 class="calc__title">
		<?php _e( 'Enter the stake odds for your bet and the Bet calculator will automatically calculate the payout.', 'blexr-odd' ); ?>
	</h4>
	<div class="flex flex-col">
		<div class="flex align-self_end">
			<label for="format"><?php _e( 'Select odds format:', 'blexr-odd' ); ?></label>
			<select id="region" class="form-control">
				<?php foreach( $formats  as $format ) : ?>
				<option value="<?php echo $format; ?>"><?php echo ucfirst( $format) ; ?></option>
				<?php endforeach;?>
			</select>
		</div>
		<table class="calc__table">
			<thead>
				<tr>
					<th>
						Stake
					</th>
					<th>
						Odds
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="flex">
							<input type="text" class="form-control" placeholder="<?php _e( 'Enter stake', 'blexr-odd' ); ?>">
						</div>
					</td>
					<td>
						<div class="flex">
							<input type="text" class="form-control" name="" placeholder="<?php _e( 'Enter odds', 'blexr-odd' ); ?>">
						</div>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="2" class="flex justify_end">
						<button class="calc__button add__more"><?php _e( 'Add odds', 'blexr-odd' );?></button>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="2" class="flex justify_end">
						<button class="calc__button"><?php _e( 'Calculate payout', 'blexr-odd' );?></button>
						<div class="notf"></div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>