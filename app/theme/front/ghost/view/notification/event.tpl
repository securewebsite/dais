<table class="contents" style="border-collapse: collapse;border-spacing: 0;width: 100%">
    <tbody>
    	<tr>
	        <td class="padded" style="font-weight:bold;padding:0;vertical-align:top;padding-right:5px"><?= $lang_column_event_name; ?></td>
	        <td class="padded" style="padding:0;vertical-align:top;padding-left:5px;"><?= $event_name; ?></td>
	    </tr>
	    <tr>
	        <td class="padded" style="font-weight:bold;padding:0;vertical-align:top;padding-right:5px"><?= $lang_column_date_time; ?></td>
	        <td class="padded" style="padding:0;vertical-align:top;padding-left:5px;"><?= $event_date; ?> at <?= $event_time; ?></td>
	    </tr>
	    <?php if ($event_location): ?>
	    <tr>
	        <td class="padded" style="font-weight:bold;padding:0;vertical-align:top;padding-right:5px"><?= $lang_column_location; ?></td>
	        <td class="padded" style="padding:0;vertical-align:top;padding-left:5px;"><?= $event_location; ?></td>
	    </tr>
	    <?php endif; ?>
	    <?php if ($event_telephone): ?>
	    <tr>
	        <td class="padded" style="font-weight:bold;padding:0;vertical-align:top;padding-right:5px"><?= $lang_column_telephone; ?></td>
	        <td class="padded" style="padding:0;vertical-align:top;padding-left:5px;"><?= $event_telephone; ?></td>
	    </tr>
	    <?php endif; ?>
	</tbody>
</table>