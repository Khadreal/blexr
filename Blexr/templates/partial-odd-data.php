<?php 
use Symphony\Blexr\Component;

if( !empty( $data ) ) :
foreach ( $data as $event ) : ?>
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
<?php 
endforeach;
else:?>

<tr>
    <td>
        <?php _e( 'No result! Please try again', 'blexr-odd' ); ?>
    </td>
</tr>
<?php endif;  ?>